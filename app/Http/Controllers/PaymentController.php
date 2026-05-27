<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseConfirmation;
use App\Models\Purchase;
use App\Services\IzipayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(
        protected IzipayService $izipay
    ) {}

    public function index()
    {
        $cart = session('payment.cart');

        if (!$cart || empty($cart['items'])) {
            return redirect('/carrito')->with('info', 'No hay compras pendientes de pago.');
        }

        $items = collect($cart['items']);
        $totalCents = (int) round($items->sum('amount') * 100);
        $orderId = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        $cart['izipay_order_id'] = $orderId;
        session(['payment.cart' => $cart]);

        try {
            $formToken = $this->izipay->generateFormToken([
                'amount' => $totalCents,
                'orderId' => $orderId,
                'email' => $cart['contact_email'],
                'customerId' => (string) ($cart['user_id'] ?? ''),
                'firstName' => explode(' ', $cart['contact_name'], 2)[0] ?? '',
                'lastName' => explode(' ', $cart['contact_name'], 2)[1] ?? '',
                'phone' => $cart['contact_phone'],
                'identityType' => 'DNI',
                'identityCode' => '',
            ]);

            $publicKey = $this->izipay->getPublicKey();
        } catch (\Throwable $e) {
            Log::error('Izipay formToken error: ' . $e->getMessage());
            return redirect('/carrito')->with('info', 'Error al conectar con la pasarela de pagos. Intenta nuevamente.');
        }

        $total = $items->sum('amount');
        $contact = [
            'name' => $cart['contact_name'],
            'email' => $cart['contact_email'],
            'phone' => $cart['contact_phone'],
        ];

        return view('cart.payment', compact(
            'items', 'total', 'contact', 'formToken', 'publicKey', 'orderId'
        ));
    }

    public function success(Request $request)
    {
        Log::info('success() called', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'has_kr_answer' => $request->has('kr-answer'),
            'input_keys' => array_keys($request->all()),
        ]);

        if ($request->isMethod('post') && !$request->has('kr-answer')) {
            Log::warning('Success POST sin kr-answer', ['input' => $request->all()]);
            return redirect('/carrito')->with('info', 'Error inesperado. Intenta nuevamente.');
        }

        if ($request->isMethod('post') && $request->has('kr-answer')) {
            if (!$this->izipay->verifyHash()) {
                Log::warning('Izipay hash verification failed', $request->all());
                return redirect('/carrito')->with('info', 'Error de validación en la respuesta de pago.');
            }

            $krAnswer = json_decode($request->input('kr-answer'), true);

            Log::info('kr-answer completo', ['kr-answer' => $krAnswer]);

            $orderId = $krAnswer['orderDetails']['orderId'] ?? '';
            $transactionId = $krAnswer['transactions'][0]['uuid'] ?? '';
            $paymentMethod = $krAnswer['paymentMethodDetails']['paymentMethod'] ?? '';
            $transStatus = $krAnswer['transactions'][0]['status'] ?? '';
            $orderStatus = $krAnswer['orderStatus'] ?? '';

            $cart = session('payment.cart');

            if (!$cart || ($cart['izipay_order_id'] ?? '') !== $orderId) {
                Log::warning('Success: carrito no encontrado u orderId no coincide', [
                    'orderId' => $orderId,
                    'has_cart' => !is_null($cart),
                ]);
                return redirect('/carrito')->with('info', 'Sesión expirada. Tu pago se procesará automáticamente.');
            }

            Log::info('Izipay success', [
                'transaction_id' => $transactionId,
                'orderId' => $orderId,
                'orderStatus' => $orderStatus,
                'transStatus' => $transStatus,
            ]);

            if ($orderStatus === 'PAID') {
                $purchaseIds = [];

                foreach ($cart['items'] as $item) {
                    $purchase = Purchase::create([
                        'user_id' => $cart['user_id'],
                        'course_id' => $item['course_id'],
                        'amount' => $item['amount'],
                        'status' => 'activo',
                        'transaction_id' => $transactionId,
                        'payment_method' => $paymentMethod,
                        'payment_status' => $transStatus,
                        'izipay_order_id' => $orderId,
                        'contact_name' => $cart['contact_name'],
                        'contact_email' => $cart['contact_email'],
                        'contact_phone' => $cart['contact_phone'],
                        'purchased_at' => now(),
                        'completed_at' => now(),
                    ]);

                    $purchaseIds[] = $purchase->id;
                }

                $items = collect($cart['items']);
                $total = $items->sum('amount');

                try {
                    Mail::to($cart['contact_email'])->send(
                        new PurchaseConfirmation(
                            contactName: $cart['contact_name'],
                            contactEmail: $cart['contact_email'],
                            items: $items->toArray(),
                            total: $total,
                        )
                    );
                } catch (\Throwable $e) {
                    Log::error('Purchase confirmation email error: ' . $e->getMessage());
                }

                session()->forget('payment.cart');
                session(['payment.purchase_ids' => $purchaseIds]);

                return redirect()->route('checkout.success');
            }

            session()->forget('payment.cart');
            Log::info('Pago no exitoso', ['orderId' => $orderId, 'orderStatus' => $orderStatus, 'transStatus' => $transStatus]);
            return redirect('/carrito')->with('info', 'El pago no pudo ser procesado. Intenta nuevamente.');
        }

        $purchaseIds = session('payment.purchase_ids');
        session()->forget('payment.purchase_ids');

        $purchases = $purchaseIds ? Purchase::whereIn('id', $purchaseIds)->get() : collect();

        $hasRealPayment = $purchases->contains(fn($p) => !empty($p->transaction_id));

        if (!$hasRealPayment) {
            Log::warning('GET success sin pago real', ['purchase_ids' => $purchaseIds]);
            return redirect('/carrito')->with('info', 'El pago no se completó. Intenta nuevamente.');
        }

        $total = $purchases->sum(fn($p) => $p->amount ?? 0);
        $courseNames = $purchases->map(fn($p) => $p->course->title ?? '')->implode(', ');
        $contact = $purchases->first();

        $message = "Hola, soy {$contact?->contact_name}. Acabo de pagar S/ " . number_format($total, 0) . " por: {$courseNames}. Mi correo es {$contact?->contact_email}.";
        $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . config('izipay.whatsapp_phone') . '&text=' . urlencode($message);

        $items = $purchases->map(fn($p) => [
            'title' => $p->course->title ?? 'Curso',
            'amount' => $p->amount ?? 0,
        ]);

        return view('cart.confirmacion', [
            'wsp' => $whatsappUrl,
            'success' => true,
            'total' => $total,
            'items' => $items,
            'contact_name' => $contact?->contact_name,
            'contact_email' => $contact?->contact_email,
        ]);
    }

    public function ipn(Request $request)
    {
        $data = $request->all();
        Log::info('Izipay IPN', $data);

        $krAnswer = $data['kr-answer'] ?? null;
        if (!$krAnswer) {
            return response()->json(['error' => 'Invalid IPN'], 400);
        }

        $answer = is_string($krAnswer) ? json_decode($krAnswer, true) : $krAnswer;
        $orderId = $answer['orderDetails']['orderId'] ?? '';
        $transactionId = $answer['transactions'][0]['uuid'] ?? '';
        $paymentMethod = $answer['paymentMethodDetails']['paymentMethod'] ?? '';
        $transStatus = $answer['transactions'][0]['status'] ?? '';

        $purchases = Purchase::where('izipay_order_id', $orderId)->get();

        if ($purchases->isEmpty()) {
            Log::warning('IPN: No purchases for orderId: ' . $orderId);
            return response()->json(['error' => 'Order not found'], 404);
        }

        $newStatus = match ($transStatus) {
            'PAID', 'SUCCESS', 'AUTHORISED' => 'activo',
            'CANCELLED', 'REFUSED', 'ERROR' => 'rechazado',
            default => 'rechazado',
        };

        foreach ($purchases as $purchase) {
            $purchase->update([
                'transaction_id' => $transactionId,
                'payment_method' => $paymentMethod,
                'payment_status' => $transStatus,
                'status' => $newStatus,
                'completed_at' => $newStatus === 'activo' ? now() : $purchase->completed_at,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function cancel(Request $request)
    {
        session()->forget('payment.cart');
        $purchaseIds = session('payment.purchase_ids');
        session()->forget('payment.purchase_ids');

        $isPaymentError = $request->isMethod('post') && $request->has('kr-answer');

        if ($isPaymentError) {
            $krAnswer = json_decode($request->input('kr-answer'), true);
            Log::info('Pago rechazado por 3DS2', [
                'orderId' => $krAnswer['orderDetails']['orderId'] ?? '',
                'transStatus' => $krAnswer['transactions'][0]['status'] ?? '',
                'message' => $krAnswer['errorMessage'] ?? $krAnswer['errorCode'] ?? '',
                'kr-answer' => $krAnswer,
            ]);
        }

        if ($purchaseIds) {
            Purchase::whereIn('id', $purchaseIds)->update([
                'status' => $isPaymentError ? 'rechazado' : 'cancelado',
            ]);
        }

        $message = $isPaymentError
            ? 'El pago fue rechazado. Intenta con otra tarjeta o medio de pago.'
            : 'Pago cancelado. Puedes intentar nuevamente cuando quieras.';

        return redirect('/carrito')->with('info', $message);
    }
}

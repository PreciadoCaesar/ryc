<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->resolveCart();

        if ($cart->items->isEmpty()) {
            return redirect('/carrito')->with('info', 'Tu carrito está vacío');
        }

        foreach ($cart->items as $item) {
            $currentPrice = $item->course->precio_flash ?? $item->course->precio_regular ?? 0;
            if ((float) $currentPrice !== (float) $item->price) {
                $item->update(['price' => $currentPrice]);
            }
        }
        $cart->load('items');

        return view('cart.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = $this->resolveCart();

        if ($cart->items->isEmpty()) {
            return redirect('/carrito')->with('info', 'Tu carrito está vacío');
        }

        $data = $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
        ]);

        foreach ($cart->items as $item) {
            $currentPrice = $item->course->precio_flash ?? $item->course->precio_regular ?? 0;
            if ((float) $currentPrice !== (float) $item->price) {
                $item->update(['price' => $currentPrice]);
            }
        }
        $cart->load('items');

        $items = $cart->items->map(fn($item) => [
            'course_id' => $item->course_id,
            'amount' => $item->price,
            'title' => $item->course->title,
        ])->toArray();

        session(['payment.cart' => [
            'items' => $items,
            'contact_name' => $data['contact_name'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'],
            'user_id' => auth()->id(),
        ]]);

        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('checkout.payment');
    }

    public function confirmacion(Request $request)
    {
        $wsp = $request->query('wsp');
        return view('cart.confirmacion', compact('wsp'));
    }

    private function resolveCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => session()->getId()]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => session()->getId()],
            ['user_id' => null]
        );
    }
}

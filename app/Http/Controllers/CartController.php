<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->resolveCart();
        $priceChanges = [];

        foreach ($cart->items as $item) {
            $currentPrice = $item->course->precio_flash ?? $item->course->precio_regular ?? 0;

            if ((float) $currentPrice !== (float) $item->price) {
                $priceChanges[] = [
                    'title' => $item->course->title,
                    'old' => number_format($item->price, 0),
                    'new' => number_format($currentPrice, 0),
                ];
                $item->update(['price' => $currentPrice]);
            }
        }

        return view('cart.index', compact('cart', 'priceChanges'));
    }

    public function add(Course $course)
    {
        $cart = $this->resolveCart();

        if ($cart->items()->where('course_id', $course->id)->exists()) {
            return back()->with('added_to_cart', $course->title)->with('already_in_cart', true);
        }

        $price = $course->precio_flash ?? $course->precio_regular ?? 0;

        $cart->items()->create([
            'course_id' => $course->id,
            'price' => $price,
        ]);

        return back()->with('added_to_cart', $course->title);
    }

    public function buy(Course $course)
    {
        $cart = $this->resolveCart();

        if (!$cart->items()->where('course_id', $course->id)->exists()) {
            $price = $course->precio_flash ?? $course->precio_regular ?? 0;
            $cart->items()->create([
                'course_id' => $course->id,
                'price' => $price,
            ]);
        }

        return redirect()->route('checkout.index');
    }

    public function remove(CartItem $item)
    {
        $cart = $this->resolveCart();

        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Curso eliminado del carrito');
    }

    public function precios()
    {
        $cart = $this->resolveCart();

        $items = $cart->items->map(fn($item) => [
            'id' => $item->id,
            'title' => $item->course->title,
            'price_actual' => (float) ($item->course->precio_flash ?? $item->course->precio_regular ?? 0),
            'price_stored' => (float) $item->price,
        ]);

        $totalActual = $items->sum('price_actual');

        return response()->json([
            'items' => $items,
            'total' => $totalActual,
        ]);
    }

    public function clear()
    {
        $cart = $this->resolveCart();
        $cart->items()->delete();

        return back()->with('success', 'Carrito vaciado');
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

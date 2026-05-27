@extends('layouts.app-main')

@section('title', 'Carrito de Compras | R&C Consulting')

@section('styles')
<style>
    .cart-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .cart-title {
        font-size: 28px;
        font-weight: 700;
        color: #0A1F5C;
        margin-bottom: 30px;
    }
    .cart-empty {
        text-align: center;
        padding: 60px 20px;
    }
    .cart-empty i {
        font-size: 64px;
        color: #ccc;
        margin-bottom: 20px;
    }
    .cart-empty h3 {
        color: #555;
        margin-bottom: 10px;
    }
    .cart-empty p {
        color: #888;
        margin-bottom: 20px;
    }
    .cart-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        margin-bottom: 15px;
        background: #fff;
        transition: box-shadow 0.3s;
    }
    .cart-item:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .cart-item-img {
        width: 100px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }
    .cart-item-info {
        flex: 1;
    }
    .cart-item-title {
        font-size: 16px;
        font-weight: 600;
        color: #0A1F5C;
        margin-bottom: 4px;
    }
    .cart-item-type {
        font-size: 13px;
        color: #888;
    }
    .cart-item-price {
        font-size: 18px;
        font-weight: 700;
        color: #FF044D;
        flex-shrink: 0;
    }
    .cart-item-remove {
        color: #dc3545;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        padding: 8px;
        transition: opacity 0.3s;
    }
    .cart-item-remove:hover {
        opacity: 0.7;
    }
    .cart-summary {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-top: 20px;
    }
    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        padding: 8px 0;
    }
    .cart-summary-total {
        font-size: 22px;
        font-weight: 700;
        color: #0A1F5C;
        border-top: 2px solid #dee2e6;
        padding-top: 12px;
        margin-top: 8px;
    }
    .btn-checkout {
        display: inline-block;
        background: #FF044D;
        color: #fff;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: opacity 0.3s;
        margin-top: 20px;
    }
    .btn-checkout:hover {
        color: #fff;
        opacity: 0.9;
    }
    .btn-continue {
        display: inline-block;
        color: #0A1F5C;
        font-weight: 600;
        text-decoration: none;
        margin-top: 15px;
    }
    .btn-continue:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="cart-container">
    <h1 class="cart-title">Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if(!empty($priceChanges))
        <div class="alert alert-warning">
            <strong><i class="fas fa-exclamation-triangle"></i> Cambios de precio detectados:</strong>
            <ul class="mb-0 mt-2">
                @foreach($priceChanges as $change)
                    <li>
                        <strong>{{ $change['title'] }}</strong>:
                        Antes S/ {{ $change['old'] }}, ahora S/ {{ $change['new'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($cart->items->isEmpty())
        <div class="cart-empty">
            <i class="fas fa-shopping-cart"></i>
            <h3>Tu carrito está vacío</h3>
            <p>Agrega cursos y diplomados para comenzar tu inscripción.</p>
            <a href="/ryc/" class="btn-checkout">Ver Cursos</a>
        </div>
    @else
        @foreach($cart->items as $item)
            <div class="cart-item">
                <img src="{{ asset($item->course->image_promotion ?? $item->course->image ?? 'img/curso/default.svg') }}"
                     alt="{{ $item->course->title }}"
                     class="cart-item-img">
                <div class="cart-item-info">
                    <div class="cart-item-title">{{ $item->course->title }}</div>
                    <div class="cart-item-type">
                        {{ ucfirst($item->course->mode === 'en_vivo' ? 'En Vivo' : 'Virtual') }}
                        &middot; {{ ucfirst($item->course->type) }}
                    </div>
                </div>
                <div class="cart-item-price">S/ {{ number_format($item->price, 0) }}</div>
                <form action="/ryc/carrito/eliminar/{{ $item->id }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="cart-item-remove" title="Eliminar">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        @endforeach

        <div class="cart-summary">
            <div class="cart-summary-row">
                <span>Subtotal ({{ $cart->items->count() }} {{ $cart->items->count() === 1 ? 'curso' : 'cursos' }})</span>
                <span>S/ {{ number_format($cart->items->sum('price'), 0) }}</span>
            </div>
            <div class="cart-summary-row cart-summary-total">
                <span>Total</span>
                <span>S/ {{ number_format($cart->items->sum('price'), 0) }}</span>
            </div>
        </div>

        <div style="text-align:center">
            <a href="/ryc/checkout" class="btn-checkout">Proceder al Pago</a>
            <br>
            <a href="/ryc/" class="btn-continue">&larr; Seguir comprando</a>
        </div>

        <form action="/ryc/carrito/vaciar" method="POST" style="text-align:center; margin-top:15px;">
            @csrf
            <button type="submit" class="btn btn-link text-muted" style="font-size:13px;">Vaciar carrito</button>
        </form>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function checkPrices() {
        fetch('/ryc/carrito/precios')
            .then(r => r.json())
            .then(data => {
                let changed = false;
                data.items.forEach(item => {
                    if (item.price_actual !== item.price_stored) {
                        changed = true;
                    }
                });
                if (changed) {
                    location.reload();
                }
            })
            .catch(() => {});
    }

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) checkPrices();
    });

    setInterval(checkPrices, 60000);
});
</script>
@endpush
@endsection

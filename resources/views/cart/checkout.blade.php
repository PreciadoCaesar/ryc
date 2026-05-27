@extends('layouts.app-main')

@section('title', 'Checkout | R&C Consulting')

@section('styles')
<style>
    .checkout-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .checkout-title {
        font-size: 28px;
        font-weight: 700;
        color: #0A1F5C;
        margin-bottom: 30px;
    }
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
    .checkout-section {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 25px;
    }
    .checkout-section h3 {
        font-size: 18px;
        font-weight: 600;
        color: #0A1F5C;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #d0d0d0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    .form-group input:focus {
        outline: none;
        border-color: #5044c2;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .order-total {
        display: flex;
        justify-content: space-between;
        font-size: 20px;
        font-weight: 700;
        color: #0A1F5C;
        padding-top: 15px;
        margin-top: 10px;
        border-top: 2px solid #e0e0e0;
    }
    .checkout-notice {
        font-size: 13px;
        color: #888;
        margin-top: 15px;
        padding: 12px;
        background: #fff3cd;
        border-radius: 8px;
        color: #856404;
    }
    .btn-confirmar {
        display: block;
        width: 100%;
        background: #25D366;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: opacity 0.3s;
        margin-top: 20px;
    }
    .btn-confirmar:hover {
        opacity: 0.9;
        color: #fff;
    }
    .btn-confirmar i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="checkout-container">
    <h1 class="checkout-title">Confirmar Inscripción</h1>

    <form method="POST" action="/ryc/checkout">
        @csrf
        <div class="checkout-grid">
            <div class="checkout-section">
                <h3><i class="fas fa-user"></i> Tus Datos</h3>

                <div class="form-group">
                    <label for="contact_name">Nombre completo *</label>
                    <input type="text" name="contact_name" id="contact_name"
                           value="{{ old('contact_name', auth()->user()->name ?? '') }}"
                           required maxlength="255">
                    @error('contact_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="contact_email">Correo electrónico *</label>
                    <input type="email" name="contact_email" id="contact_email"
                           value="{{ old('contact_email', auth()->user()->email ?? '') }}"
                           required maxlength="255">
                    @error('contact_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="contact_phone">Teléfono / WhatsApp *</label>
                    <input type="text" name="contact_phone" id="contact_phone"
                           value="{{ old('contact_phone') }}"
                           required maxlength="20" placeholder="Ej: 987654321">
                    @error('contact_phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="checkout-notice">
                    <i class="fas fa-info-circle"></i>
                    Al confirmar podrás pagar de forma segura con Visa, Mastercard, American Express o Yape.
                    Si ya iniciaste sesión con Google, tus datos se cargarán automáticamente.
                </div>
            </div>

            <div class="checkout-section">
                <h3><i class="fas fa-shopping-cart"></i> Resumen del Pedido</h3>

                @foreach($cart->items as $item)
                    <div class="order-item">
                        <span>{{ $item->course->title }}</span>
                        <span>S/ {{ number_format($item->price, 0) }}</span>
                    </div>
                @endforeach

                <div class="order-total">
                    <span>Total</span>
                    <span>S/ {{ number_format($cart->items->sum('price'), 0) }}</span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-confirmar" style="background:#5044c2;">
            <i class="fas fa-lock"></i> Confirmar y pagar
        </button>
    </form>
</div>
@endsection

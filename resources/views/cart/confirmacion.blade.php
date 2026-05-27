@extends('layouts.app-main')

@section('title', isset($success) && $success ? 'Gracias por tu compra | R&C Consulting' : 'Solicitud Enviada | R&C Consulting')

@section('styles')
<style>
    .confirmacion-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 0 20px;
        text-align: center;
    }
    .confirmacion-icon {
        font-size: 72px;
        color: #25D366;
        margin-bottom: 20px;
    }
    .confirmacion-icon.success {
        color: #5044c2;
    }
    .confirmacion-title {
        font-size: 28px;
        font-weight: 700;
        color: #0A1F5C;
        margin-bottom: 15px;
    }
    .confirmacion-text {
        font-size: 16px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .confirmacion-details {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        text-align: left;
    }
    .confirmacion-details h3 {
        font-size: 16px;
        font-weight: 600;
        color: #0A1F5C;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e0e0e0;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 6px 0;
    }
    .detail-row.total {
        font-weight: 700;
        font-size: 16px;
        color: #0A1F5C;
        border-top: 2px solid #e0e0e0;
        padding-top: 10px;
        margin-top: 8px;
    }
    .confirmacion-contact {
        font-size: 14px;
        color: #888;
        margin-bottom: 20px;
    }
    .btn-wsp {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #25D366;
        color: #fff;
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: opacity 0.3s;
        margin-bottom: 20px;
    }
    .btn-wsp:hover {
        color: #fff;
        opacity: 0.9;
    }
    .btn-primary {
        display: inline-block;
        background: #5044c2;
        color: #fff;
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: opacity 0.3s;
        margin-bottom: 20px;
    }
    .btn-primary:hover {
        color: #fff;
        opacity: 0.9;
    }
    .btn-volver {
        display: inline-block;
        color: #5044c2;
        font-weight: 600;
        text-decoration: none;
        margin-top: 10px;
    }
    .btn-volver:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="confirmacion-container">
    @if(isset($success) && $success)
        <div class="confirmacion-icon success">
            <i class="fas fa-check-circle"></i>
        </div>

        <h1 class="confirmacion-title">¡Gracias por tu compra!</h1>

        <p class="confirmacion-text">
            Hola <strong>{{ $contact_name ?? '' }}</strong>, tu pago ha sido procesado correctamente.<br>
            En breve recibirás un correo con los detalles de tu inscripción.
        </p>

        @if(isset($items) && $items->isNotEmpty())
        <div class="confirmacion-details">
            <h3><i class="fas fa-receipt"></i> Resumen de tu compra</h3>
            @foreach($items as $item)
                <div class="detail-row">
                    <span>{{ $item['title'] }}</span>
                    <span style="color:#FF044D;font-weight:600;">S/ {{ number_format($item['amount'], 0) }}</span>
                </div>
            @endforeach
            <div class="detail-row total">
                <span>Total pagado</span>
                <span>S/ {{ number_format($total, 0) }}</span>
            </div>
        </div>
        @endif

        @if(isset($contact_email))
        <div class="confirmacion-contact">
            <i class="fas fa-envelope"></i> {{ $contact_email }}
        </div>
        @endif

        <a href="/ryc/" class="btn-primary">
            <i class="fas fa-home"></i> Ir al inicio
        </a>
    @else
        <div class="confirmacion-icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <h1 class="confirmacion-title">¡Solicitud Enviada!</h1>

        <p class="confirmacion-text">
            Hemos recibido tu solicitud de inscripción.<br>
            Haz clic en el botón de abajo para comunicarte con nosotros por WhatsApp
            y coordinar el pago de tu matrícula.
        </p>

        @if(isset($wsp))
        <a href="{{ $wsp }}" target="_blank" class="btn-wsp">
            <i class="fab fa-whatsapp"></i> Ir a WhatsApp
        </a>
        @endif
    @endif

    <br>
    <a href="/ryc/" class="btn-volver">&larr; Volver al inicio</a>
</div>
@endsection

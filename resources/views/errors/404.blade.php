@extends('layouts.app-main')

@section('title', 'Página no encontrada - R&C Consulting')

@section('meta')
    <meta http-equiv="refresh" content="6;url={{ url('/') }}">
@endsection

@section('content')
<style>
    .error-404-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        background: #1a1a1a;
    }

    .error-404-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('{{ asset("lottie/404.gif") }}') 55% center / 110% auto no-repeat;
        opacity: 0.5;
        pointer-events: none;
    }

    .error-404-container::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.85) 0%, rgba(26, 26, 26, 0.6) 50%, rgba(26, 26, 26, 0.85) 100%);
        pointer-events: none;
    }

    .error-404-card {
        text-align: center;
        max-width: 600px;
        width: 100%;
        position: relative;
        z-index: 1;
        padding: 2.5rem;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .error-404-animations {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin: 0 auto 2rem;
    }

    .error-404-lottie {
        width: 100%;
        max-width: 340px;
        filter: drop-shadow(0 10px 30px rgba(80, 68, 194, 0.1));
    }

    .error-404-lottie lottie-player {
        width: 100%;
        height: auto;
    }

    .error-404-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        color: #ffffff;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .error-404-title span {
        color: #a78bfa;
    }

    .error-404-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .error-404-countdown {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.85rem 1.75rem;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        margin-bottom: 2rem;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .error-404-countdown .countdown-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #a78bfa, #7c3aed);
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-family: 'Poppins', sans-serif;
        transition: transform 0.3s ease;
    }

    .error-404-countdown .countdown-number.pulse {
        animation: countdownPulse 1s ease-in-out;
    }

    @keyframes countdownPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .error-404-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-404-home {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 2rem;
        background: linear-gradient(135deg, #5044c2, #6c5ce7);
        color: white;
        border: none;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(80, 68, 194, 0.3);
        cursor: pointer;
    }

    .btn-404-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(80, 68, 194, 0.4);
        color: white;
    }

    .btn-404-home:active {
        transform: translateY(0);
    }

    .btn-404-home svg {
        width: 18px;
        height: 18px;
        transition: transform 0.3s ease;
    }

    .btn-404-home:hover svg {
        transform: translateX(-3px);
    }

    .error-404-card .countdown-icon {
        width: 20px;
        height: 20px;
        stroke: rgba(255, 255, 255, 0.6);
    }

    @media (max-width: 768px) {
        .error-404-container {
            min-height: 70vh;
            padding: 1rem;
        }

        .error-404-card {
            padding: 1.75rem;
        }

        .error-404-lottie {
            max-width: 280px;
            margin-bottom: 1.5rem;
        }

        .error-404-title {
            font-size: 1.5rem;
        }

        .error-404-subtitle {
            font-size: 0.95rem;
        }

        .error-404-countdown {
            font-size: 0.85rem;
            padding: 0.7rem 1.25rem;
        }

        .error-404-countdown .countdown-number {
            width: 30px;
            height: 30px;
            font-size: 1rem;
        }

        .btn-404-home {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .error-404-card {
            padding: 1.25rem;
        }

        .error-404-lottie {
            max-width: 220px;
        }

        .error-404-title {
            font-size: 1.25rem;
        }
    }
</style>

<div class="error-404-container">
    <!-- Decorative elements -->
    <div class="error-404-decoration error-404-decoration-1"></div>
    <div class="error-404-decoration error-404-decoration-2"></div>
    <div class="error-404-decoration error-404-decoration-3"></div>

    <div class="error-404-card">
        <!-- Lottie Animation -->
        <div class="error-404-animations">
            <div class="error-404-lottie">
                <lottie-player
                    src="{{ asset('lottie/404.json') }}"
                    background="transparent"
                    speed="1"
                    loop
                    autoplay
                ></lottie-player>
            </div>
        </div>

        <!-- Title -->
        <h1 class="error-404-title">
            ¡Ups! Página no <span>encontrada</span>
        </h1>

        <!-- Subtitle -->
        <p class="error-404-subtitle">
            La página que buscas no existe o ha sido movida.<br>
            Te redirigiremos al inicio en unos segundos.
        </p>

        <!-- Countdown -->
        <div class="error-404-countdown" id="countdownContainer">
            <svg class="countdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>Redirigiendo al inicio en</span>
            <span class="countdown-number" id="countdownNumber">5</span>
            <span>segundos</span>
        </div>

        <!-- Actions -->
        <div class="error-404-actions">
            <a href="{{ url('/') }}" class="btn-404-home">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Volver al inicio
            </a>
        </div>
    </div>
</div>

<!-- Lottie Player Script -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@2.0.3/dist/lottie-player.js"></script>

<!-- Countdown & Redirect Script -->
<noscript>
    <div style="text-align:center;padding:2rem;font-family:'Montserrat',sans-serif;color:#666;">
        Serás redirigido al inicio en unos segundos...
        <br><br>
        <a href="{{ url('/') }}" style="color:#5044c2;font-weight:600;">Haz clic aquí si no eres redirigido</a>
    </div>
</noscript>

<script>
(function() {
    const countdownEl = document.getElementById('countdownNumber');
    let secondsLeft = 5;

    const interval = setInterval(function() {
        countdownEl.textContent = secondsLeft;
        countdownEl.classList.remove('pulse');
        void countdownEl.offsetWidth;
        countdownEl.classList.add('pulse');

        if (secondsLeft <= 0) {
            clearInterval(interval);
            window.location.href = '{{ url("/") }}';
            return;
        }

        secondsLeft--;
    }, 1000);
})();
</script>
@endsection

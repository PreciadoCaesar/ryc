<style>
    /* ═════════ BANNER PÚRPURA ═════════ */
    .banner-purpura {
        background: linear-gradient(135deg, #5044c2 0%, #3d2db5 100%);
        padding: 10px 0;
        width: 100%;
    }

    .inner-wrap {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .contenido-banner-purpura {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }

    .banner-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .banner-icon img {
        width: 35px;
        height: 35px;
        filter: brightness(0) invert(1);
    }

    .banner-text {
        display: flex;
        flex-direction: column;
    }

    .banner-text b {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }

    .banner-text b.highlight-yellow {
        color: #FFD700;
    }

    .banner-text span {
        color: rgba(255, 255, 255, 0.85);
        font-size: 12px;
        font-weight: 400;
    }

    .banner-action .btn-cotizar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ebdc10;
        color: #5044c2 !important;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .banner-action .btn-cotizar:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
    }

    /* ═════════ NAVBAR ═════════ */
    .rc-navbar {
        width: 100%;
        background: #ffffff;
        position: sticky;
        top: 0;
        z-index: 999;
        padding: 10px 0;
        margin: 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .rc-navbar .container {
        max-width: 100% !important;
        padding-left: 20px;
        padding-right: 20px;
    }

    .rc-logo {
        height: 45px;
    }

    .rc-navbar .nav-link {
        color: #000000 !important;
        font-weight: 600;
        font-size: 14px;
        padding: 18px 22px !important;
        transition: 0.3s;
        white-space: nowrap;
    }

    .rc-navbar .nav-link:hover {
        opacity: 0.7;
    }

    .rc-navbar .dropdown-menu {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 0;
        margin-top: 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .rc-navbar .dropdown-item {
        color: #000000;
        padding: 10px 20px;
        font-size: 14px;
        transition: 0.3s;
    }

    .rc-navbar .dropdown-item:hover {
        background: #f5f5f5;
        color: #000000;
    }

    .rc-navbar .navbar-nav {
        flex-grow: 1;
        justify-content: space-evenly;
        margin: 0 30px;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        filter: none;
    }

    /* ═════════ BOTONES ═════════ */
    .rc-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .rc-buttons a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        color: #ffffff;
        transition: 0.3s;
        white-space: nowrap;
    }

    .rc-buttons svg {
        width: 18px;
        height: 18px;
        display: block;
    }

    .btn-wsp { background: #038814; }
    .btn-aula { background: #136EF0; }
    .btn-tienda { background: #FF044D; }

    .btn-login { background: #4285F4; }
    .btn-login:hover { background: #3367D6; }

    .btn-account {
        background: #6c757d;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
    }
    .btn-account:hover { background: #5a6268; }

    .account-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
    }

    .account-name {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-logout {
        background: #dc3545;
        padding: 8px 12px;
    }
    .btn-logout:hover { background: #c82333; }

    .rc-buttons a:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .rc-buttons {
            flex-direction: column;
            margin-top: 15px;
            width: 100%;
        }
        .rc-buttons a {
            width: 100%;
            justify-content: center;
        }
        .rc-navbar .navbar-nav {
            margin: 0;
        }
        .rc-navbar .nav-link {
            padding: 12px 15px !important;
        }
    }

    @media (max-width: 768px) {
        .contenido-banner-purpura {
            flex-direction: column;
            text-align: center;
        }
        .banner-item {
            justify-content: center;
        }
        .banner-text {
            align-items: center;
        }
    }
</style>

<div class="banner-purpura">
    <div class="inner-wrap">
        <div class="contenido-banner-purpura">
            <div class="banner-item">
                <div class="banner-icon">
                    <img src="{{ asset('img/icons/casa.svg') }}" alt="PDP">
                </div>
                <div class="banner-text">
                    <b>Cumple con el PDP 2026</b>
                    <span>Alinea tu capacitación In-House</span>
                </div>
            </div>

            <div class="banner-item">
                <div class="banner-icon">
                    <img src="{{ asset('img/icons/merito.svg') }}" alt="Directiva">
                </div>
                <div class="banner-text">
                    <b class="highlight-yellow">CURSOS IN HOUSE</b>
                    <span>Nueva Directiva 00214-2025-SERVIR-PE</span>
                </div>
            </div>

            <div class="banner-action">
                <a href="https://api.whatsapp.com/send?phone=51950883155&text=Solicito%20Informaci%C3%B3n%20sobre%20las%20capacitaciones"
                    class="btn-cotizar" target="_blank">
                    <i class="fas fa-handshake"></i> ¡Cotízalo aquí!
                </a>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg rc-navbar">
    <div class="container">
        <a class="navbar-brand" href="/ryc/">
            <img src="{{ asset('img/logo-rc-consulting-sin-fondo.webp') }}" class="rc-logo" alt="R&C Consulting">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto w-100 justify-content-evenly">
                <li class="nav-item">
                    <a class="nav-link" href="/ryc/">Inicio</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Nosotros</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/ryc/nosotros">Sobre Nosotros</a></li>
                        <li><a class="dropdown-item" href="/ryc/experiencia">Experiencia y Alianzas</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Programas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/ryc/cursos-virtuales/">Cursos</a></li>
                        <li><a class="dropdown-item" href="/ryc/diplomas-virtuales/">Diplomados</a></li>
                        <li><a class="dropdown-item" href="https://www.rc-consulting.edu.pe/">Aula Virtual</a></li>
                        <li><a class="dropdown-item" href="/ryc/suscripciones/">Membresía Premium</a></li>
                        <li><a class="dropdown-item" href="/ryc/preguntas-frecuentes/">Preguntas Frecuentes</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/ryc/cursos-inhouse">In House</a>
                </li>
            </ul>

            <div class="rc-buttons">
                @guest
                    <a href="{{ route('auth.google') }}" class="btn-login">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M15.545 6.033a9.3 9.3 0 0 0-2.454-4.787 9.3 9.3 0 0 0-4.787-2.454A9.3 9.3 0 0 0 .1 6.033a9.3 9.3 0 0 0 2.454 4.788 9.3 9.3 0 0 0 4.787 2.454 9.3 9.3 0 0 0 4.788-2.454 9.3 9.3 0 0 0 2.454-4.788zM8 12.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"/>
                            <path d="M8 4.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7z"/>
                        </svg>
                        Iniciar Sesión
                    </a>
                @else
                    <a href="{{ in_array(auth()->user()->rol, ['dios', 'desarrollador', 'gerente', 'asesora']) ? route('admin.dashboard') : route('perfil') }}"
                       class="btn-account" title="{{ auth()->user()->name }}">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="account-avatar">
                        @else
                            <i class="fas fa-user-circle"></i>
                        @endif
                        <span class="account-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </a>
                    <a href="{{ route('auth.logout') }}" class="btn-logout" title="Salir">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                @endguest

                <a href="https://api.whatsapp.com/send?phone=51950883155" target="_blank" class="btn-wsp">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                    </svg>
                    950 883 155
                </a>
                <a href="https://www.rc-consulting.edu.pe/" target="_blank" class="btn-aula">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0" />
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                        <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z" />
                    </svg>
                    Aula Virtual
                </a>
                <a href="/ryc/carrito" class="btn-tienda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                    </svg>
                    Carrito de compras
                </a>
            </div>
        </div>
    </div>
</nav>

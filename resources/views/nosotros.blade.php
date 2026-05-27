@extends('layouts.app-main')

@section('title', 'Sobre Nosotros | R&C Consulting')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/nosotros/styles.css') }}">
@endsection

@section('content')

<!-- SECCION 1: INTRODUCCION-->
<section class="hero" id="inicio">
    <div class="inner-wrap">
        <div class="hero-container-flex">

            <div class="hero-text">

                <p class="hero-pretitle">Transformación continua y</p>
                <h1>EDUCACIÓN PARA <br><span>TRANSFORMAR EL PERÚ</span></h1>
                <p class="hero-sub">
                    +23 años fortaleciendo equipos del sector público con formación aplicada y certificable.
                </p>

                <div class="hero-stats-footer">
                    <div class="h-stat">
                        <img src="{{ asset('img/icons/clase.svg') }}" class="clase-icon" />
                        <div class="h-stat-info">
                            <p id="trayectoria">Trayectoria</p>
                            <strong id="edad">+23 años</strong>
                            <span id="capacitando">Capacitando al sector público</span>
                        </div>
                    </div>

                    <div class="h-stat">
                        <img src="{{ asset('img/icons/merito.svg') }}" class="clase-icon" />
                        <div class="h-stat-info">
                            <p id="trayectoria">Certificación</p>
                            <strong id="edad">+30.000</strong>
                            <span id="capacitando">Certificados emitidos</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="video-thumbnail">
                    <img src="tu-imagen-aqui.jpg" alt="Miniatura">
                    <div class="video-text-overlay">
                        <h2>¿Qué es la <span>Gestión de Trámite Documentario</span> en una entidad?</h2>
                    </div>
                    <div class="video-logo">R&C CONSULTING</div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECCION 2: MISION Y VISION --> 
<section class="about-us-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold font-poppins">Acerca de nosotros</h2>
            <p class="text-muted">Trayectoria y compromiso con el fortalecimiento de la gestión pública.</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="about-card main-card d-flex flex-column flex-lg-row">
                    <div class="card-image">
                        <img src="{{ asset('img/historia.png') }}" alt="Equipo R&C Consulting" class="img-fluid">
                    </div>
                    <div class="card-content p-4 p-lg-5 d-flex flex-column justify-content-center">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('img/icons/myv/1.png') }}" alt="Icono Historia" class="custom-icon me-3">
                            <h3 class="fw-bold m-0 font-poppins sub-names">Historia</h3>
                        </div>
                        <div class="about-text">
                            <p>R&C Consulting fue creada el 10 de abril de 2003 por Yolanda Carpio y Misael Rivera, con el propósito de fortalecer la gestión pública a través de capacitación especializada y asistencia técnica.</p>
                            <p>Desde sus inicios, la institución apostó por el talento joven y la excelencia profesional, integrando especialistas con experiencia en entidades públicas para diseñar programas alineados a las necesidades reales del Estado.</p>
                            <p>Hoy, con 23 años de trayectoria, R&C Consulting cuenta con un equipo multidisciplinario y una red de más de 200 expositores, desarrollando programas que fortalecen las competencias de los servidores públicos y mejoran el desempeño institucional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="about-card p-4 p-lg-5">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('img/icons/myv/2.png') }}" alt="Icono Misión" class="custom-icon me-3">
                        <h3 class="fw-bold m-0 font-poppins sub-names">Misión</h3>
                    </div>
                    <p class="about-text m-0">Desarrollamos y transformamos vidas con el poder de la educación, añadiendo valor en las personas al perfeccionar sus dones y talentos, para aprovechar las oportunidades y convertirlos líderes en el mundo.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-card p-4 p-lg-5">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('img/icons/myv/3.png') }}" alt="Icono Visión" class="custom-icon me-3">
                        <h3 class="fw-bold m-0 font-poppins sub-names">Visión</h3>
                    </div>
                    <p class="about-text m-0">Ser considerados por nuestros clientes y aliados estratégicos como la mejor escuela en gestión pública, acreditados con los más altos estándares de calidad en educación y ser reconocidos mundialmente.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCION 3: SOBRE NOSOTROS-->
<section class="logros-aportes">
    <div class="grid-row">
        <div class="grid-box bg-gris-box">
            <div class="content-padding">
                <h2 class="title-bold">Nuestros logros</h2>
                <ul class="list-logros">
                    <li><strong>2010:</strong> Lanzamos uno de los primeros cursos virtuales en gestión pública
                        en el Perú, con una plataforma digital que hemos fortalecido y mejorado continuamente.
                    </li>
                    <li><strong>2011:</strong> Democratizamos el acceso a la capacitación con formatos
                        accesibles para servidores públicos de todo el país, incluyendo zonas de difícil acceso.
                    </li>
                    <li><strong>2013:</strong> Creamos CONAPREF, el primer Congreso Nacional de Presupuesto y
                        Finanzas Públicas, en convenio con el CAFAE del MEF, con participación de cientos de
                        funcionarios y servidores.</li>
                    <li><strong>2017:</strong> Fuimos la 4.ª institución (de 47 aliados estratégicos del OSCE)
                        con mayor número de capacitaciones para la certificación de operadores en contrataciones
                        públicas.</li>
                    <li><strong>2018:</strong> Capacitamos a más de 5,000 servidores públicos y ejecutamos
                        programas In-House para 70+ instituciones a nivel nacional.</li>
                </ul>
            </div>
        </div>

        <div class="grid-box spacing-mobile" style="background-image: url('{{ asset('img/logros.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 350px;
        display: block;">
        </div>
    </div>

    <div class="grid-row row-reverse">
        <div class="grid-box bg-gris-box">
            <div class="content-padding">
                <h2 class="title-bold">Aportes a la Gestión Pública</h2>
                <p class="desc-text">Desde 2010 diseñamos programas de capacitación por niveles de competencia
                    (básico, intermedio y avanzado), enfocados en necesidades reales del Estado y en sistemas
                    clave como SIAF, SIGA y otros.</p>
                <p class="desc-text">Impulsamos la formación digital con una plataforma en línea y actividades
                    de difusión que beneficiaron a miles de servidores públicos a nivel nacional.</p>
                <p class="desc-text">Nuestro enfoque es fortalecer el criterio técnico y el cumplimiento
                    normativo, promoviendo una gestión eficiente y responsable de los recursos públicos, con
                    conciencia de las responsabilidades administrativas, civiles y penales.</p>
            </div>
        </div>

        <div class="grid-box img-mobile-spacing" style="background-image: url('{{ asset('img/aportes.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 350px;
        display: block;">
        </div>
    </div>
</section>

<!-- LISTOS PARA FORTALECER TU EQUIPO-->
<section class="cta-form-section">
    <div class="cta-blue-banner">
        <div class="inner-wrap">
            <h2>¿Listos para fortalecer a tu equipo?</h2>
            <p>Capacitación especializada con 23 años de trayectoria y +30,000 certificados emitidos.</p>
            <div class="cta-btns">
                <a href="#cotizar" class="btn-white">Solicitar cotización</a>
                <a href="https://api.whatsapp.com/send?phone=51950883155&text=Solicito%20Información%20sobre%20las%20capacitaciones"
                    class="btn-green" target="_blank" rel="noopener noreferrer">
                    WhatsApp directo
                </a>
            </div>
        </div>
    </div>

    <div id="cotizar" class="form-container-wrap">
        <div class="inner-wrap form-flex">
            <div class="form-info">
                <span class="badge-fucsia">Hablemos</span>
                <h2 class="form-title" style="font-family: 'Poppins';">Cotiza tu capacitación hoy</h2>
                <p>Cuéntanos el objetivo de tu entidad y te enviaremos una propuesta a medida (temario,
                    modalidad, cronograma y presupuesto) alineada a tus necesidades.</p>

                <p class="form-item">
                    <img src="{{ asset('img/icons/check.svg') }}" class="form-icon">
                    <span><b>Respuesta en 24 horas </b>(Según información brindada)</span>
                </p>
                <p class="form-item">
                    <img src="{{ asset('img/icons/check.svg') }}" class="form-icon">
                    <span>Modalidad <b>virtual, presencial o mixta</b></span>
                </p>
                <p class="form-item">
                    <img src="{{ asset('img/icons/check.svg') }}" class="form-icon">
                    <span>Incluye <b>alcance, contenidos, cronograma y cotización</b></span>
                </p>
            </div>

            <div class="form-card">
                <form id="miFormulario" style="font-family: 'Poppins';">
                    <input type="hidden" name="redirect"
                        value="https://api.whatsapp.com/send?phone=51964075153&text=Estoy%20interesado%20en%20PLAN%20DE%20DESARROLLO%20DE%20PERSONAS%20(2026)" />

                    <div class="input-group input-with-icon">
                        <label>Nombre completo</label>
                        <div class="relative-container">
                            <img src="{{ asset('img/icons/user.svg') }}" class="input-icon">
                            <input type="text" name="nombres" placeholder="Ingresa Nombre Completo" required>
                        </div>
                    </div>

                    <div class="input-group input-with-icon">
                        <label>Correo electrónico</label>
                        <div class="relative-container">
                            <img src="{{ asset('img/icons/carta.svg') }}" class="input-icon">
                            <input type="email" name="correo" placeholder="Ingresa Correo Electrónico" required>
                        </div>
                    </div>

                    <div class="input-group input-with-icon">
                        <label>Empresa</label>
                        <div class="relative-container">
                            <img src="{{ asset('img/icons/carpeta.svg') }}" class="input-icon">
                            <input type="text" name="institucion" placeholder="Nombre de tu Empresa" required>
                        </div>
                    </div>

                    <div class="input-group input-with-icon">
                        <label>Contacto</label>
                        <div class="relative-container">
                            <img src="{{ asset('img/icons/celular.svg') }}" class="input-icon">
                            <input type="number" name="telefono" placeholder="Ingresar Celular / WhatsApp" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Cuéntanos sobre la capacitación</label>
                        <textarea id="input-mensaje" rows="3"
                            placeholder="Describe tus objetivos, cantidad de personas, modalidad preferida, etc."></textarea>
                    </div>

                    <button type="submit" class="btn-submit-blue">Enviar solicitud de cotización</button>
                </form>
                <br>
                <p>Al enviar, aceptas ser contactados por R&C consulting solo con fines de cotización. No spam.</p>
            </div>

        </div>
    </div>
</section>

<!-- CODIGO SCRIPT PARA ENVIAR DATOS-->
<script>
    document.getElementById("miFormulario").addEventListener("submit", function (e) {
        e.preventDefault();

        const btn = e.target.querySelector("button");
        const originalText = btn.innerText;
        btn.innerText = "Enviando...";
        btn.disabled = true;

        var formData = new FormData(this);

        fetch("https://script.google.com/macros/s/AKfycbw1yJHtY22cXwnW4XDZo9w2eNckcBMIen9MdcaAEyAHA-0WsOGRJQ_4ClkE_SPoWQgMKg/exec", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.resultado === "OK") {
                    const whatsappUrl = this.querySelector('input[name="redirect"]').value;
                    this.reset();
                    window.location.href = whatsappUrl;
                }
            })
            .catch(err => {
                alert("Hubo un error al enviar. Por favor intenta de nuevo.");
                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
</script>

@endsection

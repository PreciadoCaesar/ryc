@extends('layouts.app')

@section('title', 'Membresía Premium 2026 | R&C Consulting')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/suscripciones/styles.css') }}">
@endsection

@section('content')

<!-- SECCION 0 - MEMBRESIAS-->

<section class="sec-membresia">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="membresia-title">Planes de membresía para potenciar<br>tu desarrollo profesional e institucional</h2>
            <p class="membresia-sub">Accede a cursos, diplomados, certificaciones y beneficios exclusivos con planes diseñados para profesionales, equipos e instituciones</p>

            <div class="membresia-badges">
                <span class="m-badge"><i class="fas fa-check-circle"></i> Acceso anual a formación especializada</span>
                <span class="m-badge"><i class="fas fa-check-circle"></i> Certificaciones y beneficios exclusivos</span>
                <span class="m-badge"><i class="fas fa-check-circle"></i> Planes para profesionales e instituciones</span>
            </div>
        </div>

        <div class="row g-4 justify-content-center mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="plan-card">
                    <h3 class="plan-name">Plan Personal</h3>
                    <p class="plan-tagline">Ideal para empezar</p>
                    <div class="plan-price">Año: S/. 370</div>
                    <p class="plan-support">Más formación y más respaldo</p>
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle"></i> 1 acceso individual</li>
                        <li><i class="fas fa-check-circle"></i> Cursos grabados</li>
                        <li><i class="fas fa-check-circle"></i> Certificación digital</li>
                        <li><i class="fas fa-check-circle"></i> Material exclusivo</li>
                        <li><i class="fas fa-check-circle"></i> Teleconferencias gratuitas</li>
                    </ul>
                    <a href="https://wa.me/51950883155?text=Hola,%20vengo%20de%20la%20web.%20Quiero%20el%20*Plan%20Personal*%20(S/.%20370).%20Solicito%20información%20de%20pago%20para%20obtener%20el%20plan.%20Muchas%20gracias." 
                    class="btn-plan btn-plan-outline" target="_blank">Quiero este plan</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="plan-card-featured plan-featured">
                    <div class="featured-tag">MÁS ELEGIDO</div>

                    <div class="plan-content-wrapper">
                        <h3 class="plan-name">Plan Premium</h3>
                        <p class="plan-tagline">Mejor relación valor-beneficio</p>
                        <div class="plan-price">Año: S/. 570</div>
                        <p class="plan-support-gold">Más formación y más respaldo</p>
                        <ul class="plan-features">
                            <li><i class="fas fa-check-circle"></i> Todo lo del plan personal</li>
                            <li><i class="fas fa-check-circle"></i> Diplomados grabados</li>
                            <li><i class="fas fa-check-circle"></i> 3 cursos y 1 diplomado en vivo por año</li>
                            <li><i class="fas fa-check-circle"></i> Certificación física y digital</li>
                            <li><i class="fas fa-check-circle"></i> Asesoría académica especializada</li>
                        </ul>
                        <a href="https://wa.me/51950883155?text=Hola,%20vengo%20de%20la%20web.%20Quiero%20el%20*Plan%20Premium*%20(S/.%20570).%20Solicito%20información%20de%20pago%20para%20obtener%20el%20plan%20y%20los%20beneficios%20en%20vivo.%20Muchas%20gracias." 
                        class="btn-plan btn-plan-solid" target="_blank">Quiero este plan</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="plan-card">
                    <h3 class="plan-name">Plan Dual</h3>
                    <p class="plan-tagline">Acceso para 2 personas</p>
                    <div class="plan-price">Año: S/. 970</div>
                    <p class="plan-support">Más formación y más respaldo</p>
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle"></i> Todo lo del plan premium</li>
                        <li><i class="fas fa-check-circle"></i> 2 accesos a la plataforma</li>
                        <li><i class="fas fa-check-circle"></i> 6 cursos y 2 diplomados en vivo por año</li>
                        <li><i class="fas fa-check-circle"></i> 2 sesiones de asesoría</li>
                        <li><i class="fas fa-check-circle"></i> Ideal para colegas o dupla profesional</li>
                    </ul>
                    <a href="https://wa.me/51950883155?text=Hola,%20vengo%20de%20la%20web.%20Quiero%20el%20*Plan%20Dual*%20(S/.%20970).%20Somos%202%20personas%20interesadas.%20Solicito%20información%20de%20pago%20para%20obtener%20el%20plan.%20Muchas%20gracias." 
                    class="btn-plan btn-plan-outline" target="_blank">Quiero este plan</a>
                </div>
            </div>
        </div>



        <div class="plan-institucional">
            <div class="col-lg-12 text-center mb-4">
                <h3 class="inst-title">Plan Institucional</h3>
                <p class="inst-sub">Gestión para equipos y entidades</p>
            </div>

            <div class="inst-container-box">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <ul class="plan-features inst-list">
                            <li><i class="fas fa-check-circle"></i> Acceso corporativo</li>
                            <li><i class="fas fa-check-circle"></i> Cursos y diplomados grabados ilimitados</li>
                            <li><i class="fas fa-check-circle"></i> Reportes y seguimiento académico</li>
                            <li><i class="fas fa-check-circle"></i> Certificación personalizada</li>
                            <li><i class="fas fa-check-circle"></i> Soporte personalizado</li>
                        </ul>
                    </div>
                    <div class="col-lg-7 col-md-6 d-flex flex-column"> 
                        <ul class="plan-features inst-list order-mobile-1">
                            <li><i class="fas fa-check-circle"></i> Basados en normativa SERVIR</li>
                            <li><i class="fas fa-check-circle"></i> Respaldo académico desde 2003</li>
                            <li><i class="fas fa-check-circle"></i> Experiencia en cursos, diplomados y programas institucionales</li>
                        </ul>

                        <div class="inst-btn-row mb-4 order-mobile-2">
                            <a href="https://wa.me/51950883155?text=Hola,%20solicito%20cotización%20del%20Acceso%20Corporativo%20(Plan%20Institucional)..."
                                class="btn-inst btn-inst-yellow" target="_blank">Solicita cotización</a>
                            <a href="https://wa.me/51950883155?text=Hola,%20solicito%20información%20sobre%20el%20plan%20institucional..."
                                class="btn-inst btn-inst-green" target="_blank">
                                Hablar con asesor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
</section>

<!-- SECCION 2: FINANCIAMIENTO-->
<section class="sec-financiamiento">
    <div class="container text-center">
        <h2 class="finan-title">¿CÓMO FINANCIAR TU MEMBRECÍA?</h2>
        <p class="finan-sub">Financia tu membrecía en cómodas cuotas sin costo adicional.</p>
        <a href="https://wa.me/51950883155?text=Hola!%20Me%20interesa%20financiar%20mi%20membrecía%20en%20cuotas%20sin%20costo%20adicional.%20¿Podrían%20darme%20más%20información?"
            target="_blank" class="btn-finan-wsp">
            <i class="fab fa-whatsapp"></i> Más información
        </a>
    </div>
</section>

<!-- SECCION 3: PREGUNTAS FRECUENTES-->
<section class="sec-faq">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="faq-title">PREGUNTAS FRECUENTES</h2>
            <p class="faq-sub">Bienvenidos a nuestro servicio de atención al cliente, aquí encontrarás preguntas frecuentes y sus respuestas.</p>
        </div>

        <div class="accordion accordion-flush faq-accordion" id="accordionFAQ">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq1">
                        ¿Qué tengo que estudiar primero para trabajar con el Estado?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Dependiendo la entidad, área y cargo que deseas postular, en líneas generales podemos darte las mínimas recomendaciones para que trabajes con el Estado:</p>
                        <p>Es necesario que conozcas las responsabilidades, deberes y derechos de todo servidor público, acuérdate que cuando ingresas a cualquier entidad ya eres un servidor público, el mismo puedes encontrarlo en la <strong>Ley 27444 y el ROF de la entidad</strong>, el mismo lo encuentras en google y en la página de la entidad respectivamente.</p>
                        <p>Y un conocimiento técnico que mínimamente debes manejar para que te integres a las áreas de:</p>
                        <ul>
                            <li><strong>Presupuesto y Planificación:</strong> Conocer el Ciclo del Proceso Presupuestario y su aplicación en el SIAF.</li>
                            <li><strong>Contabilidad:</strong> Debes tener conocimiento básico del sistema de contabilidad gubernamental, normativa respectiva y su aplicación en el SIAF.</li>
                            <li><strong>Tesorería:</strong> Debes tener conocimientos básicos de la normativa del sistema de tesorería y su aplicación en el SIAF.</li>
                            <li><strong>Abastecimiento:</strong> Conocer la Ley de Contrataciones del Estado, y procurar certificarte como operador del órgano encargado de las contrataciones en la OSCE, además de tener conocimientos en el SIAF y el SIGA, si la entidad cuenta con este último.</li>
                        </ul>
                        <p>Si gustas tener más información por favor escriba a nuestro correo oficial allí podremos orientarte de acuerdo a tu requerimiento y despejarte más dudas.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq2">
                        ¿Debo tener algún conocimiento previo para llevar un curso en gestión pública?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Depende del programa y el nivel que deseas capacitarte, si es un nivel básico, no necesitas ningún requisito, si es un nivel intermedio o de actualización ya necesitas una previa capacitación del tema, la gestión pública es especializada y dinámica no basta con un conocimiento empírico, recomendamos tener un conocimiento técnico especializado.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq3">
                        ¿Qué personas pueden participar en los cursos?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Recomendamos capacitarse o actualizarse a los servidores públicos y aquellas personas que quieran postular a un puesto laboral público. En cuanto a las empresas privadas es muy recomendable para aquellas empresas que contratan con el Estado llevar temas de como contratar con el Estado.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq4">
                        ¿Qué acreditación tienen los exposiciones que dictan los cursos?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Todos los profesionales cuentan con Maestrías de especialización de acuerdo a su especialidad, con más de 10 años de experiencia en puestos gerenciales o de manejo técnico. Para el caso de la gestión de las contrataciones cuentan con la acreditación por la OSCE.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq5">
                        ¿Entregan algún comprobante de pago por los programas?
                    </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Se entregan boletas de venta o factura, para ello debes proporcionar los datos necesarios para la emisión de los comprobantes de pago respectivos, como RUC, Razón Social y Dirección fiscal.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq6">
                        ¿Puedo pagar desde mi celular para participar en los programas?
                    </button>
                </h2>
                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Puedes hacer el pago del modo que mejor te parezca, a través de un celular, de un agente, de cualquier oficina de las cuentas de los bancos, o de PayPal para ello en cada publicidad de nuestros programas encuentras las cuentas respectivas y los números de CCI respectivos.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq7">
                        ¿Puedo pagar en partes sin incremento adicional del precio original?
                    </button>
                </h2>
                <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Efectivamente, para el caso de nuestros programas presenciales puedes hacer la reserva de tu participación con S/. 100.00 nuevos soles y cancelar la diferencia al inicio del programa y para participar en un curso virtual puedes cancelar en dos partes, separación de tu participación y al intermedio del desarrollo del curso, también te sugiero aprovechar los descuentos por pronto pago.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq8">
                        ¿En qué momento entregan los certificados cuando participo en un programa?
                    </button>
                </h2>
                <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>En el caso de los programas presenciales, los certificados se entregan al término de la capacitación previa verificación de la cancelación total. Si tu participación es de una entidad con orden de servicio, solo deberás presentar la copia de la orden para la entrega de tu certificado. Para el caso de los programas virtuales el envío es cuando culmina las transmisiones del programa en su totalidad, se coordinará con el participante para los datos y el lugar de envío de su certificado o diploma.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq9">
                        ¿Ya no quiero recibir publicidad de R&C Consulting en mi correo, qué tengo que hacer?
                    </button>
                </h2>
                <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>Nuestro sistema de captura y administración de datos es absolutamente confidencial, de uso estricto de información de los programas y promociones que tenemos para usted, si ya no deseas recibir más información deberás enviarnos un correo con el asunto <strong>NO DESEO.</strong></p>
                    </div>
                </div>
            </div>

        </div>


    </div>
</section>



<!-- MODAL REGISTRAR DATOS -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" id="modalRegistro">
            <div class="modal-header" style="background:var(--azul);border-radius:14px 14px 0 0;">
                <h3 style="color:#fff;font-family:'Montserrat',sans-serif;font-size:15px;font-weight:800;margin:0;">
                    ✉️ Registra tus datos
                </h3>
                <button type="button" class="btn-close" style="filter:invert(1);" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <p style="font-size:12px;color:var(--texto-medio);margin-bottom:16px;">Un asesor especializado te contactará para ayudarte con tu inscripción.</p>
                <form onsubmit="return handleLead(event)" id="formRegistroModal">
                    <input class="form-control" name="nombre" placeholder="Ingresa nombre completo" required style="margin-bottom:10px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <input class="form-control" type="email" name="correo" placeholder="Ingresa correo electrónico" required style="margin-bottom:10px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <input class="form-control" type="tel" name="celular" placeholder="Ingresa celular/WhatsApp" required style="margin-bottom:12px;border-radius:8px;border:1.5px solid var(--gris-medio);padding:10px 14px;font-size:13px;width:100%;">
                    <label style="display:flex;align-items:flex-start;gap:8px;cursor:pointer;font-size:11px;color:var(--texto-medio);margin-bottom:16px;">
                        <input type="checkbox" required checked style="margin-top:2px;flex-shrink:0;">
                        <span>Acepto las políticas de privacidad de datos</span>
                    </label>
                    <button type="submit" style="width:100%;background:var(--rojo);color:#fff;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;padding:12px;border-radius:9px;border:none;cursor:pointer;transition:background .2s;">
                        🚀 Solicitar información
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODALES -->
<div class="modal fade" id="inhouseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-7" style="background:var(--azul);padding:26px;">
                        <h3 style="color:#fff;font-family:'Montserrat',sans-serif;font-weight:800;margin-bottom:9px;">
                            Modalidad In-House: No te capacites solo, eleva el nivel de toda tu área.</h3>
                        <p style="color:rgba(255,255,255,.78);font-size:13px;line-height:1.7;margin-bottom:15px;">
                            La nueva Ley N° 32069, Reglamento DS Nº 009-2025-EF y Modificación DS Nº 001-2026-EF, trae cambios que impactarán a todo tu equipo.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <a href="mailto:capacitacion@rc-consulting.com" style="background:#fff;color:var(--azul);border-radius:50px;padding:7px 13px;font-size:12px;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;display:flex;align-items:center;gap:5px;"><i class="fas fa-envelope"></i> capacitacion@rc-consulting.com</a>
                            <a href="https://wa.me/51990035466?text=Hola,%20consulta%20INHOUSE%20Excel%20Profesional." style="background:var(--verde-wsp);color:#fff;border-radius:50px;padding:7px 13px;font-size:12px;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;display:flex;align-items:center;gap:5px;" target="_blank"><i class="fab fa-whatsapp"></i> Solicitar por WhatsApp</a>
                        </div>
                    </div>
                    <div class="col-md-5" style="padding:26px;position:relative;">
                        <button type="button" class="btn-close" style="position:absolute;top:12px;right:12px;" data-bs-dismiss="modal"></button>
                        <h3 style="font-family:'Montserrat',sans-serif;font-weight:800;color:var(--azul);margin-bottom:12px;font-size:15px;">Solicita una proforma aquí</h3>
                        <form id="inhouseForm">
                            <div class="mb-2"><input class="form-control" placeholder="Ingresa tu Nombre" required></div>
                            <div class="mb-2"><input class="form-control" type="email" placeholder="Ingresa tu Correo" required></div>
                            <div class="mb-2"><input class="form-control" type="tel" placeholder="Ingresa tu teléfono" required></div>
                            <div class="mb-2"><input class="form-control" placeholder="Entidad (opcional)"></div>
                            <div class="row g-2 mb-2">
                                <div class="col"><select class="form-select" style="font-size:12px;">
                                        <option>Cant. de Alumnos</option>
                                        <option>De 5 a 10</option>
                                        <option>De 10 a 15</option>
                                        <option>De 15 a 20</option>
                                        <option>De 20 a 30</option>
                                    </select></div>
                                <div class="col"><select class="form-select" style="font-size:12px;">
                                        <option>Nivel</option>
                                        <option>Básico</option>
                                        <option>Intermedio</option>
                                        <option>Avanzado</option>
                                    </select></div>
                            </div>
                            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="acepto2" checked required><label class="form-check-label" for="acepto2" style="font-size:11px;">Acepto Términos, Condiciones y Políticas de Privacidad</label></div>
                            <button class="btn w-100" type="submit" style="background:var(--amarillo);color:var(--azul);font-family:'Montserrat',sans-serif;font-weight:800;padding:10px;">Enviar Proforma</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="wa-float" href="https://wa.me/51990035466?text=Hola%20Yajaira,%20vengo%20de%20la%20landing%20Excel%20Profesional." target="_blank" rel="noopener">
    <span>🎁 PROMO ACTIVA</span>
    <i class="fab fa-whatsapp" style="font-size:17px;"></i>
</a>

@endsection

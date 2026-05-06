<footer class="main-footer">
    <div class="footer-container-full">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="footer-logo-box">
                    <img src="{{ asset('img/added/logofooter.webp') }}" alt="R&C Consulting" class="footer-logo">
                </div>
                <h3>Contáctanos:</h3>
                <div class="contact-info">
                    <p>Av. Petit Thouars 2166.<br/>Lince, Lima - Perú</p>
                    <p>Lunes a Viernes de 8:30 a 6:00 pm</p>
                    <p><a href="mailto:informes@rc-consulting.org" class="email-link">informes@rc-consulting.org</a></p>
                    <p>012661067 anexo: 100, 101, 104</p>
                </div>
            </div>

            <div class="col-md-3">
                <h3>Enlaces</h3>
                <ul class="footer-links">
                    <li><a href="{{ url('/cursos-virtuales') }}">Cursos</a></li>
                    <li><a href="{{ url('/diplomas-virtuales') }}">Diplomados</a></li>
                    <li><a href="{{ url('/cursos-inhouse') }}">Inhouse</a></li>
                    <li><a href="{{ url('/consultoria-asistencia-tecnica') }}">Consultorías</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h3>Información</h3>
                <ul class="footer-links mb-4">
                    <li><a href="{{ url('/politicas-de-proteccion-de-datos') }}">Políticas de privacidad</a></li>
                    <li><a href="{{ url('/terminos-y-condiciones') }}">Términos y condiciones</a></li>
                    <li><a href="{{ url('/contacto') }}">Contáctanos</a></li>
                </ul>
                <h4 class="payment-title">Métodos de pago</h4>
                <img src="{{ asset('img/added/payment.webp') }}" alt="Métodos de pago" class="payment-img">
            </div>

            <div class="col-md-3">
                <h3>Certificados</h3>
                <a href="{{ url('/app-certificados/version1') }}" class="btn-cert-f" target="_blank">
                    <i class="fas fa-search"></i> Consulta tu certificado
                </a>
                
                <div class="reclamaciones-box">
                    <img src="{{ asset('img/added/lreclamaciones.svg') }}" alt="Libro de reclamaciones">
                    <a href="{{ url('/libro-de-reclamaciones') }}">Libro de reclamaciones</a>
                </div>

                <div class="social-icons">
                    <a href="https://pe.linkedin.com/company/ryc-consulting" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/rycconsulting_/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@CursosGestionPublica" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.facebook.com/rcconsultingperu/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@ryc_consulting" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>R&C Consulting 2026 — Todos los derechos reservados</p>
        </div>
    </div>
</footer>
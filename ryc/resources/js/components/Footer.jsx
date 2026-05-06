export default function Footer() {
  return (
    <footer className="main-footer">
      <div className="footer-container-full">
        <div className="row g-4">
          <div className="col-md-3">
            <div className="footer-logo-box">
              <img src="/img/added/logofooter.webp" alt="R&C Consulting" className="footer-logo" />
            </div>
            <h3>Contáctanos:</h3>
            <div className="contact-info">
              <p>Av. Petit Thouars 2166.<br />Lince, Lima - Perú</p>
              <p>Lunes a Viernes de 8:30 a 6:00 pm</p>
              <p>
                <a href="mailto:informes@rc-consulting.org" className="email-link">
                  informes@rc-consulting.org
                </a>
              </p>
              <p>012661067 anexo: 100, 101, 104</p>
            </div>
          </div>

          <div className="col-md-3">
            <h3>Enlaces</h3>
            <ul className="footer-links">
              <li><a href="#">Cursos</a></li>
              <li><a href="#">Diplomados</a></li>
              <li><a href="#">Inhouse</a></li>
              <li><a href="#">Consultorías</a></li>
            </ul>
          </div>

          <div className="col-md-3">
            <h3>Información</h3>
            <ul className="footer-links mb-4">
              <li><a href="#">Políticas de privacidad</a></li>
              <li><a href="#">Términos y condiciones</a></li>
              <li><a href="#">Contáctanos</a></li>
            </ul>
            <h4 className="payment-title">Métodos de pago</h4>
            <img src="/img/added/payment.webp" alt="Métodos de pago" className="payment-img" />
          </div>

          <div className="col-md-3">
            <h3>Certificados</h3>
            <a href="#" className="btn-cert-f" target="_blank" rel="noopener noreferrer">
              <i className="fas fa-search"></i> Consulta tu certificado
            </a>

            <div className="reclamaciones-box">
              <img src="/img/added/lreclamaciones.svg" alt="Libro de reclamaciones" />
              <a href="#">Libro de reclamaciones</a>
            </div>

            <div className="social-icons">
              <a href="https://pe.linkedin.com/company/ryc-consulting" target="_blank" rel="noopener noreferrer" title="LinkedIn">
                <i className="fab fa-linkedin-in"></i>
              </a>
              <a href="https://www.instagram.com/rycconsulting_/" target="_blank" rel="noopener noreferrer" title="Instagram">
                <i className="fab fa-instagram"></i>
              </a>
              <a href="https://www.youtube.com/@CursosGestionPublica" target="_blank" rel="noopener noreferrer" title="YouTube">
                <i className="fab fa-youtube"></i>
              </a>
              <a href="https://www.facebook.com/rcconsultingperu/" target="_blank" rel="noopener noreferrer" title="Facebook">
                <i className="fab fa-facebook-f"></i>
              </a>
              <a href="https://www.tiktok.com/@ryc_consulting" target="_blank" rel="noopener noreferrer" title="TikTok">
                <i className="fab fa-tiktok"></i>
              </a>
            </div>
          </div>
        </div>

        <div className="footer-bottom">
          <p>R&C Consulting 2026 — Todos los derechos reservados</p>
        </div>
      </div>
    </footer>
  )
}

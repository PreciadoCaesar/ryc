import React from 'react'

export default function Header() {
  return (
    <div>
      {/* BANNER PÚRPURA */}
      <div className="banner-purpura">
        <div className="contenido-banner-purpura">
          <div className="banner-item">
            <div className="banner-icon">
              <img src="/img/Recurso 85@4x.webp" alt="PDP" />
            </div>
            <div className="banner-text">
              <b>Cumple con el PDP 2026</b>
              <span>Alinea tu capacitación In-House</span>
            </div>
          </div>
          <div className="banner-item">
            <div className="banner-icon">
              <img src="/img/Recurso 86@4x.webp" alt="Directiva" />
            </div>
            <div className="banner-text">
              <b className="highlight-yellow">CURSOS IN HOUSE</b>
              <span>Nueva Directiva 00214-2025-SERVIR-PE</span>
            </div>
          </div>
          <div className="banner-action">
            <a
              href="https://api.whatsapp.com/send?phone=51950883155&text=Solicito%20Información%20sobre%20las%20capacitaciones"
              className="btn-cotizar"
              target="_blank"
              rel="noopener noreferrer"
            >
              <i className="fas fa-handshake"></i> ¡Cotizalo aqui!
            </a>
          </div>
        </div>
      </div>

      {/* NAVBAR */}
      <nav className="navbar navbar-expand-lg rc-navbar">
        <div className="container-fluid px-4">
          <a className="navbar-brand" href="https://rc-consulting.org">
            <img src="/img/logo-rc-consulting-sin-fondo.webp" className="rc-logo" alt="R&C Consulting" />
          </a>
          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="mainNav">
            <ul className="navbar-nav mx-auto">
              <li className="nav-item">
                <a className="nav-link" href="#">Inicio</a>
              </li>
              <li className="nav-item dropdown">
                <a className="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Nosotros</a>
                <ul className="dropdown-menu">
                  <li><a className="dropdown-item" href="#">Sobre Nosotros</a></li>
                  <li><a className="dropdown-item" href="#">Experiencia y Alianzas</a></li>
                </ul>
              </li>
              <li className="nav-item dropdown">
                <a className="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Programas</a>
                <ul className="dropdown-menu">
                  <li><a className="dropdown-item" href="#">Cursos</a></li>
                  <li><a className="dropdown-item" href="#">Diplomados</a></li>
                  <li><a className="dropdown-item" href="#">Aula Virtual</a></li>
                  <li><a className="dropdown-item" href="#">Membresía Premium</a></li>
                  <li><a className="dropdown-item" href="#">Preguntas Frecuentes</a></li>
                </ul>
              </li>
              <li className="nav-item">
                <a className="nav-link" href="#" target="_blank">In House</a>
              </li>
            </ul>
            <div className="rc-buttons">
              <a
                href="https://api.whatsapp.com/send?phone=51950883155&text=Buen%20d%C3%ADa,%20he%20visitado%20la%20web%20de%20*R%26C%20Consulting*"
                target="_blank"
                rel="noopener noreferrer"
                className="btn-wsp"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                </svg> 950 883 155
              </a>
              <a href="#" target="_blank" rel="noopener noreferrer" className="btn-aula">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0" />
                  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                  <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z" />
                </svg> Aula Virtual
              </a>
              <a href="#" target="_blank" rel="noopener noreferrer" className="btn-tienda">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                </svg> Tienda Virtual
              </a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  )
}

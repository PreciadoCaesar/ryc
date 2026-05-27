import { useState } from 'react'

const slides = [
  { id: 1, className: 'slide-1', url: '/img/slider/fondonavidad.webp' },
  { id: 2, className: 'slide-2', url: '/img/slider/bg-fondo-7.webp' },
  { id: 3, className: 'slide-3', url: '/img/slider/fondo-2x1-curso.png' },
]

export default function HeroCarousel() {
  const [current, setCurrent] = useState(0)

  const prev = () => setCurrent((current - 1 + slides.length) % slides.length)
  const next = () => setCurrent((current + 1) % slides.length)

  return (
    <div
      id="heroCarousel"
      className="carousel slide slidem"
      data-bs-ride="carousel"
      data-bs-interval="5000"
      style={{
        backgroundImage: `url(${slides[current].url})`,
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        minHeight: '480px',
      }}
    >
      <div className="carousel-indicators">
        {slides.map((_, i) => (
          <button
            key={i}
            type="button"
            data-bs-target="#heroCarousel"
            data-bs-slide-to={i}
            className={i === current ? 'active' : ''}
            onClick={() => setCurrent(i)}
          />
        ))}
      </div>

      <div className="carousel-inner">
        {slides.map((slide, i) => (
          <div
            key={slide.id}
            className={`carousel-item ${i === current ? 'active' : ''}`}
          >
            <div className="slidem" style={{ backgroundImage: `url(${slide.url})`, minHeight: '480px' }} />
          </div>
        ))}
      </div>

      <button className="carousel-control-prev" type="button" onClick={prev}>
        <span className="carousel-control-prev-icon" />
      </button>
      <button className="carousel-control-next" type="button" onClick={next}>
        <span className="carousel-control-next-icon" />
      </button>
    </div>
  )
}

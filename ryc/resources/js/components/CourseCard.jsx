export default function CourseCard({ course }) {
  const isEnVivo = course.mode === 'en_vivo'
  const isFeatured = course.featured
  const advisorWhatsapp = course.advisor?.whatsapp || '51950883155'
  const advisorName = course.advisor?.name || 'Asesora'

  const whatsappMsg = encodeURIComponent(
    `Buen día, solicito información sobre el curso: ${course.title}`
  )

  return (
    <div className={`curso-card ${isFeatured ? 'proximo-iniciar' : ''}`}>
      <div className="curso-card__img">
        <img src={`/img/curso/${course.image}`} alt={course.title} />

        {isEnVivo && (
          <span className="sticker-inicia-hoy">INICIA {course.fecha_inicio}</span>
        )}

        {!isEnVivo && isFeatured && (
          <span className="badge-proximo">Destacado</span>
        )}
      </div>

      <div className="curso-card__body">
        <div className="curso-card__badges">
          <span className="badge-tipo">
            {course.type === 'diplomado' ? 'DIPLOMADO' : 'CURSO'}
            {isEnVivo ? ' • EN VIVO' : ' • ONLINE'}
          </span>
          {isEnVivo && course.sesiones && (
            <span className="badge-dcto">{course.sesiones} SESIONES</span>
          )}
        </div>

        <div className="curso-card__info">
          <div className="info-item">
            <i className="fas fa-certificate"></i>
            <strong>{course.hours}h</strong>
          </div>
          {isEnVivo && course.fecha_inicio && (
            <div className="info-item">
              <i className="fas fa-calendar-alt"></i>
              <strong>{course.fecha_inicio}</strong>
            </div>
          )}
        </div>

        <div className="curso-card__extra">
          {isEnVivo && (
            <span className="tag-envivo">
              <i className="fas fa-circle"></i> EN VIVO
            </span>
          )}
          <span className="tag-horas">
            <i className="fas fa-clock"></i> <strong>{course.hours} horas</strong> lectivas
          </span>
        </div>

        <a
          href={course.link}
          target="_blank"
          rel="noopener noreferrer"
          className="curso-card__btn"
          style={{ borderColor: course.color, color: course.color }}
        >
          Más información
        </a>

        <a
          href={`https://api.whatsapp.com/send?phone=${advisorWhatsapp}&text=${whatsappMsg}`}
          target="_blank"
          rel="noopener noreferrer"
          className="btn-wsp"
          style={{
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            gap: '6px',
            padding: '8px',
            borderRadius: '8px',
            fontSize: '12px',
            fontWeight: '700',
            textDecoration: 'none',
            color: '#fff',
            background: '#25D366',
            marginTop: '8px',
          }}
        >
          <i className="fab fa-whatsapp"></i> Contactar {advisorName}
        </a>
      </div>
    </div>
  )
}

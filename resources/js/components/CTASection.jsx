export default function CTASection() {
  return (
    <div
      id="seccion-fondo"
      style={{
        width: '100%',
        minHeight: '350px',
        backgroundImage: 'url(/img/banner-ingresa-aula-virtual.webp)',
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        flexDirection: 'column',
        padding: '40px 20px',
      }}
    >
      <h2 className="titulo" style={{ fontSize: '35px', color: 'white', fontWeight: '900', textAlign: 'center' }}>
        ¿Ya eres alumno?
      </h2>
      <p className="subtitulo" style={{ fontSize: '25px', color: 'white', fontWeight: '900', marginTop: '10px', textAlign: 'center' }}>
        Ingresa a tu Aula Virtual
      </p>
      <a
        href="https://www.rc-consulting.edu.pe/"
        target="_blank"
        rel="noopener noreferrer"
        className="boton"
        style={{
          color: 'white',
          backgroundColor: '#9e183a',
          fontFamily: '"Roboto", Sans-serif',
          fontSize: '20px',
          fontWeight: '500',
          borderRadius: '30px',
          padding: '15px 50px',
          marginTop: '20px',
          textDecoration: 'none',
          display: 'inline-block',
        }}
      >
        Ingresar al Aula Virtual
      </a>
    </div>
  )
}

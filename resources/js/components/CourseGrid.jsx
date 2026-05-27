import { useState, useEffect } from 'react'
import CourseCard from './CourseCard'

export default function CourseGrid({ type, mode }) {
  const [courses, setCourses] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const allCourses = window.__COURSES__ || []

    let filtered = allCourses

    if (type) {
      filtered = filtered.filter(c => c.type === type)
    }
    if (mode) {
      filtered = filtered.filter(c => c.mode === mode)
    }

    setCourses(filtered)
    setLoading(false)
  }, [type, mode])

  if (loading) {
    return <div style={{ textAlign: 'center', padding: '40px', color: '#666' }}>Cargando cursos...</div>
  }

  if (!courses.length) {
    return <div style={{ textAlign: 'center', padding: '40px', color: '#666' }}>No hay cursos disponibles</div>
  }

  return (
    <div className="cursos-grid">
      {courses.map(course => (
        <CourseCard key={course.id} course={course} />
      ))}
    </div>
  )
}

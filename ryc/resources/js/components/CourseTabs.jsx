import { useState } from 'react'
import CourseGrid from './CourseGrid'

const tabs = [
  { id: 'cursos', label: 'Cursos Online', type: 'curso', mode: 'grabado' },
  { id: 'diplomados', label: 'Diplomados', type: 'diplomado', mode: 'grabado' },
  { id: 'envivo', label: 'Cursos En Vivo', type: 'curso', mode: 'en_vivo' },
  { id: 'diplomadosvivo', label: 'Diplomados En Vivo', type: 'diplomado', mode: 'en_vivo' },
]

export default function CourseTabs() {
  const [activeTab, setActiveTab] = useState('cursos')

  const currentTab = tabs.find(t => t.id === activeTab)

  return (
    <div>
      <div className="seccion-titulo">
        <h2>Nuestros Programas de Capacitación</h2>
        <p>Capacitación especializada en gestión pública con certificación oficial</p>
      </div>

      <div className="filtro-tabs">
        {tabs.map(tab => (
          <button
            key={tab.id}
            className={`filtro-tab ${activeTab === tab.id ? 'active' : ''}`}
            onClick={() => setActiveTab(tab.id)}
          >
            {tab.label}
          </button>
        ))}
      </div>

      <CourseGrid type={currentTab.type} mode={currentTab.mode} />
    </div>
  )
}

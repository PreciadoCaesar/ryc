import Header from './Header'
import Footer from './Footer'
import HeroCarousel from './HeroCarousel'
import CourseTabs from './CourseTabs'
import CTASection from './CTASection'

export default function App() {
  return (
    <>
      <Header />
      <main>
        <HeroCarousel />
        <CourseTabs />
        <CTASection />
      </main>
      <Footer />
    </>
  )
}

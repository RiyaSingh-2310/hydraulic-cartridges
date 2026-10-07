import { Intro } from '../components/home/Intro'
import { AboutPreview } from '../components/home/AboutPreview'
import { Applications } from '../components/home/Applications'
import { Capabilities } from '../components/home/Capabilities'
import { FeaturedProduct } from '../components/home/FeaturedProduct'
import { FinalCta } from '../components/home/FinalCta'
import { Hero } from '../components/home/Hero'
import { ProductsShowcase } from '../components/home/ProductsShowcase'
import { Quality } from '../components/home/Quality'
import { Resources } from '../components/home/Resources'

export default function HomePage() {
  return (
    <>
      <Hero />
      <ProductsShowcase />
      <Intro />
      <FeaturedProduct />
      <Applications />
      <Capabilities />
      <Quality />
      <AboutPreview />
      <Resources />
      <FinalCta />
    </>
  )
}

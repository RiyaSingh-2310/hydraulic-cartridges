import { Link } from 'react-router-dom'
import { PageHero } from '../components/common/PageHero'
import { Button } from '../components/common/Button'

export default function NotFoundPage() {
  return (
    <>
      <PageHero
        compact
        eyebrow="404"
        title="This cavity is empty."
        description="The page does not exist in this frontend. Return to the catalog or send a quote request."
      />
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container hero-actions">
          <Button to="/">Home</Button>
          <Button to="/products" variant="outline">
            Products
          </Button>
          <Link to="/contact">Contact</Link>
        </div>
      </section>
    </>
  )
}

import { motion, useReducedMotion, useScroll, useTransform } from 'framer-motion'
import { useRef } from 'react'
import { images } from '../../data/images'
import { Button } from '../common/Button'

export function Hero() {
  const ref = useRef<HTMLElement>(null)
  const reduce = useReducedMotion()
  const { scrollYProgress } = useScroll({
    target: ref,
    offset: ['start start', 'end start'],
  })
  const y = useTransform(scrollYProgress, [0, 1], [0, reduce ? 0 : 80])
  const opacity = useTransform(scrollYProgress, [0, 1], [1, reduce ? 1 : 0.55])

  return (
    <section className="hero" ref={ref} aria-label="Introduction">
      <motion.div className="hero-media" style={{ y, opacity }}>
        <img
          src={images.hero.src}
          alt={images.hero.alt}
          fetchPriority="high"
          width={2200}
          height={1400}
        />
        <div className="hero-shade" />
      </motion.div>
      <div className="container-wide hero-content">
        <motion.div
          initial={reduce ? false : { opacity: 0, y: 18 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }}
        >
          <p className="eyebrow">Precision hydraulic engineering</p>
          <h1 className="display">Cartridge valves. Measured to the cavity.</h1>
          <p className="lede">
            Direct-from-manufacturer screw-in cartridges and custom manifolds for continuous-duty
            350-bar industrial equipment — specified, machined, and tested as a complete fluid-power
            component.
          </p>
          <div className="hero-actions">
            <Button to="/products">Explore Products</Button>
            <Button to="/request-quote" variant="ghost">
              Request a Quote
            </Button>
          </div>
        </motion.div>
        <motion.div
          className="hero-stats"
          initial={reduce ? false : { opacity: 0, y: 24 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.15, ease: [0.22, 1, 0.36, 1] }}
        >
          <div className="hero-stat">
            <span>350 bar</span>
            <small>Continuous operating class</small>
          </div>
          <div className="hero-stat">
            <span>ISO 9001</span>
            <small>Compliant manufacturing</small>
          </div>
          <div className="hero-stat">
            <span>100%</span>
            <small>Catalog units functionally tested</small>
          </div>
        </motion.div>
      </div>
    </section>
  )
}

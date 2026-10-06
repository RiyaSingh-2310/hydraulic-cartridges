import { lazy } from 'react'
import { Navigate, Route, Routes } from 'react-router-dom'
import { ScrollToTop } from '../components/common/ScrollToTop'
import { Layout } from '../components/layout/Layout'

const HomePage = lazy(() => import('../pages/HomePage'))
const ProductsPage = lazy(() => import('../pages/ProductsPage'))
const ProductDetailPage = lazy(() => import('../pages/ProductDetailPage'))
const ApplicationsPage = lazy(() => import('../pages/ApplicationsPage'))
const ApplicationDetailPage = lazy(() => import('../pages/ApplicationDetailPage'))
const AboutPage = lazy(() => import('../pages/AboutPage'))
const ResourcesPage = lazy(() => import('../pages/ResourcesPage'))
const ContactPage = lazy(() => import('../pages/ContactPage'))
const RequestQuotePage = lazy(() => import('../pages/RequestQuotePage'))
const PrivacyPage = lazy(() => import('../pages/PrivacyPage'))
const TermsPage = lazy(() => import('../pages/TermsPage'))
const NotFoundPage = lazy(() => import('../pages/NotFoundPage'))

export function AppRouter() {
  return (
    <>
      <ScrollToTop />
      <Routes>
        <Route element={<Layout />}>
          <Route index element={<HomePage />} />
          <Route path="products" element={<ProductsPage />} />
          <Route path="products/:slug" element={<ProductDetailPage />} />
          <Route path="applications" element={<ApplicationsPage />} />
          <Route path="solutions" element={<Navigate to="/applications" replace />} />
          <Route path="applications/:slug" element={<ApplicationDetailPage />} />
          <Route path="about" element={<AboutPage />} />
          <Route path="resources" element={<ResourcesPage />} />
          <Route path="contact" element={<ContactPage />} />
          <Route path="request-quote" element={<RequestQuotePage />} />
          <Route path="privacy" element={<PrivacyPage />} />
          <Route path="terms" element={<TermsPage />} />
          <Route path="*" element={<NotFoundPage />} />
        </Route>
      </Routes>
    </>
  )
}

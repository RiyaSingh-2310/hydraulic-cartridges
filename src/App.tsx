import { BrowserRouter } from 'react-router-dom'
import { ShopProvider } from './context/ShopContext'
import { AppRouter } from './routes/AppRouter'

export default function App() {
  return (
    <BrowserRouter>
      <ShopProvider>
        <AppRouter />
      </ShopProvider>
    </BrowserRouter>
  )
}

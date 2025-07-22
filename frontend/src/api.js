import axios from 'axios'
import router from './router' 
const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true,
})

// Ajoute le token à chaque requête si présent
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

// Si l’API retourne une erreur 401, on déconnecte automatiquement
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      localStorage.removeItem('token')
      router.push('/admin/administration') // Redirige vers la page de login
    }
    return Promise.reject(error)
  }
)

export default api

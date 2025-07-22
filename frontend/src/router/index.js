import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/administration/LoginView.vue'
import DashboardView from '../views/administration/DashboardView.vue'
import RespondentDetail from '../views/administration/RespondentDetail.vue'
import SurveyView from '../views/SurveyView.vue'
import ResultView from '../views/ResultView.vue'
import DefaultLayout from '../layouts/DefaultLayout.vue'

// Pages admin
import QuestionsView from '../views/administration/QuestionsView.vue'
import ResponsesView from '../views/administration/ResponsesView.vue'

const routes = [
  // Public
  { path: '/', component: SurveyView },
  { path: '/result/:token', component: ResultView },

  // Login
  { path: '/admin/administration', component: LoginView },

  // Admin protégé
  {
    path: '/admin',
    component: DefaultLayout,
    children: [
      { path: 'dashboard', component: DashboardView },
      { path: 'respondents/:token', component: RespondentDetail },
      { path: 'questions', component: QuestionsView },
      { path: 'responses', component: ResponsesView },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Garde de navigation : redirige si pas connecté
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token')

  if (to.path.startsWith('/admin') && to.path !== '/admin/administration') {
    if (!isAuthenticated) {
      return next('/admin/administration')
    }
  }

  next()
})

export default router

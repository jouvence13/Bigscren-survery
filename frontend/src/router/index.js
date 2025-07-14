import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/administration/LoginView.vue'
import DashboardView from '../views/administration/DashboardView.vue'
import RespondentDetail from '../views/administration/RespondentDetail.vue'
import SurveyView from '../views/SurveyView.vue'
import ResultView from '../views/ResultView.vue'

const routes = [
  { path: '/', component: SurveyView },
  { path: '/result/:token', component: ResultView },
  { path: '/admin/login', component: LoginView },
  { path: '/admin/dashboard', component: DashboardView },
  { path: '/admin/respondents/:token', component: RespondentDetail },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

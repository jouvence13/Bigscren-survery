import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/administration/LoginView.vue'
import DashboardView from '../views/administration/DashboardView.vue'
import RespondentDetail from '../views/administration/RespondentDetail.vue'
import SurveyView from '../views/SurveyView.vue'
import ResultView from '../views/ResultView.vue'
import DefaultLayout from '../layouts/DefaultLayout.vue'

// Ajoute ces deux imports :
import QuestionsView from '../views/administration/QuestionsView.vue'
import ResponsesView from '../views/administration/ResponsesView.vue'

const routes = [
  // Public
  { path: '/', component: SurveyView },
  { path: '/result/:token', component: ResultView },

  // Login (pas de layout)
  { path: '/admin/administration', component: LoginView },

  // Routes protégées avec layout
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

export default router

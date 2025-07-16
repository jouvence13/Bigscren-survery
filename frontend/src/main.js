import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.min.css'
import VueApexCharts from 'vue3-apexcharts'


const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueApexCharts)
app.component('ApexChart', VueApexCharts)

app.mount('#app')

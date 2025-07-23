<template>
  <div>
    <h2 class="mb-4 fw-bold text-center">Survey Insights</h2>

    
    <div v-if="isLoading" class="loading">Loading charts...</div>

  
    <div class="chart-grid" v-else>
  
      <div class="chart-box" v-if="question6.series.length">
        <ApexChart
          type="pie"
          height="250"
          :options="question6.options"
          :series="question6.series"
        />
      </div>

    
      <div class="chart-box" v-if="question7.series.length">
        <ApexChart
          type="pie"
          height="250"
          :options="question7.options"
          :series="question7.series"
        />
      </div>

      
      <div class="chart-box" v-if="question10.series.length">
        <ApexChart
          type="pie"
          height="250"
          :options="question10.options"
          :series="question10.series"
        />
      </div>

      
      <div class="chart-box" v-if="radarChart.series.length">
        <ApexChart
          type="radar"
          height="300"
          :options="radarChart.options"
          :series="radarChart.series"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ApexChart from 'vue3-apexcharts'
import axios from '@/api.js'


const question6 = ref({ series: [], options: {} })
const question7 = ref({ series: [], options: {} })
const question10 = ref({ series: [], options: {} })
const radarChart = ref({ series: [], options: {} })
const isLoading = ref(true) 


const fetchStats = async () => {
  try {
    const res = await axios.get('/dashboard-stats')
    const { pie, radar } = res.data

    question6.value = {
      series: Object.values(pie[6]),
      options: {
        labels: Object.keys(pie[6]),
        title: { text: 'VR Headsets (Q6)', align: 'center' }
      }
    }

    question7.value = {
      series: Object.values(pie[7]),
      options: {
        labels: Object.keys(pie[7]),
        title: { text: 'VR Stores (Q7)', align: 'center' }
      }
    }

    question10.value = {
      series: Object.values(pie[10]),
      options: {
        labels: Object.keys(pie[10]),
        title: { text: 'Main Usage (Q10)', align: 'center' }
      }
    }

    radarChart.value = {
      series: [
        {
          name: 'Quality Ratings',
          data: radar
        }
      ],
      options: {
        title: { text: 'Quality Overview (Q11–Q15)', align: 'center' },
        xaxis: {
          categories: [
            'Image (Q11)',
            'UI (Q12)',
            'Network (Q13)',
            '3D Graphics (Q14)',
            'Audio (Q15)'
          ]
        }
      }
    }

  } catch (error) {
    console.error('Failed to fetch dashboard stats:', error)
  } finally {
    isLoading.value = false 
  }
}

onMounted(fetchStats)
</script>

<style scoped>
h2 {
  text-align: center;
  margin-bottom: 2rem;
}


.chart-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 2rem;
  padding: 0 1rem;
}


.chart-box {
  background-color: #fff;
  border-radius: 10px;
  padding: 1rem;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}


.loading {
  text-align: center;
  font-size: 1.25rem;
  color: #0d6efd;
  margin-top: 3rem;
}
</style>

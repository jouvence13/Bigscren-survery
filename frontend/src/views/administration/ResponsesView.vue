<template>
  <div class="p-4">
    <h2 class="text-center fw-bold mb-4">All Survey Responses</h2>

    <div v-if="loading" class="text-center text-primary">Loading responses...</div>

    <div v-else>
      <div
        v-for="(respondent, index) in responses"
        :key="respondent.email"
        class="mb-5"
      >
        <h5 class="mb-3">
          Respondent {{ index + 1 }} — <span class="text-muted">{{ respondent.email }}</span>
        </h5>

        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th style="width: 5%">#</th>
              <th>Question</th>
              <th>Answer</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(response, i) in respondent.responses"
              :key="i"
            >
              <td>{{ i + 1 }}</td>
              <td>{{ response.question }}</td>
              <td>{{ response.answer }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/api.js'

const responses = ref([])
const loading = ref(true)


const fetchAllResponses = async () => {
  try {
    const res = await axios.get('/admin/respondents') 
    responses.value = res.data
  } catch (error) {
    console.error('Failed to fetch responses:', error)
  } finally {
    loading.value = false
  }
}

onMounted(fetchAllResponses)
</script>

<style scoped>
h5 {
  font-weight: bold;
  color: #0d6efd;
}
.table th, .table td {
  vertical-align: middle;
}
</style>

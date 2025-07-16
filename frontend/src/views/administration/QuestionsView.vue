<template>
  <div class="p-4">
    <h2 class="mb-4 fw-bold text-center">List of Survey Questions</h2>

    <!-- Loader -->
    <div v-if="loading" class="text-center text-primary">Loading questions...</div>

    <!-- Table -->
    <table v-else class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th style="width: 5%">#</th>
          <th>Question</th>
          <th style="width: 10%">Type</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(question, index) in questions" :key="question.id">
          <td>{{ index + 1 }}</td>
          <td>{{ question.body }}</td>
          <td>{{ question.type }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/api.js'

// Références pour les données
const questions = ref([])
const loading = ref(true)

// Appel API pour charger les questions
const fetchQuestions = async () => {
  try {
    const res = await axios.get('/questions')
    questions.value = res.data
  } catch (error) {
    console.error('Failed to load questions', error)
  } finally {
    loading.value = false
  }
}

onMounted(fetchQuestions)
</script>

<style scoped>
.table {
  background-color: #fff;
}
</style>

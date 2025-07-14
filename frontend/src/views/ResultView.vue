<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from '../api'

const route = useRoute()
const token = route.params.token
const loading = ref(true)
const error = ref('')
const responses = ref([])
const email = ref('')

onMounted(async () => {
  try {
    const res = await axios.get(`/result/${token}`)
    responses.value = res.data.responses
    email.value = res.data.email
    loading.value = false
  } catch (err) {
    error.value = 'Invalid token or no data found.'
    loading.value = false
  }
})
</script>

<template>
  <div class="container mt-5">
    <div v-if="loading" class="text-center">
      <div class="spinner-border" role="status"></div>
      <p>Loading responses...</p>
    </div>

    <div v-else-if="error" class="alert alert-danger text-center">
      {{ error }}
    </div>

    <div v-else>
      <h2 class="text-center text-primary mb-4">🎉 Survey Responses</h2>
      <p class="text-center"><strong>Email:</strong> {{ email }}</p>

      <div v-for="(item, index) in responses" :key="index" class="mb-4">
        <p class="fw-bold">Q{{ index + 1 }}: {{ item.question }}</p>
        <div class="response-box">
          <span>{{ item.answer }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.response-box {
  border: 1px solid #0d6efd;
  padding: 10px;
  border-radius: 5px;
  background-color: #f8f9fa;
}
</style>

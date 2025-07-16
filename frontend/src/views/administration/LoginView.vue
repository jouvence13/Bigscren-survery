<script setup>
import { ref } from 'vue'
import axios from '../../api'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

const router = useRouter()

const login = async () => {
  error.value = ''
  loading.value = true

  try {
    const res = await axios.post('/login', {
      email: email.value,
      password: password.value
    })

    // Stocker le token si tu utilises JWT
    localStorage.setItem('token', res.data.token)

    // Rediriger vers l'administration
    router.push('/admin/dashboard')
  } catch (err) {
    error.value = 'Invalid email or password.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
      <h3 class="text-center mb-4">Bigscreen</h3>

      <form @submit.prevent="login">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input v-model="email" type="email" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input v-model="password" type="password" class="form-control" required />
        </div>

        <div v-if="error" class="alert alert-danger">{{ error }}</div>

        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
          <span v-if="loading" class="spinner-border spinner-border-sm"></span>
          <span v-else>Login</span>
        </button>
      </form>
    </div>
  </div>
</template>

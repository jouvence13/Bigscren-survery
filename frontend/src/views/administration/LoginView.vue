<template>
  <div class="login-page">
    <div class="login-box">
      <h2>BIGSCREEN</h2>
      <form @submit.prevent="login">
        <div class="user-box">
          <input type="email" v-model="email" required />
          <label>Email</label>
        </div>
        <div class="user-box">
          <input type="password" v-model="password" required />
          <label>Password</label>
        </div>

        <div v-if="error" class="error-msg">{{ error }}</div>

        <button type="submit" class="submit-btn" :disabled="loading">
          <span></span><span></span><span></span><span></span>
          <template v-if="loading">
            <span class="spinner"></span>
          </template>
          <template v-else>
            Login
          </template>
        </button>
      </form>
    </div>
  </div>
</template>

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
      password: password.value,
    })
    localStorage.setItem('token', res.data.token)
    router.push('/admin/dashboard')
  } catch (err) {
    error.value = 'Invalid email or password.'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.login-page {
  height: 100vh;
  margin: 0;
  padding: 0;
  background: linear-gradient(#30142b, #a12727);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: sans-serif;
}

.login-box {
  width: 400px;
  padding: 40px;
  background: rgba(0, 0, 0, 0.5);
  box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
  border-radius: 10px;
  color: #fff;
}
.login-box h2 {
  margin-bottom: 30px;
  text-align: center;
}

.user-box {
  position: relative;
  margin-bottom: 30px;
}
.user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  background: transparent;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
}
.user-box label {
  position: absolute;
  top: 0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: 0.5s;
}
.user-box input:focus ~ label,
.user-box input:valid ~ label {
  top: -20px;
  font-size: 12px;
  color: #4242F3FF;
}

.error-msg {
  color: #ff6b6b;
  font-size: 14px;
  margin-bottom: 10px;
  text-align: center;
}

/* Submit button */
.submit-btn {
  position: relative;
  display: inline-block;
  padding: 14px 20px;
  width: 100%;
  color: #FFFFFFFF;
  font-size: 18px;
  text-transform: uppercase;
  overflow: hidden;
  letter-spacing: 3px;
  border: none;
  background: none;
  cursor: pointer;
  margin-top: 20px;
  text-align: center;
  transition: all 0.3s;
}
.submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
.submit-btn:hover {
  background: #4242F3FF;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #4242F3FF, 0 0 25px #4242F3FF, 0 0 50px #4242F3FF, 0 0 100px #4242F3FF;
}

/* Borders animations */
.submit-btn span {
  position: absolute;
  display: block;
}
.submit-btn span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent,#4242F3FF);
  animation: btn-anim1 1s linear infinite;
}
.submit-btn span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #f4bc03);
  animation: btn-anim2 1s linear infinite;
  animation-delay: 0.25s;
}
.submit-btn span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #f4dc03);
  animation: btn-anim3 1s linear infinite;
  animation-delay: 0.5s;
}
.submit-btn span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #4242F3FF);
  animation: btn-anim4 1s linear infinite;
  animation-delay: 0.75s;
}

/* Spinner */
.spinner {
  border: 3px solid rgba(255, 255, 255, 0.3);
  border-top: 3px solid #fff;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  animation: spin 0.8s linear infinite;
  display: inline-block;
  vertical-align: middle;
  margin-top: -2px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* Animations */
@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,
  100% {
    left: 100%;
  }
}
@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,
  100% {
    top: 100%;
  }
}
@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,
  100% {
    right: 100%;
  }
}
@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,
  100% {
    bottom: 100%;
  }
}
</style>

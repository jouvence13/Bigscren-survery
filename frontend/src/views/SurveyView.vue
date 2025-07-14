<script setup>
import axios from '../api.js'
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const questions = ref([])
const answers = ref({})
const submitted = ref(false)
const token = ref('')

const router = useRouter()
const tokenLink = computed(() => `/result/${token.value}`)

const fetchSurvey = async () => {
  try {
    const res = await axios.get('/questions')
    questions.value = res.data
    res.data.forEach((q) => {
      answers.value[q.id] = ''
    })
  } catch (e) {
    console.error('Failed to load questions', e)
  }
}

const parseOptions = (json) => {
  try {
    return JSON.parse(json) || []
  } catch {
    return []
  }
}

const submitSurvey = async () => {
  const emailAnswer = answers.value[questions.value[0]?.id] || ''
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailPattern.test(emailAnswer)) {
    alert('Please enter a valid email address')
    return
  }

  const values = Object.values(answers.value)
  if (values.length !== 20 || values.some(a => !a)) {
    alert('Please answer all 20 questions')
    return
  }

  const payload = {
    email: emailAnswer,
    responses: Object.entries(answers.value).map(([question_id, answer]) => ({
      question_id: parseInt(question_id),
      answer
    }))
  }

  try {
    const res = await axios.post('/responses', payload)
    token.value = res.data.token
    submitted.value = true
  } catch (err) {
    alert('Submission failed')
  }
}

onMounted(fetchSurvey)
</script>

<template>
  <div class="bg-light py-5">
    <div class="container shadow p-4 rounded bg-white">
      <h2 class="text-center text-primary mb-4">📜 Bigscreen Survey</h2>
      <p class="text-center text-muted mb-5">Please answer all 20 questions accurately.</p>

      <form @submit.prevent="submitSurvey" v-if="questions.length && !submitted">
        <div
          v-for="(question, index) in questions"
          :key="question.id"
          class="mb-4"
        >
          <div class="mb-2">
            <span class="badge bg-primary">Q{{ index + 1 }}</span>
            <strong class="ms-2">{{ question.body }}</strong>
          </div>

          <div class="response-box mt-2">
            <select
              v-if="question.type === 'A'"
              v-model="answers[question.id]"
              class="form-select"
              required
            >
              <option disabled value="">Select an option</option>
              <option
                v-for="(option, i) in parseOptions(question.options)"
                :key="i"
                :value="option"
              >
                {{ option }}
              </option>
            </select>

            <input
              v-else-if="question.type === 'B'"
              type="text"
              maxlength="255"
              class="form-control"
              v-model="answers[question.id]"
              required
              placeholder="Type your answer here"
            />

            <select
              v-else-if="question.type === 'C'"
              v-model="answers[question.id]"
              class="form-select"
              required
            >
              <option disabled value="">Choose a rating</option>
              <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
            </select>
          </div>
        </div>

        <div class="text-center mt-5">
          <button type="submit" class="btn btn-lg btn-success px-5">Finaliser</button>
        </div>
      </form>
    </div>

    <!-- MODAL -->
    <div v-if="submitted" class="modal-overlay">
      <div class="modal-box">
        <h4 class="text-success mb-3">🎉 Thank you for your answers!</h4>
        <p>
          The entire Bigscreen team thanks you for your commitment.<br />
          Thanks to your investment, we're developing an app that's even easier to use,
          whether you're alone or with your family.
        </p>
        <p class="mt-3">
          <strong>You can view your responses later at:</strong><br />
          <router-link :to="tokenLink" class="link">{{ tokenLink }}</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 800px;
}
.response-box {
  border: 2px dashed #0d6efd;
  border-radius: 8px;
  padding: 15px;
  background-color: #f8fbff;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  backdrop-filter: blur(4px);
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-box {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  text-align: center;
  max-width: 500px;
  animation: fadeIn 0.3s ease;
}
.link {
  display: inline-block;
  margin-top: 10px;
  color: #0d6efd;
  word-break: break-word;
}
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>

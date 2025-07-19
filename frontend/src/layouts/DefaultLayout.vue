<template>
  <div class="d-flex vh-100">
    <!-- SIDEBAR -->
    <aside
      id="sidebar"
      ref="sidebar"
      class="bg-dark text-white p-3 sidebar d-flex flex-column justify-between"
      :class="{ hide: isSidebarHidden }"
    >
      <div>
        <h4 class="text-center mb-4">Bigscreen</h4>
        <nav class="nav flex-column side-menu mb-4">
          <router-link to="/admin/dashboard" class="nav-link text-white">
            Dashboard
          </router-link>
          <router-link to="/admin/questions" class="nav-link text-white">
            Questionnaire
          </router-link>
          <router-link to="/admin/responses" class="nav-link text-white">
            Responses
          </router-link>
        </nav>
      </div>

      <!-- Logout button -->
      <div class="mt-auto text-center">
        <button @click="handleLogout" class="btn btn-danger btn-sm w-100">
          Logout
        </button>
      </div>
    </aside>

    <!-- CONTENT -->
    <section id="content" class="flex-grow-1 d-flex flex-column">
      <!-- NAVBAR -->
      <nav class="navbar bg-white border-bottom px-3 py-2 d-flex align-items-center">
        <i class="bx bx-menu fs-4 me-3" @click="toggleSidebar"></i>
      </nav>

      <!-- MAIN -->
      <main class="flex-grow-1 overflow-auto p-4 bg-light">
        <router-view />
      </main>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()

const sidebar = ref(null)
const searchForm = ref(null)
const searchIcon = ref(null)
const isSidebarHidden = ref(false)

// Toggle sidebar visibility
const toggleSidebar = () => {
  isSidebarHidden.value = !isSidebarHidden.value
}

// Responsive logic
const handleResize = () => {
  if (window.innerWidth < 768) {
    isSidebarHidden.value = true
  }
  if (window.innerWidth > 576) {
    searchForm.value?.classList.remove('show')
    searchIcon.value?.classList.replace('bx-x', 'bx-search')
  }
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
})

// Logout function
const handleLogout = async () => {
  try {
    await api.post('/logout')
  } catch (err) {
    console.error('Erreur lors de la déconnexion', err)
  } finally {
    localStorage.removeItem('token')
    router.push('/admin/administration')
  }
}
</script>

<style scoped>
.sidebar {
  width: 250px;
  transition: all 0.3s;
}
.sidebar.hide {
  transform: translateX(-100%);
  position: absolute;
  z-index: 100;
}
.nav-link.router-link-active {
  font-weight: bold;
  background-color: #0d6efd;
  border-radius: 5px;
  padding-left: 10px;
}
.form-input.show {
  display: flex !important;
}
.switch-mode input[type='checkbox'] {
  accent-color: #0d6efd;
}
body.dark {
  background: #121212;
  color: #f0f0f0;
}
body.dark .bg-white {
  background-color: #1e1e2f !important;
}
body.dark .text-white {
  color: #f0f0f0 !important;
}
</style>

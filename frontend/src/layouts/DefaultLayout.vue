<template>
  <div class="d-flex vh-100">
    <!-- SIDEBAR -->
    <aside
      id="sidebar"
      class="bg-dark text-white p-3 sidebar d-flex flex-column justify-content-between"
      :class="{ hide: isSidebarHidden }"
    >
      <div>
        <h4 class="text-center mb-4">Bigscreen</h4>
        <nav class="nav flex-column side-menu">
          <router-link
            to="/admin/dashboard"
            class="nav-link text-white d-flex align-items-center gap-2"
            @click="handleNavClick"
          >
            <i class="bx bx-pie-chart-alt"></i>
            Dashboard
          </router-link>
          <router-link
            to="/admin/questions"
            class="nav-link text-white d-flex align-items-center gap-2"
            @click="handleNavClick"
          >
            <i class="bx bx-list-ul"></i>
            Questionnaire
          </router-link>
          <router-link
            to="/admin/responses"
            class="nav-link text-white d-flex align-items-center gap-2"
            @click="handleNavClick"
          >
            <i class="bx bx-spreadsheet"></i>
            Responses
          </router-link>
        </nav>
      </div>

      <!-- Logout -->
      <div class="text-center mt-4">
        <button @click="handleLogout" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2">
          <i class="bx bx-log-out"></i>
          Logout
        </button>
      </div>
    </aside>

    <!-- CONTENT -->
    <section id="content" class="flex-grow-1 d-flex flex-column">
      <!-- NAVBAR -->
      <nav class="navbar bg-white border-bottom px-3 py-2 d-flex align-items-center">
        <i class="bx bx-menu fs-4 me-3 d-md-none" @click="toggleSidebar"></i>
        <span class="fw-bold">Administration</span>
      </nav>

      <!-- MAIN -->
      <main class="flex-grow-1 overflow-auto p-4 bg-light">
        <router-view />
      </main>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()
const isSidebarHidden = ref(false)

// Toggle sidebar
const toggleSidebar = () => {
  isSidebarHidden.value = !isSidebarHidden.value
}

// Ferme la sidebar automatiquement sur mobile
const handleNavClick = () => {
  if (window.innerWidth < 768) {
    isSidebarHidden.value = true
  }
}

// Responsive
const handleResize = () => {
  if (window.innerWidth < 768) {
    isSidebarHidden.value = true
  }
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
})

// Logout
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
  transition: transform 0.3s ease;
}
.sidebar.hide {
  transform: translateX(-100%);
  position: absolute;
  z-index: 999;
}
.nav-link.router-link-active {
  font-weight: bold;
  background-color: #0d6efd;
  border-radius: 5px;
  padding-left: 10px;
}
@media (min-width: 768px) {
  .sidebar {
    transform: translateX(0) !important;
    position: relative;
  }
}
</style>

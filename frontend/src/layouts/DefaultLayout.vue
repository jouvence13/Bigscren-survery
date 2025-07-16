<template>
  <div class="d-flex vh-100">
    <!-- SIDEBAR -->
    <aside
      id="sidebar"
      ref="sidebar"
      class="bg-dark text-white p-3 sidebar"
      :class="{ hide: isSidebarHidden }"
    >
      <h4 class="text-center mb-4">Bigscreen</h4>
      <nav class="nav flex-column side-menu">
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

const sidebar = ref(null)
const searchForm = ref(null)
const searchIcon = ref(null)
const isSidebarHidden = ref(false)
const isDarkMode = ref(false)

// Toggle sidebar visibility
const toggleSidebar = () => {
  isSidebarHidden.value = !isSidebarHidden.value
}

// Toggle search visibility for mobile
const toggleSearch = (e) => {
  if (window.innerWidth < 576) {
    e.preventDefault()
    searchForm.value?.classList.toggle('show')
    const icon = searchIcon.value?.classList
    if (searchForm.value.classList.contains('show')) {
      icon?.replace('bx-search', 'bx-x')
    } else {
      icon?.replace('bx-x', 'bx-search')
    }
  }
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

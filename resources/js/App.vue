<template>
  <div id="app" class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar bg-dark text-white p-3">
      <h2 class="mb-4">Admin Panel</h2>
      <nav>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <router-link to="/receptions" class="nav-link text-white">Recepciones</router-link>
          </li>
          <li class="nav-item mb-2">
            <router-link to="/patients" class="nav-link text-white">Pacientes</router-link>
          </li>
          <li class="nav-item mb-2">
            <router-link to="/cups" class="nav-link text-white">CUPS</router-link>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <div class="main flex-grow-1">
      <!-- Header -->
      <header class="navbar navbar-dark bg-primary mb-3">
        <div class="container-fluid">
          <span class="navbar-brand">Sistema de Recepciones</span>
        </div>
      </header>

      <!-- Notificaciones -->
      <div v-if="message" :class="['alert', messageType === 'success' ? 'alert-success' : 'alert-danger']" role="alert">
        {{ message }}
      </div>

      <!-- Contenido principal renderizado según la ruta -->
      <main class="container">
        <router-view @notify="showMessage" />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const message = ref('')
const messageType = ref('success')

// Función para mostrar notificaciones desde cualquier componente
const showMessage = (type, text) => {
  messageType.value = type
  message.value = text
  setTimeout(() => { message.value = '' }, 3000)
}
</script>

<style>
/* Layout básico de panel */
#app {
  display: flex;
  height: 100vh;
}

.sidebar {
  width: 220px;
}

.main {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.nav-link.active {
  font-weight: bold;
  background-color: rgba(255,255,255,0.1);
}

.container {
  max-width: 900px;
}
</style>

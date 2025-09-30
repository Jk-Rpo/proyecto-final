<template>
  <div class="container">
    <h1>Editar Recepción</h1>

    <!-- Errores -->
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label>Paciente</label>
        <select v-model="form.patient_id" class="form-control" required>
          <option value="">Seleccione</option>
          <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Observaciones</label>
        <textarea v-model="form.observations" class="form-control"></textarea>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <input type="text" v-model="form.status" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>CUPS</label>
        <div class="form-check" v-for="c in cups" :key="c.id">
          <input
            class="form-check-input"
            type="checkbox"
            :value="c.id"
            v-model="form.cups"
            :id="'cup'+c.id"
          >
          <label class="form-check-label" :for="'cup'+c.id">{{ c.name }}</label><br>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="/receptions" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()
const receptionId = route.params.id // Si usas Vue Router para pasar ID

const patients = ref([])
const cups = ref([])
const errors = ref([])

const form = ref({
  patient_id: '',
  observations: '',
  status: '',
  cups: []
})

// Cargar datos del paciente, CUPS y recepción actual
onMounted(async () => {
  try {
    // Pacientes
    const resPatients = await axios.get('/api/patients')
    patients.value = resPatients.data

    // CUPS
    const resCups = await axios.get('/api/cups')
    cups.value = resCups.data

    // Recepción a editar
    const resReception = await axios.get(`/api/receptions/${receptionId}`)
    form.value.patient_id = resReception.data.patient_id
    form.value.observations = resReception.data.observations
    form.value.status = resReception.data.status
    form.value.cups = resReception.data.cups.map(c => c.id) // muchos a muchos
  } catch (e) {
    console.error(e)
  }
})

const submitForm = async () => {
  errors.value = []
  try {
    await axios.put(`/api/receptions/${receptionId}`, form.value)
    window.location.href = '/receptions' // Redirige al listado
  } catch (e) {
    if (e.response && e.response.data.errors) {
      errors.value = Object.values(e.response.data.errors).flat()
    } else {
      errors.value = ['Error al actualizar la recepción']
    }
  }
}
</script>

<style scoped>
.container {
  max-width: 800px;
  margin-top: 20px;
}
</style>

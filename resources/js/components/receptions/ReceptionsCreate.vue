<template>
  <div class="container">
    <h1>Crear Recepción</h1>

    <!-- Errores -->
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label>Paciente</label>
        <PatientSearch ></PatientSearch>
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
          <input class="form-check-input" type="checkbox" :value="c.id" v-model="form.cups" :id="'cup'+c.id">
          <label class="form-check-label" :for="'cup'+c.id">{{ c.name }}</label><br>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="/receptions" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import PatientSearch from '../patients/PatientSearch.vue'

const patients = ref([])
const cups = ref([])
const errors = ref([])
const patient = ref({})
const form = ref({
  patient_id: '',
  observations: '',
  status: '',
  cups: []
})

// Cargar pacientes y CUPS desde la API de Laravel
onMounted(async () => {
  try {
    const resPatients = await axios.get('/api/patients')
    patients.value = resPatients.data

    const resCups = await axios.get('/api/cups')
    cups.value = resCups.data
  } catch (e) {
    console.error(e)
  }
})

const submitForm = async () => {
  errors.value = []
  try {
    await axios.post('/receptions', form.value) // Cambia si tu ruta es diferente
    window.location.href = '/receptions' // Redirige después de guardar
  } catch (e) {
    if (e.response && e.response.data.errors) {
      errors.value = Object.values(e.response.data.errors).flat()
    } else {
      errors.value = ['Error al guardar la recepción']
    }
  }
}
const buscarpaciente = async (documento) => {
  try {
    const resPatient = await axios.get(`/api/patients/${form.value.patient_id}`)
    patient.value = resPatient.data
  } catch (e) {
    console.error(e)
  }
}
</script>

<style scoped>
.container {
  max-width: 800px;
  margin-top: 20px;
}
</style>

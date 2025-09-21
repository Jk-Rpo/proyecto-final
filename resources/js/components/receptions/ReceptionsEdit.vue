<template>
  <div>
    <h1>Editar Recepción</h1>
    <form @submit.prevent="submit">
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
        <div v-for="c in cups" :key="c.id" class="form-check">
          <input type="checkbox" class="form-check-input" :value="c.id" v-model="form.cups">
          <label class="form-check-label">{{ c.name }}</label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Actualizar</button>
      <router-link to="/receptions" class="btn btn-secondary">Cancelar</router-link>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const form = ref({
  patient_id: '',
  observations: '',
  status: '',
  cups: []
})

const patients = ref([])
const cups = ref([])

const fetchData = async () => {
  const patientsRes = await axios.get('/api/patients')
  patients.value = patientsRes.data

  const cupsRes = await axios.get('/api/cups')
  cups.value = cupsRes.data

  const receptionRes = await axios.get(`/api/receptions/${route.params.id}`)
  const r = receptionRes.data
  form.value.patient_id = r.patient_id
  form.value.observations = r.observations
  form.value.status = r.status
  form.value.cups = r.cups.map(c => c.id)
}

const submit = async () => {
  await axios.put(`/api/receptions/${route.params.id}`, form.value)
  router.push('/receptions')
}

onMounted(fetchData)
</script>

<template>
  <div class="">
    <h1>Crear Recepción de Paciente</h1>

    <!-- Errores -->
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="() => {}">
      <div class="mb-3 flex flex-col md:px-4">
        <PatientSearch 
          ref="patientSearchRef"
          @handlePatient="handlePatient"
          @handlePatientNotFound="handlePatientNotFound"
        ></PatientSearch>
      </div>

      <div class="flex flex-wrap w-full">
        <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Número de Caso</label>
          <input type="text" v-model="form.number_case" class="form-control" required>
        </div>
  
        <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Cantidad de Placas</label>
          <input type="number" v-model="form.quantity_plates" class="form-control" required>
        </div>
  
        <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Institución que Remite</label>
          <select v-model="form.institution" class="form-control">
            <option v-for="institution in institutions" :key="institution.id" :value="institution.id">{{ institution.name }}</option>
          </select>
        </div>
  
        <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Fecha de Salida</label>
          <select v-model="form.type_study" class="form-control">
            <option v-for="item in typeStudies" :key="item.id" :value="item.id">{{ item.name }}</option>
          </select>
        </div>
  
        <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Prioridad</label>
          <select v-model="form.priority" class="form-control">
            <option v-for="item in priority" :key="item.id" :value="item.id">{{ item.name }}</option>
          </select>
        </div>
  
        <div class="w-full md:w-1/2 md:px-4 mb-3">
          <label>Tipo de coloración</label>
          <el-checkbox-group v-model="form.color">
            <el-checkbox v-for="item in typeColors" :key="item.id" :label="item.name" :value="item.id" />
          </el-checkbox-group>
        </div>
  
        <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Entregado a</label>
          <input type="text" v-model="form.delivered_to" class="form-control" required>
        </div>
      </div>

      <div class="flex justify-end space-x-2">
        <int-button type="primary" @click="submitForm">
          Guardar
        </int-button>
        <int-button type="secondary" href="/receptions/create">
          Cancelar
        </int-button>
      </div>
    </form>

    
    <ModalCreatedPatient
      v-if="showModalCreatedPatient"
      :show="showModalCreatedPatient"
      @created="handlePatient($event, true)"
      @close="closeModalCreatedPatient"
    ></ModalCreatedPatient>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import PatientSearch from '../patients/PatientSearch.vue'
import ModalCreatedPatient from '../patients/ModalCreatedPatient.vue'
import { ElNotification } from 'element-plus'
import { priority, institutions, typeStudies, typeColors } from '../../optionsForms'

const cups = ref([])
const errors = ref([])

// fields
const form = ref({
  patient_id: '',
  institution: '',
  cups: [],
  priority: 'low',
  // datos relacionados con un estudio especial
  number_case: '',
  type_study: '',
  color: [],
  quantity_plates: '',
  delivered_to: '',
})

const patientSearchRef = ref(null)
const showModalCreatedPatient = ref(false)
const addCupModal = ref(false)
const selectedCup = ref(null)
const selectedCupQuantity = ref(null)

// Cargar pacientes y CUPS desde la API de Laravel
onMounted(async () => {
  loadCups()
})

const loadCups = async () => {
  try {
    const resCups = await axios.get('/api/cups')
    cups.value = resCups.data.data
  } catch (e) {
    console.error(e)
  }
}

const submitForm = async () => {
  errors.value = []
  try {
    await axios.post('/api/receptions', form.value) // Cambia si tu ruta es diferente
    window.location.href = '/receptions' // Redirige después de guardar
  } catch (e) {
    if (e.response && e.response.data.errors) {
      errors.value = Object.values(e.response.data.errors).flat()
    } else {
      errors.value = ['Error al guardar la recepción']
    }
  }
}

const handlePatient = (patient, created = false) => {
  form.value.patient_id = patient.id
  patient.value = patient
  if (patientSearchRef.value) {
    patientSearchRef.value.patient = patient
    patientSearchRef.value.error = ''
  }
}
const handlePatientNotFound = () => {
  form.value.patient_id = ''
  showModalCreatedPatient.value = true
}

const closeModalCreatedPatient = () => {
  showModalCreatedPatient.value = false
}

const addCup = () => {
  if (!selectedCup.value || !selectedCupQuantity.value) {
    ElNotification({
      title: 'Error',
      message: 'Debe seleccionar una CUPS y una cantidad',
      type: 'error'
    })
  }
  const cup = cups.value.find(c => c.id === selectedCup.value)
  form.value.cups.push({ 
    id: cup.id,
    quantity: selectedCupQuantity.value,
    name: cup.code + ' - ' + cup.description,
  })
  addCupModal.value = false
  selectedCup.value = null
  selectedCupQuantity.value = null
}

const removeCup = (index) => {
  form.value.cups.splice(index, 1)
}

</script>

<style scoped>
.container {
  max-width: 800px;
  margin-top: 20px;
}
</style>

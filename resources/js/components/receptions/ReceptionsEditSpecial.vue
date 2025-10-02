<template>
  <div class="">
    <h1>Editar Recepción de Paciente</h1>

    <!-- Errores -->
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="submitForm">
      <div class="mb-3 flex flex-col">
        <PatientSearch
          ref="patientSearchRef"
          :show-search="false"
          :initial-patient="form.patient"
        />
      </div>

      <div class="flex flex-wrap w-full">
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Número de Caso</label>
          <input type="text" v-model="form.number_case" class="form-control" required>
        </div>
  
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Cantidad de Placas</label>
          <input type="number" v-model="form.quantity_plates" class="form-control" required>
        </div>
  
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Institución que Remite</label>
          <select v-model="form.institution" class="form-control">
            <option v-for="institution in institutions" :key="institution.id" :value="institution.id">
              {{ institution.name }}
            </option>
          </select>
        </div>
  
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Prioridad</label>
          <select v-model="form.priority" class="form-control">
            <option v-for="item in priority" :key="item.id" :value="item.id">{{ item.name }}</option>
          </select>
        </div>
  
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Tipo de coloración</label>
          <el-checkbox-group v-model="form.color">
            <el-checkbox v-for="item in typeColors" :key="item.id" :label="item.id">
              {{ item.name }}
            </el-checkbox>
          </el-checkbox-group>
        </div>
  
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Fecha de Salida</label>
          <input type="date" v-model="form.departure_date" class="form-control">
        </div>
  
        <div class="full md:w-1/2 md:px-4 mb-3 flex flex-col">
          <label>Entregado a</label>
          <input type="text" v-model="form.delivered_to" class="form-control">
        </div>
      </div>


      <div class="flex justify-end space-x-2">
        <int-button type="primary">
          Actualizar
        </int-button>
        <int-button type="secondary" href="/receptions">
          Cancelar
        </int-button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import PatientSearch from '../patients/PatientSearch.vue'
import { ElNotification } from 'element-plus'
import { priority, institutions, typeColors } from '../../optionsForms'

const props = defineProps({
  id: { type: Object, required: true } // recepción cargada desde el backend
})

const emit = defineEmits(['updated'])

const cups = ref([])
const errors = ref([])


const form = ref({
  id: '',
  patient_id: '',
  patient: null,
  type_samples: '',
  institution: '',
  cups: [],
  priority: 'low',
  number_case: '',
  type_study: '',
  color: [],
  quantity_plates: '',
  delivered_to: '',
  departure_date: '',
})

const patientSearchRef = ref(null)
const showModalCreatedPatient = ref(false)

onMounted(async () => {
  await loadCups()
  await loadReception()
})

const loadReception = async () => {
  const {data} = await axios.get(`/api/receptions/${props.id}`)
  console.log(data)
  form.value.id = data.id
  form.value.patient_id = data.patient_id
  form.value.patient = data.patient ?? null
  form.value.type_samples = data.type_samples ?? ''
  form.value.institution = data.institution ?? ''
  form.value.cups = data.cups?.map(cup => ({
    id: cup.id,
    quantity: cup.pivot.quantity,
    name: cup.code + ' - ' + cup.description,
  })) ?? []
  form.value.priority = data.priority ?? 'low'
  form.value.number_case = data.number_case ?? ''
  form.value.type_study = data.type_study ?? ''
  form.value.color = data.color ?? []
  form.value.quantity_plates = data.quantity_plates ?? ''
  form.value.delivered_to = data.delivered_to ?? ''
  form.value.departure_date = data.departure_date ?? ''
  if (data.patient) {
    handlePatient(data.patient)
  }
}
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
    await axios.put(`/api/receptions/${form.value.id}`, form.value)
    ElNotification({
      title: 'Éxito',
      message: 'Recepción actualizada correctamente',
      type: 'success'
    })
    emit('updated', form.value)
    window.location.href = '/receptions'
  } catch (e) {
    if (e.response && e.response.data.errors) {
      errors.value = Object.values(e.response.data.errors).flat()
    } else {
      errors.value = ['Error al actualizar la recepción']
    }
  }
}

const handlePatient = (patient, created = false) => {
  form.value.patient_id = patient.id
  form.value.patient = patient
  if (patientSearchRef.value) {
    patientSearchRef.value.patient = patient
    patientSearchRef.value.error = ''
  }
}
</script>

<style scoped>
.container {
  max-width: 800px;
  margin-top: 20px;
}
</style>

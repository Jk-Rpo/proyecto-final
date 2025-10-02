<template>
    <div>
      <h1>Editar Recepción de Paciente</h1>
  
      <!-- Errores -->
      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>
  
      <form @submit.prevent="() => {}">
        <!-- Paciente -->
        <div class="mb-3 flex flex-col md:px-4">
          <PatientSearch 
            ref="patientSearchRef"
            :show-search="false"
          />
        </div>

        <div class="flex flex-wrap w-full">
          <!-- Tipo de muestra -->
          <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
            <label>Tipo de Muestra</label>
            <select v-model="form.type_samples" class="form-control">
              <option v-for="typeSample in typeSamples" :key="typeSample.id" :value="typeSample.id">
                {{ typeSample.name }}
              </option>
            </select>
          </div>
    
          <!-- Cantidad -->
          <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
            <label>Cantidad de Muestras</label>
            <input type="number" v-model="form.quantity_samples" class="form-control" required>
          </div>
    
          <!-- Institución -->
          <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
            <label>Institución que Remite</label>
            <select v-model="form.institution" class="form-control">
              <option v-for="institution in institutions" :key="institution.id" :value="institution.id">
                {{ institution.name }}
              </option>
            </select>
          </div>
    
          <!-- Prioridad -->
          <div class="w-full md:w-1/2 md:px-4 mb-3 flex flex-col">
            <label>Prioridad</label>
            <select v-model="form.priority" class="form-control">
              <option v-for="item in priority" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select>
          </div>
    
          <!-- CUPS -->
          <div class="w-full md:w-1/2 md:px-4 mb-3">
            <table class="table-auto w-full" v-if="form.cups.length > 0">
              <thead class="bg-gray-200">
                <tr>
                  <th class="p-4 text-left">CUPS</th>
                  <th class="p-4 text-right">Cantidad</th>
                  <th class="p-4 text-right">Acciones</th>
                </tr>
              </thead>
              <tbody class="bg-white">
                <tr v-for="(value, index) in form.cups" :key="value.id">
                  <td class="px-4 py-2 text-left">{{ value.name }}</td>
                  <td class="px-4 py-2 text-right">{{ value.quantity }}</td>
                  <td class="text-right">
                    <int-button type="tertiary" color="danger" @click="removeCup(index)">Eliminar</int-button>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-else>
              <label>CUPS </label>
              <div class="w-3/4 text-red-500">No has seleccionado ninguna CUP</div>
            </div>
            <div class="w-full flex justify-end items-center pt-4">
              <int-button type="secondary" @click="addCupModal = true">Agregar CUP</int-button>
            </div>
          </div>
        </div>
  
        <!-- Botones -->
        <div class="flex justify-end space-x-2">
          <int-button type="primary" @click="submitForm">
            Actualizar
          </int-button>
          <int-button type="secondary" href="/receptions">
            Cancelar
          </int-button>
        </div>
      </form>
  
      <AddCupModal 
        v-if="addCupModal"
        :cups="cups"
        v-model="form.cups"
        :show="addCupModal"
        @close="addCupModal = false"
        />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import PatientSearch from '../patients/PatientSearch.vue'
  import { ElNotification } from 'element-plus'
  import { priority, typeSamples, institutions } from '../../optionsForms'
  import AddCupModal from './AddCupModal.vue'
  
  // Props: id del registro
  const props = defineProps({ id: { type: Number, required: true } })
  
  const cups = ref([])
  const errors = ref([])
  const form = ref({
    id: '',
    patient_id: '',
    type_samples: '',
    institution: '',
    cups: [],
    priority: 'low',
    quantity_samples: '',
  })
  
  const patientSearchRef = ref(null)
  const addCupModal = ref(false)
  
  onMounted(async () => {
    loadCups()
    loadReception()
  })
  
  const loadCups = async () => {
    try {
      const res = await axios.get('/api/cups')
      cups.value = res.data.data
    } catch (e) {
      console.error(e)
    }
  }
  
  const loadReception = async () => {
    try {
      const res = await axios.get(`/api/receptions/${props.id}`)
      form.value.id = res.data.id
      form.value.patient_id = res.data.patient_id
      form.value.type_samples = res.data.type_samples ?? ''
      form.value.institution = res.data.institution ?? ''
      form.value.cups = res.data.cups?.map(cup => ({
        id: cup.id,
        quantity: cup.pivot.quantity,
        name: cup.code + ' - ' + cup.description,
      })) ?? []
      form.value.priority = res.data.priority ?? 'low'
      form.value.quantity_samples = res.data.quantity_samples ?? ''
      form.value.observations = res.data.observations ?? ''
      form.value.status = res.data.status ?? 'pending'
      if (res.data.patient) {
        handlePatient(res.data.patient)
      }
    } catch (e) {
      console.error(e)
    }
  }
  
  const submitForm = async () => {
    errors.value = []
    try {
      await axios.put(`/api/receptions/${props.id}`, form.value)
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
    if (patientSearchRef.value) {
      patientSearchRef.value.patient = patient
      patientSearchRef.value.error = ''
    }
  }
  const removeCup = (index) => form.value.cups.splice(index, 1)
  </script>
  
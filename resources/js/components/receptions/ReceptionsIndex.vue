<template>
  <div>
    <h1>Recepciones</h1>
    <router-link to="/receptions/create" class="btn btn-primary mb-3">Crear Nueva Recepción</router-link>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Paciente</th>
          <th>Observaciones</th>
          <th>Status</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="reception in receptions" :key="reception.id">
          <td>{{ reception.id }}</td>
          <td>{{ reception.patient?.name }}</td>
          <td>{{ reception.observations }}</td>
          <td>{{ reception.status }}</td>
          <td>
            <router-link :to="`/receptions/${reception.id}`" class="btn btn-info btn-sm">Ver</router-link>
            <router-link :to="`/receptions/${reception.id}/edit`" class="btn btn-warning btn-sm">Editar</router-link>
            <button @click="deleteReception(reception.id)" class="btn btn-danger btn-sm">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const receptions = ref([])
const router = useRouter()

const fetchReceptions = async () => {
  const res = await axios.get('/api/receptions')
  receptions.value = res.data
}

const deleteReception = async (id) => {
  if (confirm('¿Eliminar esta recepción?')) {
    await axios.delete(`/api/receptions/${id}`)
    fetchReceptions()
  }
}

onMounted(fetchReceptions)
</script>

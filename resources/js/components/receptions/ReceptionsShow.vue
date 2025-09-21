<template>
  <div>
    <h1>Detalle Recepción #{{ reception.id }}</h1>
    <p><strong>Paciente:</strong> {{ reception.patient?.name }}</p>
    <p><strong>Observaciones:</strong> {{ reception.observations }}</p>
    <p><strong>Status:</strong> {{ reception.status }}</p>
    <p><strong>CUPS:</strong>
      <span v-for="c in reception.cups" :key="c.id">{{ c.name }}<span v-if="!$last">, </span></span>
    </p>
    <router-link to="/receptions" class="btn btn-secondary">Volver</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()
const reception = ref({ patient: {}, cups: [] })

const fetchReception = async () => {
  const res = await axios.get(`/api/receptions/${route.params.id}`)
  reception.value = res.data
}

onMounted(fetchReception)
</script>

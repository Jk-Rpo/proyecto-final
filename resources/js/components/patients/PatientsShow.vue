<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">
      Detalle Paciente #{{ patient?.id }}
    </h1>

    <div v-if="patient">
      <p><strong>Documento:</strong> {{ patient.identity_type }} {{ patient.identity }}</p>
      <p><strong>Nombre:</strong> {{ patient.first_name }} {{ patient.second_name }} {{ patient.first_surname }} {{ patient.second_surname }}</p>
      <p><strong>Fecha Nacimiento:</strong> {{ patient.birthdate }}</p>
      <p><strong>Género:</strong> {{ patient.gender }}</p>
      <p><strong>Teléfono:</strong> {{ patient.phone }}</p>
      <p><strong>Dirección:</strong> {{ patient.address }}</p>
      <p><strong>Email:</strong> {{ patient.email }}</p>
    </div>

    <a href="/patients" class="btn btn-secondary mt-4">Volver</a>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
const props = defineProps({
  id: {
    type: Number,
    required: true,
  },
});



const patient = ref(null);

async function fetchPatient() {
  const { data } = await axios.get(`/api/patients/${props.id}`);
  patient.value = data;
}

onMounted(fetchPatient);
</script>

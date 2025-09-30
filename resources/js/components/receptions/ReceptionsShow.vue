<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">
      Detalle Recepción #{{ reception?.id }}
    </h1>

    <div v-if="loading">Cargando...</div>
    <div v-else-if="reception">
      <p><strong>Paciente:</strong> {{ reception.patient?.name || "Sin paciente" }}</p>
      <p><strong>CUS:</strong> {{ reception.cus || "No registrado" }}</p>
      <p><strong>Observaciones:</strong> {{ reception.observations }}</p>
      <p><strong>Status:</strong> {{ reception.status }}</p>
      <p>
        <strong>CUPS:</strong>
        <span v-if="reception.cups && reception.cups.length">
          {{ reception.cups.map(cup => cup.name).join(", ") }}
        </span>
        <span v-else>Sin CUPS</span>
      </p>

      <a href="/receptions" class="btn btn-secondary mt-4 inline-block">
        Volver
      </a>
    </div>
    <div v-else>
      <p class="text-red-500">No se encontró la recepción.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";

const route = useRoute();
const reception = ref(null);
const loading = ref(true);

async function fetchReception() {
  try {
    const { data } = await axios.get(`/api/receptions/${route.params.id}`);
    reception.value = data;
  } catch (error) {
    console.error("Error cargando recepción", error);
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  fetchReception();
});
</script>

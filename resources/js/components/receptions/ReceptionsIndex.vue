<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Recepciones</h1>

    <!-- Botón para crear -->
    <a
      href="/receptions/create"
      class="btn btn-primary mb-3 inline-block"
    >
      Crear Nueva Recepción
  </a>

    <!-- Mensaje de éxito -->
    <div v-if="successMessage" class="alert alert-success mb-3">
      {{ successMessage }}
    </div>

    <!-- Tabla -->
    <table class="table table-bordered w-full">
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
          <td>{{ reception.patient?.name || 'Sin paciente' }}</td>
          <td>{{ reception.observations }}</td>
          <td>{{ reception.status }}</td>
          <td class="space-x-2">
            <a
              :hf="`/receptions/${reception.id}`"
              class="btn btn-info btn-sm"
            >
              Ver
            </a>
            <a
              :href="`/receptions/${reception.id}/edit`"
              class="btn btn-warning btn-sm"
            >
              Editar
          </a>
            <button
              class="btn btn-danger btn-sm"
              @click="deleteReception(reception.id)"
            >
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-4 flex space-x-2">
      <button
        v-if="pagination.prev_page_url"
        @click="fetchReceptions(pagination.prev_page_url)"
        class="btn btn-secondary"
      >
        Anterior
      </button>
      <button
        v-if="pagination.next_page_url"
        @click="fetchReceptions(pagination.next_page_url)"
        class="btn btn-secondary"
      >
        Siguiente
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const receptions = ref([]);
const pagination = ref({});
const successMessage = ref(null);

async function fetchReceptions(url = "/api/receptions") {
  try {
    const { data } = await axios.get(url);
    receptions.value = data.data; // Laravel paginator devuelve data
    pagination.value = {
      next_page_url: data.next_page_url,
      prev_page_url: data.prev_page_url,
    };
  } catch (error) {
    console.error("Error cargando recepciones", error);
  }
}

async function deleteReception(id) {
  if (!confirm("¿Eliminar esta recepción?")) return;
  try {
    await axios.delete(`/api/receptions/${id}`);
    successMessage.value = "Recepción eliminada correctamente";
    fetchReceptions();
  } catch (error) {
    console.error("Error eliminando recepción", error);
  }
}

onMounted(() => {
  fetchReceptions();
});
</script>

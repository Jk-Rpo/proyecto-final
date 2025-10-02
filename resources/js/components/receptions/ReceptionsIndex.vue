<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Recepciones</h1>

    <div class="flex justify-between flex-col md:flex-row gap-2 pb-4">
      <!-- Botón para crear -->
      <int-button
        href="/receptions/create"
        class="inline-block w-full md:w-auto"
      >
        Crear Nueva Recepción
      </int-button>

      
      <!-- Filtro por documento -->
       <div class="w-full md:w-60">
         <input type="text" v-model="identity" 
          class="form-control w-full md:w-60" 
          placeholder="Buscar por número de documento"
          autocomplete="off"
          @keyup="handleIdentity()">
       </div>
    </div>

    <!-- Mensaje de éxito -->
    <div v-if="successMessage" class="alert alert-success mb-3">
      {{ successMessage }}
    </div>

    <!-- Tabla -->
     <div class="overflow-x-auto w-full">
       <table class="table-auto md:table-fixed w-full">
         <thead>
           <tr class="bg-gray-200">
             <th class="p-4">Documento del Paciente</th>
             <th class="p-4">Tipo</th>
             <th class="p-4">Consecutivo</th>
             <th class="p-4">Nombres y Apellidos</th>
             <th class="p-4">Acciones</th>
           </tr>
         </thead>
         <tbody class="bg-white">
           <tr v-for="reception in receptions" :key="reception.id" class="border-b border-gray-200">
             <td class="px-4 py-2"><p>{{ reception.patient.identity_type }} - {{ reception.patient.identity }}</p></td>
             <td class="px-4 py-2"><p>{{ reception.is_special ? 'Especial' : 'Paciente' }}</p></td>
             <td class="px-4 py-2"><p>{{ reception.consecutive }}</p></td>
             <td class="px-4 py-2"><p>{{ reception.patient.first_name }} {{ reception.patient.second_name }} {{ reception.patient.first_surname }} {{ reception.patient.second_surname }}</p></td>
             <td class="px-2 py-2 space-x-2">
              <a :href="`/receptions/${ reception.id }`"><i class="fa-solid fa-eye text-secondary"></i></a>
              <a :href="`/receptions/${ reception.id }/edit`"><i class="fa-solid fa-pencil text-primary"></i></a>
              <span @click="deleteReception(reception.id)"><i class="fa-solid fa-trash text-danger"></i></span>
             </td>
           </tr>
         </tbody>
       </table>
     </div>

    <!-- Paginación -->
    <div class="mt-4 flex space-x-2">
      <int-button
        v-if="pagination.prev_page_url"
        @click="fetchReceptions(pagination.prev_page_url)"
        type="secondary"
        color="primary"
      >
        Anterior
      </int-button>
      <button
        v-if="pagination.next_page_url"
        @click="fetchReceptions(pagination.next_page_url)"
        type="secondary"
        color="primary"
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
const identity = ref('');
const timer = ref(null);

const handleIdentity = () => {
  clearTimeout(timer.value); // primero limpio el anterior (para evitar duplicados)

  timer.value = setTimeout(() => {
    fetchReceptions();
  }, 500); // 500 ms
}

async function fetchReceptions(url = "/api/receptions") {
  try {
    const { data } = await axios.get(url, {
      params: {
        identity: identity.value,
      },
    });
    console.log(data);
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

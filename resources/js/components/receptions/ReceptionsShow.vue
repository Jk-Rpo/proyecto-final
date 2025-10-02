<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">
      Detalle Recepción #{{ reception?.id }} - {{ reception?.is_special ? reception?.number_case : reception?.consecutive }}
    </h1>

    <div v-if="loading">Cargando...</div>
    <div v-else-if="reception" class="w-full flex flex-wrap">
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Documento:</strong> {{ reception.patient.identity_type }} - {{ reception.patient.identity }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Recepcionista:</strong> {{ reception.user.name }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Tipo de Muestras:</strong> {{ typeSamples.find(item => item.id === reception.type_samples)?.name }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Institución que Remite:</strong> {{ reception.institution }}</p>
      </div>
      <template v-if="!reception.is_special">
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Consecutivo:</strong> {{ reception.consecutive }}</p>
        </div>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Cantidad de Muestras:</strong> {{ reception.quantity_samples }}</p>
        </div>
        <div v-if="reception.cups && reception.cups.length > 0" class="w-full md:w-1/2 md:px-4 py-2" >
          <table class="table-auto w-full border">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-4 text-left">CUPS</th>
                <th class="p-4 text-right">Cantidad</th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr v-for="cup in reception.cups" :key="cup.id">
                <td class="p-4 text-left">{{ cup.code }} - {{ cup.description }}</td>
                <td class="p-4 text-right">{{ cup.pivot.quantity }}</td>
              </tr>
            </tbody>
        </table>
        </div>
      </template>
      <template v-else>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Número de Caso:</strong> {{ reception.number_case }}</p>
        </div>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Tipo de Estudio:</strong> {{ typeStudies.find(item => item.id === reception.type_study)?.name }}</p>
        </div>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Coloración:</strong> {{ reception.color.join(', ') }}</p>
        </div>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Cantidad de Placas:</strong> {{ reception.quantity_plates }}</p>
        </div>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Fecha de Salida:</strong> {{ reception.departure_date }}</p>
        </div>
        <div class="w-full md:w-1/2 md:px-4 py-2">
          <p><strong>Entregado a:</strong> {{ reception.delivered_to }}</p>
        </div>
      </template>
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Observaciones:</strong> {{ reception.observations }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Estado:</strong> {{ status.find(item => item.id === reception.status)?.name }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4 py-2">
        <p><strong>Prioridad:</strong> {{ priority.find(item => item.id === reception.priority)?.name }}</p>
      </div>
    </div>
    <div v-else>
      <p class="text-red-500">No se encontró la recepción.</p>
    </div>
    <div class="flex flex-row justify-between items-center pt-4">
      <div>
        <int-button href="/receptions" type="secondary" color="primary">
          Volver a Recepciones
        </int-button>      
      </div>
      <div class="flex space-x-2 flex-row">
        <int-button :href="`/receptions/${reception?.id}/edit`" type="icon" color="primary">
          <i class="fa-solid fa-pencil"></i>
        </int-button>
        <int-button @click="deleteReception" type="icon" color="danger">
          <i class="fa-solid fa-trash"></i>
        </int-button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { status, priority, typeSamples, typeStudies } from '../../optionsForms';

const props = defineProps({
  id: {
    type: Number,
    required: true,
  },
});

const reception = ref(null);
const loading = ref(true);

async function fetchReception() {
  try {
    const { data } = await axios.get(`/api/receptions/${props.id}`);
    reception.value = data;
  } catch (error) {
    console.error("Error cargando recepción", error);
  } finally {
    loading.value = false;
  }
}

const deleteReception = async () => {
  if (!confirm("¿Eliminar esta recepción?")) return;
  await axios.delete(`/api/receptions/${props.id}`);
  window.location.href = '/receptions';
}

onMounted(() => {
  fetchReception();
});
</script>

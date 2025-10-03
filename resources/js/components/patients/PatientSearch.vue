<template>
  <div class="mt-4">
    <!-- Input de búsqueda -->
    <template v-if="showSearch">
      <div class="mb-3 flex flex-col">
        <label for="identity" class="form-label">Número de Documento</label>
        <input
          v-model="identity"
          type="text"
          id="identity"
          class="form-control"
          autocomplete="off"
          placeholder="Ingrese el número de documento"
        />
      </div>

      <!-- Botón buscar manual (opcional) -->
      <button @click="searchPatient" class="btn btn-primary">Buscar</button>
    </template>

    <!-- Mensaje de error -->
    <div v-if="error" class="alert alert-danger mt-3">
      {{ error }}
    </div>

    <!-- Resultado -->
    <div v-if="patient" class="flex flex-wrap mt-4">
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Nombres y Apellidos:</strong> 
          {{ patient.first_name }} {{ patient.second_name ?? '' }}
          {{ patient.first_surname }} {{ patient.second_surname ?? '' }}
        </p>
      </div>
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Documento:</strong> {{ patient.identity_type }} - {{ patient.identity }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Fecha de nacimiento:</strong> {{ patient.birthdate }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Género:</strong> {{ patient.gender }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Teléfono:</strong> {{ patient.phone }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Dirección:</strong> {{ patient.address }}</p>
      </div>
      <div class="w-full md:w-1/2 md:px-4">
        <p class="pb-2"><strong>Email:</strong> {{ patient.email }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import axios from "axios";

const identity = ref("");
const patient = ref(null);
const error = ref("");
const debounceTimer = ref(null);

const props = defineProps({
  showSearch: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(["handlePatient", "handlePatientNotFound"]);

const searchPatient = async () => {
  error.value = "";
  patient.value = null;

  if (!identity.value) {
    error.value = "Debe ingresar un número de documento";
    return;
  }

  try {
    const response = await axios.get(`/api/patients/search/${identity.value}`);
    patient.value = response.data;
    emit("handlePatient", patient.value);
  } catch (err) {
    error.value = err.response?.data?.message || "Error al buscar paciente";
    emit("handlePatientNotFound");
  }
};

// 👇 Aquí está el "timer/debounce"
watch(identity, (newVal) => {
  if (debounceTimer.value) clearTimeout(debounceTimer.value);

  // espera 1000ms después de dejar de escribir
  debounceTimer.value = setTimeout(() => {
    if (newVal.trim() !== "") {
      searchPatient();
    } else {
      patient.value = null;
      error.value = "";
    }
  }, 1000);
});

defineExpose({
  patient,
  error
});
</script>

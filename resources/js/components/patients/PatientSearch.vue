<template>
  <div class="container mt-4">
    <h2>Buscar Paciente</h2>

    <!-- Input de búsqueda -->
    <div class="mb-3">
      <label for="identity" class="form-label">Número de Documento</label>
      <input
        v-model="identity"
        type="text"
        id="identity"
        class="form-control"
        placeholder="Ingrese el número de documento"
      />
    </div>

    <!-- Botón buscar -->
    <button @click="searchPatient" class="btn btn-primary">Buscar</button>

    <!-- Mensaje de error -->
    <div v-if="error" class="alert alert-danger mt-3">
      {{ error }}
    </div>

    <!-- Resultado -->
    <div v-if="patient" class="card mt-4">
      <div class="card-body">
        <h5 class="card-title">
          {{ patient.first_name }} {{ patient.second_name ?? '' }}
          {{ patient.first_surname }} {{ patient.second_surname ?? '' }}
        </h5>
        <p><strong>Documento:</strong> {{ patient.identity_type }} {{ patient.identity }}</p>
        <p><strong>Fecha de nacimiento:</strong> {{ patient.birthdate }}</p>
        <p><strong>Género:</strong> {{ patient.gender }}</p>
        <p><strong>Teléfono:</strong> {{ patient.phone }}</p>
        <p><strong>Dirección:</strong> {{ patient.address }}</p>
        <p><strong>Email:</strong> {{ patient.email }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const identity = ref("");
const patient = ref(null);
const error = ref("");

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
  } catch (err) {
    error.value = err.response?.data?.message || "Error al buscar paciente";
  }
};
</script>

<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Pacientes</h1>

    <a href="/patients/create" class="btn btn-primary mb-3">
      Crear Paciente
    </a>

    <table class="table-auto w-full border">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-2 py-1">ID</th>
          <th class="px-2 py-1">Documento</th>
          <th class="px-2 py-1">Nombre</th>
          <th class="px-2 py-1">Teléfono</th>
          <th class="px-2 py-1">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="patient in patients.data" :key="patient.id">
          <td class="border px-2 py-1">{{ patient.id }}</td>
          <td class="border px-2 py-1">{{ patient.identity_type }} {{ patient.identity }}</td>
          <td class="border px-2 py-1">
            {{ patient.first_name }} {{ patient.second_name }} {{ patient.first_surname }} {{ patient.second_surname }}
          </td>
          <td class="border px-2 py-1">{{ patient.phone }}</td>
          <td class="border px-2 py-1">
            <a :href="`/patients/${patient.id}`" :to="`/patients/${patient.id}`" class="btn btn-info btn-sm">Ver</a>
            <a :href="`/patients/${patient.id}/edit`" class="btn btn-warning btn-sm">Editar</a>
            <button @click="deletePatient(patient.id)" class="btn btn-danger btn-sm">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const patients = ref([]);

async function fetchPatients() {
  const { data } = await axios.get("/api/patients");
  patients.value = data;
  console.log(patients.value);
}

async function deletePatient(id) {
  if (confirm("¿Eliminar paciente?")) {
    await axios.delete(`/api/patients/${id}`);
    fetchPatients();
  }
}

onMounted(fetchPatients);
</script>

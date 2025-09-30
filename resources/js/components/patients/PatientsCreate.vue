<template>
  <div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Crear Paciente</h1>

    <form @submit.prevent="savePatient" class="space-y-3">
      <div>
        <label>Tipo Documento</label>
        <input v-model="form.identity_type" class="input" required />
      </div>
      <div>
        <label>Número Documento</label>
        <input v-model="form.identity" class="input" required />
      </div>
      <div>
        <label>Primer Nombre</label>
        <input v-model="form.first_name" class="input" required />
      </div>
      <div>
        <label>Segundo Nombre</label>
        <input v-model="form.second_name" class="input" />
      </div>
      <div>
        <label>Primer Apellido</label>
        <input v-model="form.first_surname" class="input" required />
      </div>
      <div>
        <label>Segundo Apellido</label>
        <input v-model="form.second_surname" class="input" />
      </div>
      <div>
        <label>Fecha Nacimiento</label>
        <input type="date" v-model="form.birthdate" class="input" required />
      </div>
      <div>
        <label>Género</label>
        <input v-model="form.gender" class="input" />
      </div>
      <div>
        <label>Teléfono</label>
        <input type="number" v-model="form.phone" class="input" required />
      </div>
      <div>
        <label>Dirección</label>
        <input v-model="form.address" class="input" />
      </div>
      <div>
        <label>Email</label>
        <input type="email" v-model="form.email" class="input" />
      </div>

      <button class="btn btn-primary">Guardar</button>
      <a href="/patients" class="btn btn-secondary ml-2">Cancelar</a>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";


const form = ref({
  identity_type: "",
  identity: "",
  first_name: "",
  second_name: "",
  first_surname: "",
  second_surname: "",
  birthdate: "",
  gender: "",
  phone: "",
  address: "",
  email: "",
});

async function savePatient() {
  await axios.post("/api/patients", form.value).then(() => {
    window.location.href = "/patients";
  });
 
}
</script>

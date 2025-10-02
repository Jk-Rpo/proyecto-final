<template>
  <el-dialog 
    v-if="show"
    :model-value="show"
    :before-close="closeModal"
    modal-class="max-w-11/12 md:max-w-3/4 lg:max-w-1/2"
  >
    <div class="w-full">
      <div class="flex flex-col justify-between items-center p-6 mx-auto">
        <h2 class="text-xl font-bold mb-4 w-full">Crear Paciente</h2>
  
        <form @submit.prevent="savePatient"
        class="space-y-3 w-full">
          <div>
            <label class="block text-sm font-medium">Tipo Documento</label>
            <el-select v-model="form.identity_type" class="w-full border rounded p-2" required>
              <el-option v-for="item in identityTypes" :key="item.id" :label="item.name" :value="item.id" />
            </el-select>
          </div>
  
          <div>
            <label class="block text-sm font-medium">Número Documento</label>
            <input v-model="form.identity" class="w-full border rounded p-2" required />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Primer Nombre</label>
            <input v-model="form.first_name" class="w-full border rounded p-2" required />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Segundo Nombre</label>
            <input v-model="form.second_name" class="w-full border rounded p-2" />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Primer Apellido</label>
            <input v-model="form.first_surname" class="w-full border rounded p-2" required />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Segundo Apellido</label>
            <input v-model="form.second_surname" class="w-full border rounded p-2" />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Fecha Nacimiento</label>
            <input type="date" v-model="form.birthdate" class="w-full border rounded p-2" required />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Género</label>
            <el-select v-model="form.gender" class="w-full border rounded p-2" required>
              <el-option v-for="item in genders" :key="item.id" :label="item.name" :value="item.id" />
            </el-select>
          </div>
  
          <div>
            <label class="block text-sm font-medium">Teléfono</label>
            <input type="number" v-model="form.phone" class="w-full border rounded p-2" required />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Dirección</label>
            <input v-model="form.address" class="w-full border rounded p-2" />
          </div>
  
          <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" v-model="form.email" class="w-full border rounded p-2" />
          </div>
  
          <div class="flex justify-end space-x-2 mt-4">
            <int-button
              type="secondary"
              @click="$emit('close')"
            >
              Cancelar
            </int-button>
            <int-button type="primary" @click="savePatient">
              Guardar
            </int-button>
          </div>
        </form>
      </div>
    </div>
  </el-dialog>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { ElNotification } from "element-plus";

defineProps({
  show: { type: Boolean, default: false }
})

const emit = defineEmits(["close", "created"])

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

const identityTypes = ref([
  { id: 'DNI', name: "Cédula" },
  { id: 'PAS', name: "Pasaporte" },
  { id: 'CEX', name: "Cédula de extranjería" },
  { id: 'TI', name: "Tarjeta de identidad" },
  { id: 'OT', name: "Otro" },
])
const genders = ref([
  { id: 'M', name: "Masculino" },
  { id: 'F', name: "Femenino" },
  { id: 'O', name: "Otro" },
])

async function savePatient() {
  try {
    const { data } = await axios.post("/api/patients", form.value)
    emit("created", data) // devuelve el paciente al padre
    emit("close") // cierra modal
    // limpiar formulario
    Object.keys(form.value).forEach(key => form.value[key] = "")
  } catch (e) {
    console.error(e)
    ElNotification({
      title: 'Error',
      message: e.response?.data?.message || 'Error al crear el paciente',
      type: 'error'
    })
  }
}

const closeModal = () => {
  emit("close")
}

onMounted(() => {
  console.log('onMounted')
})
</script>
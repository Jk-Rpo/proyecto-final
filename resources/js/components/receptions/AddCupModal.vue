<template>
	<!-- Modal para agregar CUPS -->
	<el-dialog
		v-if="show"
		:model-value="show"
		:before-close="closeModal"
	>
		<div class="w-full flex flex-col justify-between items-center p-6">
			<h2 class="text-xl font-bold mb-4 w-full">Agregar CUPS</h2>
			<div class="w-full flex flex-row items-start py-6">
				<div class="form-check w-3/4 pr-2">
					<label class="block text-sm font-medium">CUPS</label>
					<el-select v-model="selectedCupId" class="w-full border rounded p-2" required>
						<el-option v-for="item in cups" :key="item.id" :label="item.code + ' - ' + item.description" :value="item.id" />
					</el-select>
				</div>
				<div class="form-check w-1/4 pl-2">
					<label class="block text-sm font-medium">Cantidad</label>
					<el-input class="form-check-input h-12" type="number" v-model="selectedCupQuantity"></el-input>
				</div>
			</div>
			<div class="flex flex-row justify-end items-end p-6 mx-auto">
				<int-button type="secondary" color="primary" @click="closeModal">
					Cancelar
				</int-button>
				<int-button @click="addCup()">
					Agregar
				</int-button>
			</div>
		</div>
	</el-dialog>
</template>

<script setup>
import { ref, computed, onMounted, watch, useSlots, defineProps, defineEmits } from 'vue'
import { ElNotification } from 'element-plus'

const props = defineProps({
  show: { default: false },
  cups: { default: null },
  type: { default: null },
  title: { default: null },
  icon: { default: 'fas fa-users' },
  modelValue: { type: Array, default: () => [] },
  maxlength: { type: Number, default: -1 },
})

const emit = defineEmits(['update:cups', 'update:modelValue', 'close'])
// ------------------------------------
// Internal reactive model
// ------------------------------------
const selectedItems = ref([...props.modelValue])
const selectedCupId = ref(null)
const selectedCupQuantity = ref(null)

watch(
  () => props.modelValue,
  (newVal) => {
	selectedItems.value = [...newVal]
  }
)

const addCup = () => {
  if (!selectedCupId.value || !selectedCupQuantity.value) {
    ElNotification({ title: 'Error', message: 'Debe seleccionar una CUPS y una cantidad', type: 'error' })
  }
  const cup = props.cups.find(c => c.id === selectedCupId.value)
  if (!cup) {
    ElNotification({ title: 'Error', message: 'CUPS no encontrada', type: 'error' })
    return
  }

  selectedItems.value.push({ 
	id: cup.id,
	quantity: selectedCupQuantity.value,
	name: cup.code + ' - ' + cup.description,
  })
  selectedCupId.value = null
  selectedCupQuantity.value = null

  emit('update:modelValue', selectedItems.value)
  emit('close')
}

const closeModal = () => {
  emit('close')
}

</script>

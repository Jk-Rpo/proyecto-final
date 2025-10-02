<template>
  <div class="flex flex-col items-center h-100 p-4">
    <h1 class="text-2xl font-bold mb-4 text-center">Crear Recepción</h1>
    <div class="grid gap-4">
      <int-button 
        href="/receptions/create/patient"
      >
        Ingresar Paciente
      </int-button>
      <int-button 
        href="/receptions/create/special"
      >
        Estudios Especiales
      </int-button>

      <int-button 
        href="/receptions"
        type="tertiary"
        color="primary"
      >
        Volver a Recepciones
      </int-button>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.container {
  max-width: 800px;
  margin-top: 20px;
}
</style>

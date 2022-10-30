<template>
  <q-banner
    v-if="props.event"
    class="bg-primary text-white"
  >
    <p class="text-body1">
      <span class="text-h6 text-weight-bold">{{ props.event.name }}</span> es el evento seleccionado para trabajar.
    </p>
    <template #action>
      <q-btn
        flat
        color="white"
        label="Seleccionar otro"
        :to="{ name: 'events selection' }"
      />
    </template>
  </q-banner>
</template>

<script setup>
const props = defineProps({
  event: {
    type: Object,
    required: false,
    default: () => null
  }
})
</script>

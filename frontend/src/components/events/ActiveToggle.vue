<template>
  <div class="q-my-lg">
    <q-toggle
      :model-value="props.modelValue"
      label="Evento activo"
      @update:model-value="handle"
    />
    <p class="text-caption">
      El evento activo es el que se mostrará a través de los códigos QR o en el menú.
    </p>
    <p class="text-caption">
      Solo puede existir un solo evento activo y al activar uno, se desactivan los otros eventos que se encuentren activos.
    </p>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true
  }
})

const emits = defineEmits(['update:modelValue'])

const handle = (x) => emits('update:modelValue', x)

</script>

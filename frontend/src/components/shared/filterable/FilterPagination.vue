<template>
  <div class="row justify-center">
    <q-pagination
      class="q-mt-md col-auto"
      :model-value="props.modelValue"
      :max="props.perPage"
      input
      @update:model-value="onInput"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Number,
    default: 1
  },

  perPage: {
    type: Number,
    default: 10
  }
})

const emits = defineEmits(['update:modelValue'])

function onInput (value) {
  emits('update:modelValue', value)
}
</script>

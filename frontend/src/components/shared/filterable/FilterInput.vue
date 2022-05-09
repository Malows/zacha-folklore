<template>
  <q-input
    class="q-my-md"
    :model-value="props.modelValue"
    type="search"
    outlined
    clearable
    @update:model-value="onInput"
  >
    <template #append>
      <q-icon name="search" />
    </template>
  </q-input>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  }
})

const emits = defineEmits(['update:modelValue', 'change'])

function onInput (value) {
  emits('update:modelValue', value)
  emits('change')
}
</script>

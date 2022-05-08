<template>
  <q-input
    class="q-my-md"
    :value="props.value"
    type="search"
    outlined
    clearable
    @input="onInput"
  >
    <template #append>
      <q-icon(name="search") />
    </template>
  </q-input>
</template>

<script setup>
const props = defineProps({
  value: {
    type: String,
    default: ''
  }
})

const emits = defineEmits(['input'])

function onInput (value) {
  emits('input', value)
}
</script>

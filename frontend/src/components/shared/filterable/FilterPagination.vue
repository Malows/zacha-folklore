<template>
  <div class="row justify-center">
    <q-pagination
      class="q-mt-md col-auto"
      :value="props.value"
      :max="props.perPage"
      input
      @input="onInput"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  value: {
    type: Number,
    default: 1
  },

  perPage: {
    type: Number,
    default: 10
  }
})

const emits = defineEmits(['input'])

function onInput (value) {
  emits('input', value)
}
</script>

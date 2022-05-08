<template>
  <p class="text-body1">
    <strong>{{ props.label }}: </strong>
    <slot />
  </p>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    required: true
  }
})
</script>

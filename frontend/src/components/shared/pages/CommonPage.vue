<template>
  <q-page padding>
    <h4>{{ props.title }}</h4>
    <slot />
  </q-page>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  }
})
</script>

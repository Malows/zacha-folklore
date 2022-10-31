<template>
  <q-fab-action
    external-label
    :label="props.label"
    label-position="left"
    :icon="props.icon"
    :color="props.color"
    :to="props.to"
    :disable="props.disable"
    @click="emits('click')"
  />
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    required: true
  },
  color: {
    type: String,
    default: 'primary'
  },
  to: {
    type: [String, Object],
    required: false,
    default: null
  },
  disable: {
    type: Boolean,
    default: false
  }
})

const emits = defineEmits(['click'])
</script>

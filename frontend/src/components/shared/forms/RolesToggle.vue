<template>
  <div class="container">
    <h6>Roles</h6>
    <div class="list-display">
      <q-toggle
        v-for="x in options"
        :key="x.value"
        :model-value="props.modelValue"
        :val="x.value"
        :label="x.label"
        @update:model-value="handleUpdate"
      />
    </div>
  </div>
</template>

<script setup>
import { roleLabel } from 'src/utils/text'

const props = defineProps({
  modelValue: {
    type: Array,
    required: true
  }
})

const emits = defineEmits(['update:modelValue'])

const options = [
  { value: 'admin', label: roleLabel('admin') },
  { value: 'manager', label: roleLabel('manager') },
  { value: 'ticket controller', label: roleLabel('ticket controller') }
]

function handleUpdate (newValue) {
  emits('update:modelValue', newValue)
}
</script>

<style scoped>
  .list-display {
    display: inline-flex;
    gap: 1.5rem;
  }
</style>

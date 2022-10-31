<template>
  <q-item
    clickable
    exact
    @click="handleClick"
  >
    <q-item-section>
      <q-item-label>
        {{ props.event.name }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
const props = defineProps({
  event: {
    type: Object,
    required: true
  }
})

const emits = defineEmits(['select'])

const handleClick = () => {
  emits('select', props.event)
}
</script>

<template>
  <q-page-sticky
    :position="position"
    :offset="offset"
  >
    <q-btn
      round
      :color="props.color"
      :size="props.size"
      :icon="props.icon"
      @click="emits('click')"
    />
  </q-page-sticky>
</template>

<script setup>
import { computed } from 'vue'
import { useQuasar } from 'quasar'

const quasar = useQuasar()

const props = defineProps({
  icon: {
    type: String,
    default: 'add'
  },

  size: {
    type: String,
    default: 'md'
  },

  color: {
    type: String,
    default: 'accent'
  }
})

const emits = defineEmits(['click'])

const position = computed(() =>
  quasar.platform.is.desktop
    ? 'top-right'
    : 'bottom-right'
)

const offset = computed(() =>
  quasar.platform.is.desktop
    ? [24, 24]
    : [24, 24]
)
</script>

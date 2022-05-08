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
      :to="props.to"
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

  to: {
    type: [String, Object],
    default: '/'
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

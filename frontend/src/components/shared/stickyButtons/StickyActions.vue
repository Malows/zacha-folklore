<template>
  <q-page-sticky
    :position="alignment.position"
    :offset="alignment.offset"
  >
    <q-fab
      :icon="alignment.icon"
      :direction="alignment.direction"
      :color="props.color"
    />

    <slot />
  </q-page-sticky>
</template>

<script setup>
import { computed } from 'vue'
import { useQuasar } from 'quasar'

const quasar = useQuasar()

const props = defineProps({
  color: {
    type: String,
    default: 'accent'
  }
})

const alignment = computed(() =>
  quasar.platform.is.desktop
    ? {
        position: 'top-right',
        direction: 'down',
        icon: 'keyboard_arrow_down',
        offset: [24, 24]
      }
    : {
        position: 'bottom-right',
        direction: 'up',
        icon: 'keyboard_arrow_up',
        offset: [24, 24]
      }
)
</script>

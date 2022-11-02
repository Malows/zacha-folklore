<template>
  <base-map
    :model-zoom="props.zoom"
    :model-center="props.center"
  >
    <l-marker
      v-if="props.modelValue"
      :lat-lng="[props.modelValue.lat, props.modelValue.lng]"
      draggable
      @move="updateMarker"
    />
  </base-map>
</template>

<script setup>
import { LMarker } from '@vue-leaflet/vue-leaflet'
import { onMounted } from 'vue'

import { DEFAULT_GEOPOSITION } from 'src/utils/geo'

import BaseMap from './BaseMap.vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: false,
    default: null
  },

  center: {
    type: Object,
    required: false,
    default: () => DEFAULT_GEOPOSITION
  },

  zoom: {
    type: Number,
    required: false,
    default: 15
  }
})

const emits = defineEmits(['update:modelValue'])

onMounted(() => {
  if (!props.modelValue) {
    updateMarker(DEFAULT_GEOPOSITION)
  }
})

function updateMarker (value) {
  emits('update:modelValue', value?.latlng ?? value)
}
</script>

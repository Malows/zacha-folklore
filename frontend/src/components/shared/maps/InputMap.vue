<template>
  <base-map
    v-model:zoom="props.zoom"
    v-model:center="props.center"
  >
    <l-marker
      v-if="props.marker"
      :lat-lng="[props.marker.lat, props.marker.lng]"
      draggable
      @move="updateMarker"
    />
  </base-map>
</template>

<script setup>
import { LMarker } from '@vue-leaflet/vue-leaflet'

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
    default: () => ({ lat: -31.633333, lng: -60.7000 })
  },

  zoom: {
    type: Number,
    required: false,
    default: 15
  }
})

const emits = defineEmits(['update:modelValue'])

function updateMarker (value) {
  console.log('value', value)
  emits('update:modelValue', value)
}
</script>

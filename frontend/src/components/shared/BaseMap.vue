<template>
  <l-map
    :zoom="props.zoom"
    :center="props.center"
  >
    <l-tile-layer
      url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      layer-type="base"
      name="OpenStreetMap"
    />
    <l-marker
      v-if="props.marker"
      :lat-lng="[props.marker.lat, props.marker.lng]"
    />
  </l-map>
</template>

<script setup>
import 'leaflet/dist/leaflet.css'
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'

const props = defineProps({
  marker: {
    type: Object,
    required: false,
    default: null
  },

  center: {
    type: Object,
    required: false,
    default: () => ({ lat: 1, lng: 2 })
  },

  zoom: {
    type: Number,
    required: false,
    default: 15
  }
})
</script>

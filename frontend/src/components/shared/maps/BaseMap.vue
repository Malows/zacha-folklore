<template>
  <q-card>
    <q-card-section>
      <l-map
        :zoom="props.zoom"
        :center="props.center"
        :style="{ height }"
        @update:zoom="updateZoom"
        @update:center="updateCenter"
      >
        <l-tile-layer
          url="https://tile.openstreetmap.org/{z}/{x}/{y}.png"
          layer-type="base"
          name="OpenStreetMap"
        />
        <slot></slot>
      </l-map>
    </q-card-section>
  </q-card>
</template>

<script setup>
import 'leaflet/dist/leaflet.css'
import { LMap, LTileLayer } from '@vue-leaflet/vue-leaflet'

const props = defineProps({
  modelCenter: {
    type: Object,
    required: false,
    default: () => ({ lat: -31.633333, lng: -60.7000 })
  },

  height: {
    type: String,
    default: '50vh'
  },

  modelZoom: {
    type: Number,
    required: false,
    default: 14
  }
})

const emits = defineEmits(['update:modelCenter', 'update:modelZoom'])

function updateCenter (center) {
  emits('update:modelCenter', center)
}

function updateZoom (zoom) {
  emits('update:modelZoom', zoom)
}
</script>

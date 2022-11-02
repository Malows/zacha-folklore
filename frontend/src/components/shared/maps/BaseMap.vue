<template>
  <q-card>
    <q-card-section>
      <l-map
        :zoom="props.modelZoom"
        :center="props.modelCenter"
        :style="{ height }"
        @update:zoom="updateZoom"
        @update:center="updateCenter"
      >
        <l-tile-layer
          url="https://tile.openstreetmap.org/{z}/{x}/{y}.png"
          layer-type="base"
          name="OpenStreetMap"
        />
        <slot />
      </l-map>
    </q-card-section>
  </q-card>
</template>

<script setup>
import 'leaflet/dist/leaflet.css'
import { LMap, LTileLayer } from '@vue-leaflet/vue-leaflet'

import { DEFAULT_GEOPOSITION } from 'src/utils/geo'

const props = defineProps({
  modelCenter: {
    type: Object,
    required: false,
    default: () => DEFAULT_GEOPOSITION
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

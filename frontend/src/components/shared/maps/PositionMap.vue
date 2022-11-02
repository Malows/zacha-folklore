<template>
  <base-map
    :modelCenter="props.marker"
    :modelZoom="15"
  >
    <l-marker
      v-if="props.marker"
      :lat-lng="[props.marker.lat, props.marker.lng]"
    />
  </base-map>
</template>

<script setup>
import { LMarker } from '@vue-leaflet/vue-leaflet'
import { onMounted, ref } from 'vue'

import BaseMap from './BaseMap.vue'

const props = defineProps({
  marker: {
    type: Object,
    required: true,
    default: null
  }
})

const center = ref({ lat: -31.633333, lng: -60.7000 })

onMounted(() => {
  center.value = props.marker ?? { lat: -31.633333, lng: -60.7000 }
})
</script>

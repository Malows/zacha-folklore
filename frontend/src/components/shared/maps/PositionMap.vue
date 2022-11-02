<template>
  <base-map
    :model-center="props.marker"
    :model-zoom="15"
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

import { DEFAULT_GEOPOSITION } from 'src/utils/geo'

import BaseMap from './BaseMap.vue'

const props = defineProps({
  marker: {
    type: Object,
    required: true,
    default: null
  }
})

const center = ref(DEFAULT_GEOPOSITION)

onMounted(() => {
  center.value = props.marker ?? DEFAULT_GEOPOSITION
})
</script>

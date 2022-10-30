<template>
  <q-banner
    v-show="isEmpty && show"
    class="bg-accent text-white q-my-md"
  >
    <p class="text-body1">
      Este evento no tiene elementos en su menú.
      ¿Desea copiar el menú de otro evento?
    </p>
    <template #action>
      <q-btn
        flat
        color="white"
        label="Si"
        :to="{ name: 'events selection' }"
      />
      <q-btn
        flat
        color="white"
        label="No"
        @click="show = false"
      />
    </template>
  </q-banner>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  sections: {
    type: Array,
    required: true
  }
})

const isEmpty = computed(() => Array.isArray(props.sections) && props.sections.length === 0)
const show = ref(true)
</script>

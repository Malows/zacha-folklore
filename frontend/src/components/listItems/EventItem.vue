<template>
  <q-item
    clickable
    :to="route"
    exact
  >
    <q-item-section>
      <q-item-label>
        {{ props.event.name }}
      </q-item-label>
    </q-item-section>

    <q-item-section avatar>
      <q-item-label>
        {{ toPlainString(props.event.eventDay) }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
import { computed } from 'vue'
import { toPlainString } from 'src/utils/date'

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
})

const route = computed(() => ({
  name: 'events show',
  params: {
    eventId: props.event.id
  }
}))
</script>

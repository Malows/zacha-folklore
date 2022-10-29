<template>
  <q-item
    clickable
    exact
    @click="handleClick"
  >
    <q-item-section>
      <q-item-label>
        {{ props.event.label }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
import { computed } from 'vue'
import environment from 'src/composable/environment'

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

const { store, router } = environment()

const handleClick = () => {
  store.dispatch('events/selectEvent', props.event.value)
  router.push({ name: 'home' })
}
</script>

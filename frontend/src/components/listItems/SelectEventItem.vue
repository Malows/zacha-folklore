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
import environment from 'src/composable/environment'

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
})

const { store, router, quasar } = environment()

const handleClick = () => {
  store.dispatch('events/selectEvent', props.event.value)
  quasar.notify('Evento seleccionado')
  router.push({ name: 'home' })
}
</script>

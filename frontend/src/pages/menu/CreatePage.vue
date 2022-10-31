<template>
  <common-page title="Crear Sección de Menú">
    <display-selected-event :event="event" />
    <q-form>
      <q-input
        v-model="name"
        label="Nombre"
      />
      <q-input
        v-model.number="order"
        type="number"
        label="Orden de posicion"
      />

      <q-btn
        class="q-mt-md"
        color="primary"
        label="Enviar"
        @click="submit"
      />
    </q-form>
  </common-page>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

import environment from 'src/composable/environment'
import { checkEvent } from 'src/composable/checkRequirement'
import { pull, task } from 'src/utils/api'

import CommonPage from 'src/components/shared/pages/CommonPage.vue'
import DisplaySelectedEvent from 'src/components/banners/DisplaySelectedEvent.vue'

const { router, store, quasar } = environment()

const name = ref('')
const order = ref(1)

const sections = computed(() => store.state.menuSections.menuSections)
const event = computed(() => store.state.events.selectedEvent)

const payload = computed(() => ({
  name: name.value,
  order: order.value,
  eventId: event.value?.id
}))

onMounted(async () => {
  const eventId = checkEvent(store, router, quasar)

  let sample = sections?.value ?? []

  if (sample.length === 0) {
    sample = await pull(store, quasar, 'menuSections/fetch', { eventId })
    sample = sample.data
  }

  order.value = sample.length + 1
})

function submit () {
  // validation
  task(store, quasar, 'menuSections/create', payload.value)
    .then(() => {
      quasar.notify('Sección de Menú creada correctamente')
      router.push({ name: 'menu index' })
    })
}
</script>

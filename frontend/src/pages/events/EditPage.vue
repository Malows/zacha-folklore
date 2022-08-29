<template>
  <page
    v-if="reservation"
    title="Editar Evento"
  >
    <q-form>
      <q-input
        v-model="payload.name"
        label="Nombre"
      />

      <q-input
        v-model="payload.eventDay"
        label="Dia del evento"
      />

      <q-input
        v-model="payload.startedAt"
        label="Hora de inicio"
      />

      <q-toggle
        v-model="payload.isActive"
        label="Evento activo"
      />

      <q-input
        v-model="payload.address"
        label="Direccion"
      />

      <q-input
        v-model="payload.location"
        label="Mapa"
      />

      <q-btn
        class="q-mt-md"
        color="primary"
        label="Enviar"
        @click="submit"
      />
    </q-form>
  </page>
</template>

<script setup>
import { reactive, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { pull, task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const payload = reactive({
  name: '',
  eventDay: null,
  startedAt: null,
  isActive: false,
  address: '',
  location: null
})

const { route, router, store, quasar } = environment()

const reservation = computed(() => store.getters['events/event'])

onMounted(async () => {
  await pull(store, quasar, 'events/get', { id: route.params.eventId })

  if (reservation.value) {
    payload.name.value = event.value.name
    payload.eventDay.value = event.value.eventDay
    payload.startedAt.value = event.value.startedAt
    payload.isActive.value = event.value.isActive
    payload.address.value = event.value.address
    payload.location.value = event.value.location
  }
})

function submit () {
  // validation
  task(store, quasar, 'events/update', payload.value)
    .then(() => {
      quasar.notify('Evento editado correctamente')
      router.push({ name: 'events index' })
    })
}
</script>

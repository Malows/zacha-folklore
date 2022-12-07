<template>
  <common-page
    v-if="event"
    title="Editar Evento"
  >
    <q-form>
      <q-input
        v-model="payload.name"
        label="Nombre"
      />

      <calendar-input
        v-model="payload.eventDay"
        label="Día del evento"
      />

      <q-input
        v-model="payload.address"
        label="Dirección"
      />

      <input-map
        v-model="payload.location"
        class="q-mt-lg"
      />

      <active-toggle v-model="payload.isActive" />

      <q-separator class="q-my-lg" />

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
import { reactive, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkManagerRole } from 'src/composable/checkRole'
import { pull, task } from 'src/utils/api'

import CommonPage from 'src/components/shared/pages/CommonPage.vue'
import InputMap from 'components/shared/maps/InputMap.vue'
import ActiveToggle from 'src/components/events/ActiveToggle.vue'
import CalendarInput from 'src/components/events/CalendarInput.vue'

const payload = reactive({
  name: '',
  eventDay: null,
  // startedAt: null,
  isActive: false,
  address: '',
  location: null
})

const { route, router, store, quasar } = environment()

const event = computed(() => store.getters['events/event'])

onMounted(async () => {
  checkManagerRole(store, router, quasar)

  await pull(store, quasar, 'events/get', { id: route.params.eventId })

  if (event.value) {
    payload.name = event.value.name
    payload.eventDay = event.value.eventDay
    payload.startedAt = event.value.startedAt
    payload.isActive = event.value.isActive
    payload.address = event.value.address
    payload.location = event.value.location
  }
})

function submit () {
  // validation
  task(store, quasar, 'events/update', { ...event.value, ...payload })
    .then(() => {
      quasar.notify('Evento editado correctamente')
      router.push({ name: 'events index' })
    })
}
</script>

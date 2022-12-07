<template>
  <common-page title="Crear Evento">
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
import { reactive, onMounted } from 'vue'
// import useVuelidate from '@vuelidate/core'
// import { required, email, minValue } from '@vuelidate/validators'

import environment from 'src/composable/environment'
import { checkManagerRole } from 'src/composable/checkRole'
import { task } from 'src/utils/api'

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

const { router, store, quasar } = environment()

onMounted(() => {
  checkManagerRole(store, router, quasar)
})

// const $v = useVuelidate(rules, payload)

function submit () {
  task(store, quasar, 'events/create', payload)
    .then(() => {
      quasar.notify('Evento creado correctamente')
      router.push({ name: 'events index' })
    })
}
</script>

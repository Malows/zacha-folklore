<template>
  <page title="Crear Evento">
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
import { reactive } from 'vue'
// import useVuelidate from '@vuelidate/core'
// import { required, email, minValue } from '@vuelidate/validators'

import environment from 'src/composable/environment'
import { task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const payload = reactive({
  name: '',
  eventDay: null,
  startedAt: null,
  isActive: false,
  address: '',
  location: null
})

const { router, store, quasar } = environment()

// const $v = useVuelidate(rules, payload)

function submit () {
  task(store, quasar, 'events/create', payload)
    .then(() => {
      quasar.notify('Evento creado correctamente')
      router.push({ name: 'events index' })
    })
}
</script>

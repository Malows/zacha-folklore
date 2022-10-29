<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Seleccionar evento
      </div>
    </q-card-section>

    <q-card-section>
      <p>¿Quiere seleccionar este evento para trabajar con el?</p>
      <p>{{ props.event.name }}</p>
      <p>Fecha: {{ toPlainString(props.event.eventDay) }}</p>
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
        v-close-popup
        color="primary"
        label="Seleccionar"
        @click="submit"
        />
        <q-btn
        flat
        color="primary"
        label="Cancelar"
      />
    </q-card-actions>
  </q-card>
</template>

<script setup>
import environment from 'src/composable/environment.js'
import { toPlainString } from 'src/utils/date'

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
})

const { store, quasar } = environment()

function submit () {
  store.dispatch('events/selectEvent', props.event.id)
  quasar.notify('Evento seleccionado')
}
</script>

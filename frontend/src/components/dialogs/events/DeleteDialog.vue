<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Eliminar evento
      </div>
    </q-card-section>

    <q-card-section>
      <p>¿Estás seguro de que quieres eliminar este evento?</p>
      <p>{{ props.event.name }}</p>
      <p>Fecha: {{ toPlainString(props.event.eventDay) }}</p>
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
        color="negative"
        label="Eliminar"
        @click="submit"
      />
      <q-btn
        v-close-popup
        flat
        color="primary"
        label="Cancelar"
      />
    </q-card-actions>
  </q-card>
</template>

<script setup>
import environment from 'src/composable/environment.js'
import { task } from 'src/utils/api'
import { toPlainString } from 'src/utils/date'

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
})

const { router, store, quasar } = environment()

function submit () {
  task(store, quasar, 'events/remove', { id: props.event.id })
    .then(() => {
      quasar.notify('Evento eliminado correctamente')
      router.push({ name: 'events index' })
    })
}
</script>

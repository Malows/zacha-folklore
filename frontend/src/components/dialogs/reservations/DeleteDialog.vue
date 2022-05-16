<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Eliminar reserva
      </div>
    </q-card-section>

    <q-card-section>
      <p>¿Estás seguro de que quieres eliminar esta reserva?</p>
      <p>{{ props.reservation.last_name }}, {{ props.reservation.name }}</p>
      <p>Cantidad: {{ props.reservation.amount }}</p>
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

const props = defineProps({
  reservation: {
    type: Object,
    required: true
  }
})

const { router, store, quasar } = environment()

function submit () {
  task(store, quasar, 'reservations/remove', { id: props.reservation.id })
    .then(() => {
      quasar.notify('Reserva eliminada correctamente')
      router.push({ name: 'reservations index' })
    })
}
</script>

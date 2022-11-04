<template>
  <q-card class="dialog">
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Edición rápida
      </div>
    </q-card-section>

    <q-card-section>
      <p>{{ props.reservation.lastName }}, {{ props.reservation.name }}</p>
      <p>Cantidad: {{ props.reservation.amount }}</p>
    </q-card-section>

    <q-card-section>
      <p>¿Está paga?</p>
      <q-toggle v-model="isPaid" />
    </q-card-section>

    <q-card-section>
      <p>¿Fue utilizada?</p>
      <q-toggle v-model="isUsed" />
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
        v-close-popup
        color="primary"
        label="Enviar"
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
import { ref, onMounted } from 'vue'
import environment from 'src/composable/environment.js'
import { task } from 'src/utils/api'

const props = defineProps({
  reservation: {
    type: Object,
    required: true
  }
})

const { store, quasar } = environment()

const isPaid = ref(false)
const isUsed = ref(false)

onMounted(() => {
  isPaid.value = props.reservation.isPaid
  isUsed.value = props.reservation.isUsed
})

function submit () {
  task(store, quasar, 'reservations/update', {
    ...props.reservation,
    isPaid: isPaid.value,
    isUsed: isUsed.value
  })
    .then(() => {
      quasar.notify('Reserva actualizada')
    })
}
</script>

<style scoped>
  .dialog {
    width: clamp(80vw, 100%, 16rem);
  }
</style>

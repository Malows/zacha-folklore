<template>
  <common-page
    v-if="reservation"
    title="Edición rápida"
  >
    <q-form>
      <inline-data label="Nombre">
        {{ reservation.lastName }}, {{ reservation.name }}
      </inline-data>

      <inline-data label="Cantidad">
        {{ reservation.amount }}
      </inline-data>

      <q-separator class="q-my-lg" />

      <div>
        <q-toggle
          v-model="isPaid"
          label="¿Está paga?"
        />
      </div>

      <div>
        <q-toggle
          v-model="isUsed"
          label="¿Fue utilizada?"
        />
      </div>

      <q-separator class="q-my-lg" />

      <q-btn
        class="q-mt-md full-width"
        color="primary"
        label="Enviar"
        @click="submit"
      />
    </q-form>
  </common-page>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkTicketRole } from 'src/composable/checkRole'
import { pull, task } from 'src/utils/api'

import CommonPage from 'src/components/shared/pages/CommonPage.vue'
import InlineData from 'components/shared/InlineData.vue'

const { store, quasar, route, router } = environment()

const isPaid = ref(true)
const isUsed = ref(true)

const reservation = computed(() => store.getters['reservations/reservation'])

const payload = computed(() => ({
  ...reservation.value,
  isPaid: isPaid.value,
  isUsed: isUsed.value
}))

onMounted(async () => {
  checkTicketRole(store, router, quasar)

  if (!reservation.value) {
    await pull(store, quasar, 'reservations/get', route.params.reservationId)
  }

  isPaid.value = reservation.value.isPaid
  isUsed.value = reservation.value.isUsed
})

function submit () {
  task(store, quasar, 'reservations/update', payload.value)
    .then(() => {
      quasar.notify('Reserva editada correctamente')
      router.push({ name: 'home' })
    })
}

</script>

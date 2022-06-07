<template>
  <q-page
    v-if="reservation"
    padding
  >
    <div class="flex justify-center">
      <img
        src="/icons/icon-128x128.png"
        alt="logo del evento"
      >
    </div>

    <h4 class="text-center">
      Nos vemos pronto
    </h4>
    <h5 class="text-center">
      {{ eventDay }}
    </h5>

    <p class="text-body1">
      {{ reservation.name }} {{ reservation.lastName }}
    </p>
    <p class="text-body1">
      Cantidad de personas: {{ reservation.amount }}
    </p>
    <!-- <p>Datos de contacto: {{ contact }}</p> -->

    <p class="text-center text-body1 fixed-bottom">
      Cualquier duda, no dudes en contactarnos <a :href="reservationURL">{{ reservationPhone }}</a>
    </p>
  </q-page>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import { checkLocalAuth } from 'src/boot/routeGuardian'
import environment from 'src/composable/environment'
import { pull } from 'src/utils/api'
import { toPlainString } from 'src/utils/date'

const { store, quasar, route, router } = environment()

const reservation = computed(() => store.state.reservations.reservations.find(x => x.uuid === route.params.uuid))
const eventDay = computed(() => toPlainString(reservation.value?.event?.eventDay))
/* const contact = computed(() => {
  const { email, phone } = reservation?.value ?? {}

  if (email && phone) return `email: ${email} - teléfono: ${phone}`
  if (email) return `email: ${email}`
  if (phone) return `teléfono: ${phone}`

  return '-'
}) */

const reservationPhone = process.env.RESERVATION_PHONE
const reservationURL = process.env.RESERVATION_URL
onMounted(async () => {
  const response = await pull(store, quasar, 'reservations/get', route.params.uuid)

  if (checkLocalAuth(process.env.STORAGE_PREFIX)) {
    router.push({ name: 'reservations quick', params: { reservationId: response.data.id } })
  }
})
</script>

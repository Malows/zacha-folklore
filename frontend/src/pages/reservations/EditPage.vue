<template>
  <page
    v-if="reservation"
    title="Editar Reserva"
  >
    <q-form>
      <q-input
        v-model="name"
        label="Nombre"
        :rules="[x => x || 'El nombre es obligatorio']"
      />
      <q-input
        v-model="lastName"
        label="Apellido"
        :rules="[x => x || 'El apellido es obligatorio']"
      />
      <q-input
        v-model.number="amount"
        type="number"
        label="Cantidad"
        :rules="[x => x > 0 || 'La cantidad debe ser mayor que 0']"
      />
      <q-input
        v-model="email"
        label="Email"
      />
      <q-input
        v-model="phone"
        label="Telefono"
      />
      <div class="q-mt-md">
        <q-toggle
          v-model="paid"
          label="Pagado"
        />
        <q-toggle
          v-model="used"
          label="Ya usado"
        />
      </div>
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
import { ref, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { pull, task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const name = ref('')
const lastName = ref('')
const amount = ref(1)
const email = ref('')
const phone = ref('')
const paid = ref(true)
const used = ref(true)

const { route, router, store, quasar } = environment()

const reservation = computed(() => store.getters['reservations/reservation'])

const payload = computed(() => ({
  ...reservation.value,
  name: name.value,
  lastName: lastName.value,
  amount: amount.value ?? 0,
  email: email.value,
  phone: email.value,
  isPaid: paid.value,
  isUsed: used.value
}))

onMounted(async () => {
  await pull(store, quasar, 'reservations/get', { id: route.params.reservationId })

  if (reservation.value) {
    name.value = reservation.value.name
    lastName.value = reservation.value.lastName
    amount.value = reservation.value.amount
    email.value = reservation.value.email
    phone.value = reservation.value.phone
    paid.value = reservation.value.isPaid
    used.value = reservation.value.isUsed
  }
})

function submit () {
  // validation
  task(store, quasar, 'reservations/update', payload.value)
    .then(() => {
      quasar.notify('Reserva editada correctamente')
      router.push({ name: 'reservations index' })
    })
}
</script>

<template>
  <page title="Crear Reserva">
    <q-form>
      <q-input
        v-model="name"
        label="Nombre"
      />
      <q-input
        v-model="lastName"
        label="Apellido"
      />
      <q-input
        v-model.number="amount"
        type="number"
        label="Cantidad"
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
import { ref, computed } from 'vue'

import environment from 'src/composable/environment'
import { task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const name = ref('')
const lastName = ref('')
const amount = ref(1)
const email = ref('')
const phone = ref('')
const paid = ref(true)
const used = ref(false)

const { router, store, quasar } = environment()

const payload = computed(() => ({
  name: name.value,
  lastName: lastName.value,
  amount: amount.value,
  email: email.value,
  phone: email.value,
  isPaid: paid.value,
  isUsed: used.value
}))

function submit () {
  // validation
  task(store, quasar, 'reservations/create', payload.value)
    .then(() => {
      quasar.notify('Reserva creada correctamente')
      router.push({ name: 'reservations index' })
    })
}
</script>

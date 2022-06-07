<template>
  <page title="Crear Reserva">
    <q-form>
      <q-input
        v-model="payload.name"
        label="Nombre"
        :rules="[x => x.length > 0 || 'El nombre es obligatorio']"
      />
      <q-input
        v-model="payload.lastName"
        label="Apellido"
        :rules="[x => x.length > 0 || 'El apellido es obligatorio']"
      />
      <q-input
        v-model.number="payload.amount"
        type="number"
        label="Cantidad"
        :rules="[x => x > 0 || 'La cantidad debe ser mayor que 0']"
      />
      <q-input
        v-model="payload.email"
        label="Email"
      />
      <q-input
        v-model="payload.phone"
        label="Teléfono"
      />

      <div class="q-mt-md">
        <q-toggle
          v-model="payload.paid"
          label="Pagado"
        />

        <q-toggle
          v-model="payload.used"
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
import { reactive } from 'vue'
// import useVuelidate from '@vuelidate/core'
// import { required, email, minValue } from '@vuelidate/validators'

import environment from 'src/composable/environment'
import { task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const payload = reactive({
  name: '',
  lastName: '',
  amount: 0,
  email: '',
  phone: '',
  paid: false,
  used: false
})

/*
const rules = {
  name: { required },
  lastName: { required },
  amount: { required, minValue: minValue(1) },
  email: { email }
}
*/

const { router, store, quasar } = environment()

// const $v = useVuelidate(rules, payload)

function submit () {
  task(store, quasar, 'reservations/create', payload)
    .then(() => {
      quasar.notify('Reserva creada correctamente')
      router.push({ name: 'reservations index' })
    })
}
</script>

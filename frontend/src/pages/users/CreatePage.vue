<template>
  <page title="Crear Usuario">
    <q-form>
      <q-input
        v-model="name"
        label="Nombre"
      />
      <q-input
        v-model="email"
        label="Email"
      />
      <q-password
        v-model="password"
        label="Contraseña"
      />
      <q-password
        v-model="passwordConfirmation"
        label="Confirmar Contraseña"
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
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'

import { task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'
import QPassword from 'components/QPassword.vue'

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')

const quasar = useQuasar()
const store = useStore()
const router = useRouter()

const payload = computed(() => ({
  name: name.value,
  email: email.value,
  password: password.value,
  passwordConfirmation: passwordConfirmation.value
}))

function submit () {
  // validation
  task(store, quasar, 'users/create', payload.value)
    .then(() => {
      quasar.notify('Usuario creado correctamente')
      router.push({ name: 'users index' })
    })
}
</script>

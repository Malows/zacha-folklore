<template>
  <common-page title="Crear Usuario">
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

      <roles-toggle v-model="roles" />

      <q-btn
        class="q-mt-md"
        color="primary"
        label="Enviar"
        @click="submit"
      />
    </q-form>
  </common-page>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

import environment from 'src/composable/environment'
import { checkAdminRole } from 'src/composable/checkRole'
import { task } from 'src/utils/api'

import CommonPage from 'src/components/shared/pages/CommonPage.vue'
import QPassword from 'components/QPassword.vue'
import RolesToggle from 'src/components/shared/forms/RolesToggle.vue'

const name = ref('')
const email = ref('')
const roles = ref([])
const password = ref('')
const passwordConfirmation = ref('')

const { store, router, quasar } = environment()

onMounted(() => {
  checkAdminRole(store, router, quasar)
})

const payload = computed(() => ({
  name: name.value,
  email: email.value,
  password: password.value,
  passwordConfirmation: passwordConfirmation.value,
  roles: roles.value
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

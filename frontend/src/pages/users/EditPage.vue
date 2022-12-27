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
import { ref, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkAdminRole } from 'src/composable/checkRole'
import { pull, task } from 'src/utils/api'

import CommonPage from 'src/components/shared/pages/CommonPage.vue'
import RolesToggle from 'src/components/shared/forms/RolesToggle.vue'

const name = ref('')
const email = ref('')
const roles = ref([])

const { route, router, store, quasar } = environment()

const user = computed(() => store.getters['users/user'])

onMounted(async () => {
  checkAdminRole(store, router, quasar)

  await pull(store, quasar, 'users/get', { id: route.params.userId })

  if (user.value) {
    name.value = user.value.name
    email.value = user.value.email
    roles.value = user.value.roles
  }
})

function submit () {
  // validation
  task(store, quasar, 'users/update', {
    ...user.value,
    name: name.value,
    email: email.value
  })
    .then(() => {
      quasar.notify('Usuario editado correctamente')
      router.push({ name: 'users index' })
    })
}
</script>

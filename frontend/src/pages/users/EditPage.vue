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
const email = ref('')

const { route, router, store, quasar } = environment()

const user = computed(() => store.getters['users/user'])

onMounted(async () => {
  await pull(store, quasar, 'users/get', { id: route.params.userId })

  if (user.value) {
    name.value = user.value.name
    email.value = user.value.email
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

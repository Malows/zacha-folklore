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
        color="primary"
        label="Enviar"
        @click="submit"
      />
    </q-form>
  </page>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'

import { pull, task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const name = ref('')
const email = ref('')

const quasar = useQuasar()
const store = useStore()
const router = useRouter()

const user = computed(() => store.getters['users/user'])

onMounted(async () => {
  await pull(store, quasar, 'users/get', router.params.userId)

  if (user.value) {
    name.value = user.value.name
    email.value = user.value.email
  }
})

function submit () {
  // validation
  task(store, quasar, 'users/create', {
    name: name.value,
    email: email.value
  })
    .then(() => {
      quasar.notify('Usuario editado correctamente')
      router.push({ name: 'users index' })
    })
}
</script>

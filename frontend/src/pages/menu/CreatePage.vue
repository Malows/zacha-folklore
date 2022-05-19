<template>
  <page title="Crear Seccion de Menu">
    <q-form>
      <q-input
        v-model="name"
        label="Nombre"
      />
      <q-input
        v-model.number="order"
        type="number"
        label="Orden de posicion"
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
import { ref, computed, onMounted } from 'vue'

import environment from 'src/composable/environment'
import { pull, task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const { router, store, quasar } = environment()

const name = ref('')
const order = ref(1)

const sections = computed(() => store.state.menuSections.menuSections)

const payload = computed(() => ({
  name: name.value,
  order: order.value
}))

onMounted(async () => {
  let sample = sections.value

  if (sample?.length === 0) {
    sample = await pull(store, quasar, 'menuSections/fetch')
    sample = sample.data
  }

  order.value = sample.length + 1
})

function submit () {
  // validation
  task(store, quasar, 'menuSections/create', payload.value)
    .then(() => {
      quasar.notify('Seccion de Menu creada correctamente')
      router.push({ name: 'menu index' })
    })
}
</script>

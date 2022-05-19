<template>
  <page
    v-if="menuSection"
    title="Editar Seccion de menu"
  >
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
import { ref, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { pull, task } from 'src/utils/api'

import Page from 'components/shared/pages/Page.vue'

const { route, router, store, quasar } = environment()

const name = ref('')
const order = ref(1)

const menuSection = computed(() => store.getters['menuSections/menuSection'])

const payload = computed(() => ({
  ...menuSection,
  name: name.value,
  order: order.value
}))

onMounted(async () => {
  await pull(store, quasar, 'menuSections/get', { id: route.params.menuId })

  if (menuSection.value) {
    name.value = menuSection.value.name
    order.value = menuSection.value.order
  }
})

function submit () {
  // validation
  task(store, quasar, 'menuSections/update', payload.value)
    .then(() => {
      quasar.notify('Seccion de menu editada correctamente')
      router.push({ name: 'menu index' })
    })
}
</script>

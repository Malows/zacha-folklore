<template>
  <common-page
    v-if="menuSection"
    title="Editar Sección de Menú"
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
  </common-page>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkManagerRole } from 'src/composable/checkRole'
import { pull, task } from 'src/utils/api'

import CommonPage from 'src/components/shared/pages/CommonPage.vue'

const { route, router, store, quasar } = environment()

const name = ref('')
const order = ref(1)

const menuSection = computed(() => store.getters['menuSections/menuSection'])

const payload = computed(() => ({
  ...menuSection.value,
  name: name.value,
  order: order.value
}))

onMounted(async () => {
  checkManagerRole(store, router, quasar)

  await pull(store, quasar, 'menuSections/get', { id: route.params.menuSectionId })

  if (menuSection.value) {
    name.value = menuSection.value.name
    order.value = menuSection.value.order
  }
})

function submit () {
  // validation
  task(store, quasar, 'menuSections/update', payload.value)
    .then(() => {
      quasar.notify('Sección de menú editada correctamente')
      router.push({ name: 'menu index' })
    })
}
</script>

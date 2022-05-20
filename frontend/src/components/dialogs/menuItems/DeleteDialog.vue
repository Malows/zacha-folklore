<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Eliminar reserva
      </div>
    </q-card-section>

    <q-card-section>
      <p>¿Estás seguro de que quieres eliminar esta reserva ({{ props.item.name }})?</p>
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
        v-close-popup
        color="negative"
        label="Eliminar"
        @click="submit"
      />
      <q-btn
        v-close-popup
        flat
        color="primary"
        label="Cancelar"
      />
    </q-card-actions>
  </q-card>
</template>

<script setup>
import environment from 'src/composable/environment.js'
import { pull, task } from 'src/utils/api'

const props = defineProps({
  item: {
    type: Object,
    required: true
  }
})

const { store, quasar } = environment()

function submit () {
  task(store, quasar, 'menuItems/remove', { id: props.item.id })
    .then(() => pull(store, quasar, 'menuSections/get', { id: props.item.menuSectionId }))
    .then(() => {
      quasar.notify('Item de menú eliminado correctamente')
    })
}
</script>

<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Eliminar reserva
      </div>
    </q-card-section>

    <q-card-section>
      <p>¿Estás seguro de que quieres eliminar esta reserva ({{ props.section.name }})?</p>
      <p v-show="props.section.items.length > 0">
        Cantidad de items: {{ props.section.items.length }}
      </p>
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
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
import { task } from 'src/utils/api'

const props = defineProps({
  section: {
    type: Object,
    required: true
  }
})

const { router, store, quasar } = environment()

function submit () {
  task(store, quasar, 'menuSections/remove', { id: props.section.id })
    .then(() => {
      quasar.notify('Sección de menú eliminada correctamente')
      router.push({ name: 'menu index' })
    })
}
</script>

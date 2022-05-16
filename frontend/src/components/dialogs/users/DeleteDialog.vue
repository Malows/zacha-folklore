<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Eliminar usuario
      </div>
    </q-card-section>

    <q-card-section>
      <p>
        ¿Estás seguro de que quieres eliminar este usuario ({{ props.user.name }})?
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
  user: {
    type: Object,
    required: true
  }
})

const { store, quasar } = environment()

function submit () {
  task(store, quasar, 'users/remove', { id: props.user.id })
}
</script>

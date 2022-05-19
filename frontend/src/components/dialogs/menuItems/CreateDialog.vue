<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Crear item de menu
      </div>
    </q-card-section>

    <q-card-section>
      <q-form>
        <q-input
          v-model="name"
          label="Nombre"
        />
        <q-input
          v-model.number="price"
          label="Precio"
        />
      </q-form>
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
        v-close-popup
        color="primary"
        label="Enviar"
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
import { ref, computed } from 'vue'
import environment from 'src/composable/environment.js'
import { pull, task } from 'src/utils/api'

const props = defineProps({
  section: {
    type: Object,
    required: true
  }
})

const { store, quasar } = environment()

const name = ref('')
const price = ref(0)

const payload = computed(() => ({
  name: name.value,
  price: price.value,
  menuSectionId: props.section.id
}))

function submit () {
  task(store, quasar, 'menuItems/create', payload.value)
    .then(() => pull(store, quasar, 'menuSections/get', { id: props.section.id }))
    .then(() => {
      quasar.notify('Item de menu creado correctamente')
    })
}
</script>

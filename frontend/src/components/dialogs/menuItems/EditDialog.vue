<template>
  <q-card class="min-width-dialog">
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Editar Item de Menú
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
          type="number"
          label="Precio"
        >
          <template #prepend>
            <q-icon name="attach_money" />
          </template>
        </q-input>
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
import { ref, computed, onMounted } from 'vue'
import environment from 'src/composable/environment.js'
import { pull, task } from 'src/utils/api'

const props = defineProps({
  item: {
    type: Object,
    required: true
  },

  section: {
    type: Object,
    required: true
  }
})

const { store, quasar } = environment()

const name = ref('')
const price = ref(0)

const payload = computed(() => ({
  ...props.item,
  name: name.value,
  price: price.value,
  menuSectionId: props.section.id
}))

onMounted(() => {
  name.value = props.item.name
  price.value = props.item.price
})

function submit () {
  task(store, quasar, 'menuItems/update', payload.value)
    .then(() => pull(store, quasar, 'menuSections/get', { id: props.section.id }))
    .then(() => {
      quasar.notify('Item de menú editado correctamente')
    })
}
</script>

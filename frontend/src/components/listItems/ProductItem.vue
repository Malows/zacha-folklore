<template>
  <q-item>
    <q-item-section>
      <q-item-label>
        {{ props.item.name }}
      </q-item-label>
    </q-item-section>

    <q-item-section>
      <q-item-label>
        $ {{ props.item.price }}
      </q-item-label>
    </q-item-section>

    <q-item-section avatar>
      <div class="flex">
        <q-btn
          round
          color="primary"
          icon="edit"
          @click="showModalEdit"
        />
        <q-btn
          class="q-ml-sm"
          round
          color="negative"
          icon="delete"
          @click="showModalDelete"
        />
      </div>
    </q-item-section>
  </q-item>
</template>

<script setup>
import { useStore } from 'vuex'

const props = defineProps({
  item: {
    type: Object,
    required: true
  }
})

const store = useStore()

function showModalEdit () {
  store.dispatch('menuItems/showEditModal', props.item)
}

function showModalDelete () {
  store.dispatch('menuItems/showDeleteModal', props.item)
}
</script>

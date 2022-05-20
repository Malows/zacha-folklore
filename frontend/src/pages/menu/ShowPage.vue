<template>
  <page-with-actions
    v-if="menuSection"
    title="Ver Sección de Menú"
  >
    <template #actions>
      <action
        label="Editar"
        icon="edit"
        :to="editRoute"
      />
      <action
        label="Eliminar"
        icon="delete"
        color="negative"
        @click="showModalDelete"
      />
    </template>

    <inline-data label="Nombre">
      {{ menuSection.name }}
    </inline-data>

    <inline-data label="Orden">
      {{ menuSection.order }}
    </inline-data>

    <q-separator />

    <template v-if="menuSection.items.length">
      <h4>Items</h4>
      <q-list>
        <product-item
          v-for="item in menuSection.items"
          :key="item.id"
          :item="item"
        />
      </q-list>
    </template>

    <q-btn
      class="q-mt-md"
      color="primary"
      label="Agregar Item"
      @click="showModalAddItem"
    />

    <q-dialog v-model="modalDelete">
      <delete-dialog :section="menuSection" />
    </q-dialog>

    <q-dialog v-model="modalAddItem">
      <create-item-dialog :section="menuSection" />
    </q-dialog>

    <q-dialog
      :model-value="modalEditItem"
      @update:model-value="cleanModal"
    >
      <edit-item-dialog
        :item="modalItem"
        :section="menuSection"
      />
    </q-dialog>
    <q-dialog
      :model-value="modalDeleteItem"
      @update:model-value="cleanModal"
    >
      <delete-item-dialog :item="modalItem" />
    </q-dialog>
  </page-with-actions>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import modalFactory from 'src/composable/modalFactory'
import environment from 'src/composable/environment'
import { pull } from 'src/utils/api'

import PageWithActions from 'components/shared/pages/PageWithActions.vue'
import Action from 'components/shared/stickyButtons/Action.vue'
import InlineData from 'components/shared/InlineData.vue'
import DeleteDialog from 'components/dialogs/menuSections/DeleteDialog.vue'

// items
import ProductItem from 'components/listItems/ProductItem.vue'
import CreateItemDialog from 'components/dialogs/menuItems/CreateDialog.vue'
import EditItemDialog from 'components/dialogs/menuItems/EditDialog.vue'
import DeleteItemDialog from 'components/dialogs/menuItems/DeleteDialog.vue'

const { store, quasar, route } = environment()

const menuSection = computed(() => store.getters['menuSections/menuSection'])

const [modalDelete, showModalDelete] = modalFactory()

const editRoute = computed(() => ({
  name: 'menu edit',
  params: { menuSectionId: menuSection.value?.id ?? '' }
}))

onMounted(async () => {
  if (!menuSection.value) {
    await pull(store, quasar, 'menuSections/get', { id: Number(route.params.menuSectionId) })
  }
})

// items
const [modalAddItem, showModalAddItem] = modalFactory()

const modalItem = computed(() => store.state.menuItems.selectedItem)
const modalAction = computed(() => store.state.menuItems.action)

const modalEditItem = computed(() => modalItem.value && modalAction.value === 'edit')
const modalDeleteItem = computed(() => modalItem.value && modalAction.value === 'delete')

function cleanModal () {
  store.dispatch('menuItems/cleanModal')
}
</script>

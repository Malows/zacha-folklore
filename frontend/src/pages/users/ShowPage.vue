<template>
  <page-with-actions
    v-if="user"
    title="Ver Usuario"
  >
    <template #actions>
      <action
        label="Editar"
        icon="edit"
        :to="editRoute"
      />
      <action
        label="Cambiar contraseña"
        icon="vpn_key"
        disable
        @click="showModalPassword"
      />
      <action
        label="Eliminar"
        icon="delete"
        color="negative"
        @click="showModalDelete"
      />
    </template>

    <inline-data label="Nombre">
      {{ user.name }}
    </inline-data>

    <inline-data label="Email">
      {{ user.email }}
    </inline-data>

    <q-dialog v-model="modalPassword">
      <change-password-dialog :user="user" />
    </q-dialog>

    <q-dialog v-model="modalDelete">
      <delete-dialog :user="user" />
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
import ChangePasswordDialog from 'components/dialogs/users/ChangePasswordDialog.vue'
import DeleteDialog from 'components/dialogs/users/DeleteDialog.vue'

const { store, quasar, route } = environment()

const user = computed(() => store.getters['users/user'])

const [modalPassword, showModalPassword] = modalFactory()
const [modalDelete, showModalDelete] = modalFactory()

const editRoute = computed(() => ({
  name: 'users edit',
  params: { userId: user.value?.id ?? '' }
}))

onMounted(async () => {
  if (!user.value) {
    await pull(store, quasar, 'users/get', Number(route.params.userId))
  }
})

</script>

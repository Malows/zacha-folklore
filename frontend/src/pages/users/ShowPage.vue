<template>
  <page-with-actions
    v-if="user"
    title="Ver Usuario"
  >
    <template #actions>
      <action-btn
        label="Editar"
        icon="edit"
        :to="editRoute"
      />
      <action-btn
        label="Cambiar contraseña"
        icon="vpn_key"
        disable
        @click="showModalPassword"
      />
      <action-btn
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

    <p class="text-body1">
      <strong>Roles:</strong>
    </p>
    <q-list>
      <q-item
        v-for="role in user.roles"
        :key="role"
      >
        <q-item-label>{{ roleLabel(role) }}</q-item-label>
      </q-item>
    </q-list>

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
import { checkAdminRole } from 'src/composable/checkRole'
import { pull } from 'src/utils/api'
import { roleLabel } from 'src/utils/text'

import PageWithActions from 'components/shared/pages/PageWithActions.vue'
import ActionBtn from 'src/components/shared/stickyButtons/ActionBtn.vue'
import InlineData from 'components/shared/InlineData.vue'
import ChangePasswordDialog from 'components/dialogs/users/ChangePasswordDialog.vue'
import DeleteDialog from 'components/dialogs/users/DeleteDialog.vue'

const { store, quasar, route, router } = environment()

const user = computed(() => store.getters['users/user'])

const [modalPassword, showModalPassword] = modalFactory()
const [modalDelete, showModalDelete] = modalFactory()

const editRoute = computed(() => ({
  name: 'users edit',
  params: { userId: user.value?.id ?? '' }
}))

onMounted(async () => {
  checkAdminRole(store, router, quasar)

  if (!user.value) {
    await pull(store, quasar, 'users/get', Number(route.params.userId))
  }
})

</script>

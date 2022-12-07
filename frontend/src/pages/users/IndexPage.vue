<template>
  <page-with-add
    title="Usuarios"
    :to="{ name: 'users create' }"
  >
    <filterable-list :items="users">
      <template #default="{ item }">
        <user-item :user="item" />
      </template>
    </filterable-list>
  </page-with-add>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkAdminRole } from 'src/composable/checkRole'
import { pull } from 'src/utils/api'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import UserItem from 'components/listItems/UserItem.vue'

const { store, router, quasar } = environment()

onMounted(() => {
  checkAdminRole(store, router, quasar)

  pull(store, quasar, 'users/fetch')
})

const users = computed(() => store.state.users.users)
</script>

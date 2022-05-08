<template>
  <page-with-add
    title="Usuarios"
    :to="{ name: 'users create' }"
  >
    <filterable-list :items="users" />
  </page-with-add>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'

import { pull } from 'src/utils/api'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'

const store = useStore()
const quasar = useQuasar()

onMounted(() => pull(store, quasar, 'users/fetch'))

const users = computed(() => store.getters['users/usersOptions'])
</script>

<template>
  <page-with-add
    title="Reservas"
    :to="{ name: 'reservations create' }"
  >
    <filterable-list :items="reservations">
      <template #default="{ item }">
        <reservation-item :reservation="item" />
      </template>
    </filterable-list>
  </page-with-add>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { pull } from 'src/utils/api'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import ReservationItem from 'components/listItems/ReservationItem.vue'

const { store, quasar } = environment()

onMounted(() => pull(store, quasar, 'reservations/fetch'))

const reservations = computed(() => store.state.reservations.reservations)
</script>

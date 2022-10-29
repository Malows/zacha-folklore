<template>
  <page-with-add
    title="Reservas"
    :to="{ name: 'reservations create' }"
  >
    <display-selected-event :event="event" />
    <filterable-list
      :filter-fn="reservationFilter"
      :items-per-page="20"
      :items="reservations"
    >
      <template #default="{ item }">
        <reservation-item :reservation="item" />
      </template>
    </filterable-list>
  </page-with-add>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkEvent } from 'src/composable/checkRequirement'
import { pull } from 'src/utils/api'
import { reservationFilter } from 'src/utils/filters'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import ReservationItem from 'components/listItems/ReservationItem.vue'
import DisplaySelectedEvent from 'components/DisplaySelectedEvent.vue'

const { store, quasar, router } = environment()

onMounted(() => {
  const eventId = checkEvent(store, router, quasar)

  pull(store, quasar, 'reservations/fetch', { eventId })
})

const event = computed(() => store.state.events.selectedEvent)
const reservations = computed(() => store.state.reservations.reservations)
</script>

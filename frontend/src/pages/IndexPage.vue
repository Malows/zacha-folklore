<template>
  <!-- <q-page class="flex flex-center"> -->
  <q-page padding>
    <display-selected-event :event="event" />

    <div class="flex flex-center">
      <filterable-list
        v-if="reservations.length > 0"
        :filter-fn="reservationFilter"
        :items-per-page="20"
        :items="reservations"
      >
        <template #default="{ item }">
          <dashboard-item
            :reservation="item"
            @click="handleClick"
          />
        </template>
      </filterable-list>

      <h2 v-else>
        No quedan mas reservas 🎉
      </h2>
    </div>

    <q-dialog
      :model-value="reservation != null"
      @update:model-value="reservation = null"
    >
      <quick-update-dialog :reservation="reservation" />
    </q-dialog>
  </q-page>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'

import environment from 'src/composable/environment'
import { pull } from 'src/utils/api'
import { reservationFilter } from 'src/utils/filters'

import FilterableList from 'components/shared/filterable/FilterableList.vue'
import DashboardItem from 'components/listItems/DashboardItem.vue'
import QuickUpdateDialog from 'components/dialogs/reservations/QuickUpdateDialog.vue'
import DisplaySelectedEvent from 'src/components/DisplaySelectedEvent.vue'

const { store, quasar, router } = environment()

const reservation = ref(null)

const event = computed(() => store.state.events.selectedEvent)
const reservations = computed(() => store.getters['reservations/notUsedReservations'])

onMounted(async () => {
  await pull(store, quasar, 'events/fetch')

  if (!event.value) {
    quasar.notify({
      color: 'info',
      message: 'No hay un evento seleccionado. Por favor elija con que evento desea trabajar',
      timeout: 4000
    })
    return router.push({ name: 'events selection' })
  }

  pull(store, quasar, 'reservations/fetch', { eventId: event.value.id })
})

function handleClick (item) {
  reservation.value = item
}
</script>

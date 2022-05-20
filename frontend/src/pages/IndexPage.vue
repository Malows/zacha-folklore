<template>
  <q-page class="flex flex-center">
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

const { store, quasar } = environment()

const reservation = ref(null)

const reservations = computed(() => store.getters['reservations/notUsedReservations'])

onMounted(() => pull(store, quasar, 'reservations/fetch'))

function handleClick (item) {
  reservation.value = item
}
</script>

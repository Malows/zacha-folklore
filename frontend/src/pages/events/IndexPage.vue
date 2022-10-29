<template>
  <page-with-add
    title="Eventos"
    :to="{ name: 'events create' }"
  >
    <display-selected-event :event="selectedEvent" />

    <filterable-list :items="events">
      <template #default="{ item }">
        <event-item :event="item" />
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
import EventItem from 'components/listItems/EventItem.vue'
import DisplaySelectedEvent from 'components/DisplaySelectedEvent.vue'

const { store, quasar } = environment()

onMounted(() => pull(store, quasar, 'events/fetch'))

const events = computed(() => store.state.events.events)
const selectedEvent = computed(() => store.state.events.selectedEvent)
</script>

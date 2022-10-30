<template>
  <page-with-add
    title="Seleccionar evento"
    :to="{ name: 'events create' }"
  >
    <filterable-list :items="events">
      <template #default="{ item }">
        <select-event-item :event="item" @select="handleSelection" />
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
import SelectEventItem from 'components/listItems/SelectEventItem.vue'

const { store, router, quasar } = environment()

onMounted(() => pull(store, quasar, 'events/fetch'))

const events = computed(() => store.state.events.events)

function handleSelection(event) {
  store.dispatch('events/selectEvent', event.value)
  quasar.notify('Evento seleccionado')
  router.push({ name: 'home' })
}
</script>

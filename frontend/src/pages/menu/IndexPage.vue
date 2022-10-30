<template>
  <page-with-add
    title="Menú"
    :to="{ name: 'menu create' }"
  >
    <display-selected-event :event="event" />
    <copy-menu :sections="sections" />
    <filterable-list :items="sections">
      <template #default="{ item }">
        <section-item :section="item" />
      </template>
    </filterable-list>
  </page-with-add>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkEvent } from 'src/composable/checkRequirement'
import { pull } from 'src/utils/api'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import SectionItem from 'components/listItems/SectionItem.vue'
import DisplaySelectedEvent from 'src/components/banners/DisplaySelectedEvent.vue'
import CopyMenu from 'src/components/banners/CopyMenu.vue'

const { store, router, quasar } = environment()

const event = computed(() => store.state.events.selectedEvent)
const sections = computed(() => store.state.menuSections.menuSections)

onMounted(() => {
  const eventId = checkEvent(store, router, quasar)

  pull(store, quasar, 'menuSections/fetch', { eventId })
})
</script>

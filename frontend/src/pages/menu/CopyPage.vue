<template>
  <page-with-add
    title="Copiar menú"
    :to="{ name: 'menu create' }"
  >
    <filterable-list :items="eventsWithou">
      <template #default="{ item }">
        <select-event-item
          :event="item"
          @select="handleSelection"
        />
      </template>
    </filterable-list>
  </page-with-add>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import environment from 'src/composable/environment'
import { checkEvent } from 'src/composable/checkRequirement'
import { pull, task } from 'src/utils/api'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import SelectEventItem from 'components/listItems/SelectEventItem.vue'

const { store, router, quasar } = environment()

const events = computed(() => store.state.events.events)
const event = computed(() => store.state.events.selectedEvent)
const eventsWithou = computed(() => events.value.filter(x => x.id !== event.value.id))

onMounted(async () => {
  checkEvent(store, router, quasar)

  pull(store, quasar, 'events/withMenu')
})

function handleSelection (selected) {
  task(store, quasar, 'events/copyMenu', { from: selected.id, to: event.value.id })
    .then(() => {
      quasar.notify('Menú copiado')
      router.push({ name: 'menu index' })
    })
}
</script>

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
import { checkEvent } from 'src/composable/checkRequirement'
import { pull } from 'src/utils/api'
import { EventInfoService } from 'src/services/Custom'


import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import SelectEventItem from 'components/listItems/SelectEventItem.vue'

const { store, router, quasar } = environment()

const events = ref([])
const event = computed(() => store.state.events.selectedEvent)

const service = new EventInfoService()

onMounted(async () => {
  checkEvent(store, router, quasar)

  const [_, withMenu] = await Promise.all([
    pull(store, quasar, 'events/fetch'),
    service.withMenu()
  ])

  events.value = withMenu.data.filter(x => x.id !== event.value.id)
})

function handleSelection (selected) {
  service.copy({ from: selected.id, to: event.value.id })
    .then(() => {
      quasar.notify('Menu copiado')
      router.push({ name: 'menu index' })
    })
}
</script>

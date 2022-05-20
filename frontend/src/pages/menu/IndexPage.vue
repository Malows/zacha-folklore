<template>
  <page-with-add
    title="Menú"
    :to="{ name: 'menu create' }"
  >
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
import { pull } from 'src/utils/api'

import PageWithAdd from 'components/shared/pages/PageWithAdd.vue'
import FilterableList from 'components/shared/filterable/FilterableList.vue'
import SectionItem from 'components/listItems/SectionItem.vue'

const { store, quasar } = environment()

const sections = computed(() => store.state.menuSections.menuSections)

onMounted(() => pull(store, quasar, 'menuSections/fetch'))
</script>

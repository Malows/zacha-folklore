<template>
  <div>
    <filter-input
      v-model="searchField"
      @change="minPage"
    />

    <q-list>
      <template v-for="item in sliced">
        <slot :item="item" />
      </template>
    </q-list>

    <filter-pagination
      v-model="currentPage"
      :per-page="numberOfPages"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

import { byName } from 'src/utils/filters'

import FilterInput from 'src/components/shared/filterable/FilterInput.vue'
import FilterPagination from 'src/components/shared/filterable/FilterPagination.vue'

const props = defineProps({
  items: {
    type: Array,
    required: true
  },

  filterFn: {
    type: Function,
    default: byName
  },

  itemsPerPage: {
    type: Number,
    default: 10
  }
})

const searchField = ref('')
const currentPage = ref(1)

const filtered = computed(() => {
  if (!props.items) return []
  if (!searchField.value) return props.items

  return props.items
    .filter(props.filterFn(searchField.value))
})

const numberOfPages = computed(() => {
  return Math.ceil(filtered.value.length / props.itemsPerPage)
})

const sliced = computed(() => {
  return filtered.value.slice(
    (currentPage.value - 1) * props.itemsPerPage,
    currentPage.value * props.itemsPerPage
  )
})

function minPage () {
  currentPage.value = numberOfPages.value === 0
    ? 0
    : 1
}
</script>

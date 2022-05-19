<template>
  <q-item
    clickable
    :to="route"
    exact
  >
    <!-- <q-item-section avatar>
      <q-item-label>
        ({{ props.section.amount }})
      </q-item-label>
    </q-item-section> -->

    <q-item-section>
      <q-item-label>
        {{ props.section.name }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  section: {
    type: Object,
    required: true
  }
})

const route = computed(() => ({
  name: 'menu show',
  params: {
    menuSectionId: props.section.id
  }
}))
</script>

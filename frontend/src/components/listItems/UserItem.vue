<template>
  <q-item
    clickable
    :to="route"
    exact
  >
    <q-item-section>
      <q-item-label>
        {{ props.user.name }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const route = computed(() => ({
  name: 'users show',
  params: {
    userId: props.user.id
  }
}))
</script>

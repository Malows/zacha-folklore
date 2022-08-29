<template>
  <q-item
    clickable
    :to="route"
    exact
  >
    <q-item-section
      v-show="props.event.isActive"
      avatar
    >
      <q-item-label>
        <q-icon
          name="circle"
          color="primary"
        />
      </q-item-label>
    </q-item-section>

    <q-item-section>
      <q-item-label>
        {{ props.event.lastName }}, {{ props.event.name }}
      </q-item-label>
    </q-item-section>

    <q-item-section
      v-show="props.event.isPaid"
      avatar
    >
      <q-icon
        name="paid"
        color="primary"
      />
    </q-item-section>
    <q-item-section
      v-show="props.event.isUsed"
      avatar
    >
      <q-icon
        name="emoji_people"
        color="primary"
      />
    </q-item-section>
  </q-item>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
})

const route = computed(() => ({
  name: 'events show',
  params: {
    eventId: props.event.id
  }
}))
</script>

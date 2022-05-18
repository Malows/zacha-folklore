<template>
  <q-item
    clickable
    :to="route"
    exact
  >
    <q-item-section avatar>
      <q-item-label>
        ({{ props.reservation.amount }})
      </q-item-label>
    </q-item-section>

    <q-item-section>
      <q-item-label>
        {{ props.reservation.lastName }}, {{ props.reservation.name }}
      </q-item-label>
    </q-item-section>

    <q-item-section
      v-show="props.reservation.isPaid"
      avatar
    >
      <q-icon
        name="paid"
        color="primary"
      />
    </q-item-section>
    <q-item-section
      v-show="props.reservation.isUsed"
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
  reservation: {
    type: Object,
    required: true
  }
})

const route = computed(() => ({
  name: 'reservations show',
  params: {
    reservationId: props.reservation.id
  }
}))
</script>

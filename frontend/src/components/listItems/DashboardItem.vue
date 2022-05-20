<template>
  <q-item
    clickable
    @click="emits('click', reservation)"
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
  </q-item>
</template>

<script setup>
const props = defineProps({
  reservation: {
    type: Object,
    required: true
  }
})

const emits = defineEmits(['click'])
</script>

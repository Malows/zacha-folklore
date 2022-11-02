<template>
  <q-input
    :model-value="value"
    :label="props.label"
    mask="date"
    :rules="['date']"
    @update:model-value="handle"
  >
    <template #append>
      <q-icon
        name="event"
        class="cursor-pointer"
      >
        <q-popup-proxy
          cover
          transition-show="scale"
          transition-hide="scale"
        >
          <q-date
            :model-value="value"
            @update:model-value="handle"
          >
            <div class="row items-center justify-end">
              <q-btn
                v-close-popup
                label="Close"
                color="primary"
                flat
              />
            </div>
          </q-date>
        </q-popup-proxy>
      </q-icon>
    </template>
  </q-input>
</template>

<script setup>
import { fromInput, toInput } from 'src/utils/date'
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: [Date, null],
    required: true,
    default: null
  },

  label: {
    type: String,
    required: true
  }
})

const value = computed(() => props.modelValue ? toInput(props.modelValue) : null)

const emits = defineEmits(['update:modelValue'])

function handle (value) {
  if (value) {
    emits('update:modelValue', fromInput(value))
  }
}
</script>

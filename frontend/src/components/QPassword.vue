<template>
  <q-input
    :model-value="props.modelValue"
    :type="passwordMeta.type"
    v-bind="$attrs"
    @update:model-value="onInput"
  >
    <template #append>
      <q-icon
        class="cursor-pointer"
        :name="passwordMeta.icon"
        @click="toggle"
      />
    </template>
  </q-input>
</template>

<script setup>
import { QInput, QIcon } from 'quasar'
import { ref, computed } from 'vue'

const props = defineProps({

  modelValue: {
    type: String,
    default: ''
  }
})

const emits = defineEmits(['update:modelValue'])

const isPassword = ref(true)

const passwordMeta = computed(() =>
  isPassword.value
    ? { icon: 'visibility', type: 'password' }
    : { icon: 'visibility_off', type: 'text' }
)

function toggle () {
  isPassword.value = !isPassword.value
}

function onInput (value) {
  emits('update:modelValue', value)
}
</script>

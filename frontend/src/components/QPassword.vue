<template>
  <q-input
    :modelValue="props.modelValue"
    @update:modelValue="onInput"
    :type="passwordMeta.type"
    v-bind="$attrs"
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
    type: String
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

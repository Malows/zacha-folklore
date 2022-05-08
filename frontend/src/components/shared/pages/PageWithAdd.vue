<template>
  <page :title="props.title">
    <template v-if="!props.hideBtn">
      <sticky-path
        v-if="props.to"
        icon="add"
        :to="props.to"
      />
      <sticky-btn
        v-else
        icon="add"
        @click="emits('click')"
      />
    </template>

    <slot />
  </page>
</template>

<script setup>
import Page from 'components/shared/pages/Page.vue'
import StickyBtn from 'components/shared/stickyButtons/StickyBtn.vue'
import StickyPath from 'components/shared/stickyButtons/StickyPath.vue'

const props = defineProps({
  title: {
    type: String,
    default: ''
  },
  to: {
    type: [String, Object],
    default: null
  },
  hideBtn: {
    type: [Boolean],
    default: false
  }
})

const emits = defineEmits(['click'])
</script>

<template>
  <page :title="props.title">
    <sticky-actions style="z-index: 10;">
      <slot name="actions" />
    </sticky-actions>

    <slot />
  </page>
</template>

<script setup>
import Page from 'components/shared/pages/Page.vue'
import StickyActions from 'components/stickyButtons/StickyActions.vue'

const props = defineProps({
  title: {
    type: String,
    default: ''
  }
})
</script>

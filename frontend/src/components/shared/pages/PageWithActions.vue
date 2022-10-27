<template>
  <common-page :title="props.title">
    <sticky-actions style="z-index: 10;">
      <slot name="actions" />
    </sticky-actions>

    <slot />
  </common-page>
</template>

<script setup>
import CommonPage from 'src/components/shared/pages/CommonPage.vue'
import StickyActions from 'components/shared/stickyButtons/StickyActions.vue'

const props = defineProps({
  title: {
    type: String,
    default: ''
  }
})
</script>

<script setup>
import InlineSvg from 'vue-inline-svg'
import { computed } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },

  autosize: {
    type: Boolean,
    default: false,
  }
})

const styleObject = computed(() => {
  return props.autosize ? {
    height: '1em',
    width: '1em',
    verticalAlign: '-0.125em',
  } : {}
})
</script>

<template>
  <InlineSvg
    :src="'/icons/' + name + '.svg'"
    class="inline-block"
    :style="styleObject"
    role="img"
  />
</template>

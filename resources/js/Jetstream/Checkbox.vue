<script setup>
import { computed } from 'vue'

const emit = defineEmits(['update:checked'])

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    default: false,
  },
  value: {
    type: String,
    default: null,
  },
})

const proxyChecked = computed({
  get() {
    return props.checked
  },
  set(val) {
    emit('update:checked', val)
  },
})
</script>

<template>
  <input
    v-model="proxyChecked"
    type="checkbox"
    :value="value"
    class="rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-300 dark:text-gray-900 shadow-sm focus:border-gray-400 dark:focus:border-pink-700 focus:ring focus:ring-gray-200 dark:focus:ring-gray-700 focus:ring-opacity-50"
  >
</template>

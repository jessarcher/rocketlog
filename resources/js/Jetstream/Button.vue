<script setup>
defineProps({
  type: {
    type: String,
    default: 'submit',
  },
})
</script>

<template>
  <button
    :type="type"
    class="inline-flex items-center px-5 py-2 bg-purple-500 rounded font-bold text-sm text-white hover:bg-purple-600 active:bg-purple-700 focus:outline-none focus:bg-purple-600 focus:shadow-outline-gray transition ease-in-out duration-150"
  >
    <slot />
  </button>
</template>

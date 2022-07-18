<script setup>
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
  href: {
    type: String,
    required: false,
  },
  as: {
    type: String,
    required: false,
  },
})
</script>

<template>
  <div>
    <button
      v-if="as == 'button'"
      type="submit"
      class="block w-full px-4 py-2 text-base leading-6 text-gray-700 dark:text-gray-100 text-left hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
    >
      <slot />
    </button>

    <a
      v-else-if="as == 'a'"
      :href="href"
      class="block px-4 py-2 text-base leading-6 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
    >
      <slot />
    </a>

    <Link
      v-else
      :href="href"
      class="block px-4 py-2 text-base leading-6 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
    >
      <slot />
    </Link>
  </div>
</template>

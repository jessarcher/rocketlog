<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Components/Icon.vue'

defineProps(['href', 'icon', 'active'])
</script>

<template>
  <Link
    :href="href"
    class="group flex items-top py-3 border-b border-gray-200 dark:border-gray-700 font-medium hover:text-gray-800 dark:hover:text-white focus:text-gray-800 dark:focus:text-white"
    :class="active ? 'text-gray-800 dark:text-white' : 'text-gray-600 dark:text-gray-400'"
  >
    <Icon
      :name="icon"
      class="mt-1 h-4 w-4 flex-shrink-0"
      :class="active ? 'text-pink-600 dark:text-pink-500' : 'text-gray-500 group-hover:text-gray-600 group-focus:text-gray-600 dark:group-hover:text-gray-400 dark:group-focus:text-gray-400'"
    />
    <span class="ml-2"><slot /></span>
  </Link>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  active: Boolean,
  href: String,
  as: String,
})

const classes = computed(() => {
  return 'block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out focus:outline-none '
      + (props.active
        ? 'bg-gray-50 dark:bg-gray-700 border-pink-600 text-gray-700 dark:text-gray-300 focus:text-pink-800 focus:bg-pink-100 focus:border-pink-700'
        : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300')
})
</script>

<template>
  <div>
    <button
      v-if="as == 'button'"
      :class="classes"
      class="w-full text-left"
    >
      <slot />
    </button>

    <a
      v-else-if="as == 'a'"
      :href="href"
      :class="classes"
    >
      <slot />
    </a>

    <Link
      v-else
      :href="href"
      :class="classes"
    >
      <slot />
    </Link>
  </div>
</template>

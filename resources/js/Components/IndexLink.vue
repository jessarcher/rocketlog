<template>
    <inertia-link
        :href="href"
        class="flex items-center py-3 border-b border-gray-200 dark:border-gray-700 font-medium  hover:text-gray-900 dark:hover:text-white focus:text-gray-900 dark:focus:text-white"
        :class="active ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'"
    >
        <Icon :name="icon" class="h-4 w-4" :class="active ? 'text-pink-600 dark:text-pink-500' : 'text-gray-500'" />
        <span class="ml-2"><slot /></span>
    </inertia-link>
</template>

<script>
import Icon from '@/Components/Icon'

export default {
    components: {
        Icon,
    },

    props: ['href', 'icon', 'active']
}
</script>

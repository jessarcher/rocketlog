<template>
    <inertia-link
        :href="href"
        class="flex items-center py-3 border-b border-gray-200 dark:border-gray-700 font-medium text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-pink-500 focus:text-gray-900 dark:focus:text-pink-500"
    >
        <Icon :name="icon" class="h-4 w-4" :class="active ? 'text-pink-500' : 'text-gray-500'" />
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

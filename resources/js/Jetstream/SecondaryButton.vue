<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-white dark:bg-transparent border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:text-gray-500 dark:hover:text-gray-100 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>

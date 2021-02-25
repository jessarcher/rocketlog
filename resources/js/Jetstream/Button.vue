<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-purple-500 to-indigo-600 border border-transparent rounded-md font-bold text-sm text-white hover:from-purple-600 active:from-purple-600 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>

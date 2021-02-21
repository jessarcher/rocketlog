<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-pink-500 to-purple-500 border border-transparent rounded-md font-bold text-sm text-white hover:from-purple-500 active:from-purple-500 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
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

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-700 rounded font-bold text-sm text-white hover:from-pink-600 hover:to-purple-800 active:from-pink-600 active:to-purple-800 focus:outline-none focus:from-pink-600 focus:to-purple-800 focus:shadow-outline-gray transition ease-in-out duration-150">
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

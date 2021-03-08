<template>
    <input class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-pink-500 dark:focus:border-pink-500 focus:ring focus:ring-gray-300 dark:focus:ring-pink-800 focus:ring-opacity-50 rounded-md shadow-sm" :value="value" @input="$emit('input', $event.target.value)" ref="input">
</template>

<script>
    export default {
        props: ['value'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>


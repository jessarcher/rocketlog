<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-300 dark:text-gray-900 shadow-sm focus:border-gray-400 dark:focus:border-pink-700 focus:ring focus:ring-gray-200 dark:focus:ring-gray-700 focus:ring-opacity-50">
</template>

<script>
    export default {
        model: {
            prop: "checked",
            event: "change",
        },

        props: {
            checked: {
                type: [Array, Boolean],
                default: false,
            },
            value: {
                default: null,
            },
        },

        computed: {
            proxyChecked: {
                get() {
                    return this.checked;
                },
                set(val) {
                    this.$emit("change", val);
                },
            },
        },
    }
</script>


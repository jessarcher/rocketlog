<template>
    <div>
        <button :class="classes" class="w-full text-left" v-if="as == 'button'">
            <slot></slot>
        </button>

        <a :href="href" :class="classes" v-else-if="as == 'a'">
            <slot></slot>
        </a>

        <inertia-link :href="href" :class="classes" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['active', 'href', 'as'],

        computed: {
            classes() {
                return this.active
                            ? 'block pl-3 pr-4 py-2 border-l-4 border-pink-600 text-base font-medium text-gray-700 dark:text-gray-300 bg-pink-50 dark:bg-gray-700 focus:outline-none focus:text-pink-800 focus:bg-pink-100 focus:border-pink-700 transition duration-150 ease-in-out'
                            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out'
            }
        }
    }
</script>

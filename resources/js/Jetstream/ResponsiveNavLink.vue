<template>
    <div>
        <button :class="classes" class="w-full text-left" v-if="as == 'button'">
            <slot></slot>
        </button>

        <a :href="href" :class="classes" v-else-if="as == 'a'">
            <slot></slot>
        </a>

        <Link :href="href" :class="classes" v-else>
            <slot></slot>
        </Link>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        components: { Link },

        props: ['active', 'href', 'as'],

        computed: {
            classes() {
                return 'block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out focus:outline-none '
                    + (this.active
                        ? 'bg-gray-50 dark:bg-gray-700 border-pink-600 text-gray-700 dark:text-gray-300 focus:text-pink-800 focus:bg-pink-100 focus:border-pink-700'
                        : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300')
            }
        }
    }
</script>

<template>
    <transition
        appear
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div class="sticky" style="top: 100px;">
            <div class="-mt-6 absolute w-full flex justify-center">
                <button type="button" class="flex items-center justify-center" @click="$emit('reload')">
                    <div class="px-4 py-2 border dark:border-gray-600 text-center bg-white dark:bg-gray-700 rounded-lg text-gray-800 dark:text-gray-200 font-medium shadow-lg">
                        <Icon name="medium/refresh" class="w-5 h-5 text-pink-600" :class="[ reloading ? 'animate-spin' : 'animate-pulse-fast group-hover:animate-none' ] "/>
                        <span class="ml-2"><slot>Content updated</slot></span>
                        <span class="ml-3 text-pink-600 font-semibold">Reload</span>
                    </div>
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
import Icon from '@/Components/Icon'

export default {
    components: {
        Icon,
    },

    props: ['reloading'],
}
</script>

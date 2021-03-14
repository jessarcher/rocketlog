<template>
    <app-layout>
        <div class="md:py-12 flex-1 flex flex-col">
            <div class="flex-1 max-w-7xl w-full mx-auto md:px-6 flex flex-col md:flex-row-reverse">
                <aside class="hidden md:block md:ml-12 md:pt-12 lg:w-80">
                    <index />
                </aside>

                <div class="flex-1 p-4 sm:p-6 md:p-12 bg-white dark:bg-gray-800 sm:rounded-lg md:shadow-xl">
                    <slot></slot>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './AppLayout'
    import Index from '@/Components/Index'

    export default {
        components: {
            AppLayout,
            Index,
        },
    }
</script>

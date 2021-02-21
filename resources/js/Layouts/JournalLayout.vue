<template>
    <app-layout>
        <div class="md:py-12 flex-1 flex flex-col">
            <div class="flex-1 max-w-7xl w-full mx-auto md:px-6 flex flex-col md:flex-row-reverse">
                <aside class="hidden md:block md:ml-12 md:pt-12 lg:w-80">
                    <h2 class="pb-3 border-b font-bold border-gray-200 text-gray-900">Index</h2>

                    <inertia-link
                        :href="route('daily-log.index')"
                        class="flex items-center py-3 border-b border-gray-200 font-medium text-gray-700 hover:text-purple-800 focus:text-purple-800"
                    >
                        <calendar-icon class="h-4 w-4" :class="route().current('daily-log.index') ? 'text-purple-500' : 'text-gray-500'" />
                        <span class="ml-2" :class="route().current('daily-log.index') ? 'text-purple-900' : 'text-gray-900'">Daily Log</span>
                    </inertia-link>

                    <inertia-link
                        v-for="collection in $page.props.collections"
                        :key="collection.hashid"
                        :href="route('c.show', collection.hashid)"
                        class="flex items-center py-3 border-b border-gray-200 font-medium text-gray-700 hover:text-purple-800 focus:text-purple-800"
                    >
                        <clipboard-icon class="h-4 w-4" :class="route().current('c.show', collection.hashid) ? 'text-purple-500' : 'text-gray-500'" />
                        <span class="ml-2" :class="route().current('c.show', collection.hashid) ? 'text-purple-900' : ''">{{ collection.name }}</span>
                    </inertia-link>

                    <div class="relative">
                        <input type="text" v-model="newCollectionName" @keydown.enter="addCollection" class="py-3 px-2 border-t-0 border-l-0 border-r-0 border-b border-gray-200 w-full bg-transparent placeholder-gray-400" placeholder="New collection...">
                    </div>

                    <template v-if="$page.props.sharedCollections.length > 0">
                        <h2 class="mt-10 pb-3 border-b font-bold border-gray-200 text-gray-900">Shared with you</h2>

                        <inertia-link
                            v-for="collection in $page.props.sharedCollections"
                            :key="collection.hashid"
                            :href="route('c.show', collection.hashid)"
                            class="flex items-center py-3 border-b border-gray-200 font-medium text-gray-700 hover:text-purple-800 focus:text-purple-800"
                        >
                            <clipboard-icon class="h-4 w-4" :class="route().current('c.show', collection.hashid) ? 'text-purple-500' : 'text-gray-500'" />
                            <span class="ml-2" :class="route().current('c.show', collection.hashid) ? 'text-purple-900' : ''">{{ collection.name }}</span>
                        </inertia-link>
                    </template>
                </aside>

                <div class="flex-1 p-4 sm:p-6 md:p-12 bg-white overflow-hidden sm:rounded-lg md:shadow-xl">
                    <slot></slot>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './AppLayout'
    import CalendarIcon from '@/Components/Icons/CalendarIcon'
    import ClipboardIcon from '@/Components/Icons/ClipboardIcon'

    export default {
        components: {
            AppLayout,
            CalendarIcon,
            ClipboardIcon,
        },

        data() {
            return {
                newCollectionName: '',
            }
        },

        methods: {
            async addCollection() {
                this.$inertia.post(route('c.store'), {
                    name: this.newCollectionName,
                })
            }
        }
    }
</script>

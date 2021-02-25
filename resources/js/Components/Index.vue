<template>
    <div>
        <h2 class="pb-3 border-b font-bold border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">Index</h2>

        <inertia-link
            :href="route('daily-log.index')"
            class="flex items-center py-3 border-b border-gray-200 dark:border-gray-700 font-medium hover:text-purple-800 dark:hover:text-purple-400 focus:text-purple-800 dark:focus:text-purple-400"
            :class="route().current('daily-log.index') ? 'text-purple-900 dark:text-purple-400' : 'text-gray-700 dark:text-gray-300'"
        >
            <calendar-icon class="h-4 w-4" :class="route().current('daily-log.index') ? 'text-purple-500' : 'text-gray-500'" />
            <span class="ml-2">Daily Log</span>
        </inertia-link>

        <inertia-link
            v-for="collection in $page.props.collections"
            :key="collection.hashid"
            :href="route('c.show', collection.hashid)"
            class="flex items-center py-3 border-b border-gray-200 dark:border-gray-700 font-medium hover:text-purple-800 dark:hover:text-purple-400 focus:text-purple-800 dark:focus:text-purple-400"
            :class="route().current('c.show', collection.hashid) ? 'text-purple-900 dark:text-purple-400' : 'text-gray-700 dark:text-gray-300'"
        >
            <clipboard-icon class="h-4 w-4" :class="route().current('c.show', collection.hashid) ? 'text-purple-500' : 'text-gray-500'" />
            <span class="ml-2">{{ collection.name }}</span>
        </inertia-link>

        <div class="relative">
            <input type="text" v-model="newCollectionName" @keydown.enter="addCollection" class="py-3 px-2 border-t-0 border-l-0 border-r-0 border-b border-gray-200 dark:border-gray-700 w-full bg-transparent placeholder-gray-400 dark:placeholder-gray-700 text-gray-900 dark:text-gray-100" placeholder="New collection...">
        </div>

        <template v-if="$page.props.sharedCollections.length > 0">
            <h2 class="mt-10 pb-3 border-b font-bold border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">Shared with you</h2>

            <inertia-link
                v-for="collection in $page.props.sharedCollections"
                :key="collection.hashid"
                :href="route('c.show', collection.hashid)"
                class="flex items-center py-3 border-b border-gray-200 dark:border-gray-700 font-medium hover:text-purple-800 dark:hover:text-purple-400 focus:text-purple-800 dark:focus:text-purple-400"
                :class="route().current('c.show', collection.hashid) ? 'text-purple-900 dark:text-purple-400' : 'text-gray-700 dark:text-gray-300'"
            >
                <clipboard-icon class="h-4 w-4" :class="route().current('c.show', collection.hashid) ? 'text-purple-500' : 'text-gray-500'" />
                <span class="ml-2">{{ collection.name }}</span>
            </inertia-link>
        </template>
    </div>
</template>

<script>
import CalendarIcon from '@/Components/Icons/CalendarIcon'
import ClipboardIcon from '@/Components/Icons/ClipboardIcon'

export default {
    components: {
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

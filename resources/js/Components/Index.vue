<template>
    <div>
        <h2 class="pb-3 border-b font-bold border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">Index</h2>

        <index-link :href="route('daily-log.index')" :active="route().current('daily-log.index')" icon="medium/calendar">
            Daily Log
        </index-link>

        <index-link :href="route('future-log.index')" :active="route().current('future-log.index')" icon="medium/clock">
            Future Log
        </index-link>

        <index-link
            v-for="collection in $page.props.collections"
            :key="collection.hashid"
            :href="route('c.show', collection.hashid)"
            :active="route().current('c.show', collection.hashid)"
            icon="medium/clipboard"
        >
            {{ collection.name }}
        </index-link>

        <div class="relative border-t-0 border-l-0 border-r-0 border-b border-gray-200 dark:border-gray-700">
            <input type="text" v-model="newCollectionName" @keydown.enter="addCollection" class="py-3 px-2 w-full border-none bg-transparent placeholder-gray-400 dark:placeholder-gray-700 text-gray-900 dark:text-gray-100 focus:ring-0" placeholder="New collection...">
        </div>

        <template v-if="$page.props.sharedCollections.length > 0">
            <h2 class="mt-10 pb-3 border-b font-bold border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">Shared with you</h2>

            <index-link
                v-for="collection in $page.props.sharedCollections"
                :key="collection.hashid"
                :href="route('c.show', collection.hashid)"
                :active="route().current('c.show', collection.hashid)"
                icon="medium/clipboard"
            >
                {{ collection.name }}
            </index-link>
        </template>
    </div>
</template>

<script>
import CalendarIcon from '@/Components/Icons/CalendarIcon'
import ClipboardIcon from '@/Components/Icons/ClipboardIcon'
import IndexLink from './IndexLink'

export default {
    components: {
        CalendarIcon,
        ClipboardIcon,
        IndexLink,
    },

    data() {
        return {
            newCollectionName: '',
        }
    },

    methods: {
        async addCollection() {
            await this.$inertia.post(
                route('c.store'),
                { name: this.newCollectionName },
                { preserveState: false }
            )

            this.newCollectionName = '';
        }
    }
}
</script>

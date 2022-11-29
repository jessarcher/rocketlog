<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'
import IndexLink from './IndexLink.vue'

const newCollectionName = ref('')

const addCollection = () => Inertia.post(
  route('c.store'),
  { name: newCollectionName.value },
  {
    preserveState: false,
    onSuccess: () => newCollectionName.value = '',
  }
)
</script>

<template>
  <div>
    <h2 class="pb-3 border-b font-bold border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
      Index
    </h2>

    <IndexLink
      :href="route('daily-log.index')"
      :active="route().current('daily-log.index')"
      icon="medium/calendar"
    >
      Daily Log
    </IndexLink>

    <IndexLink
      v-for="collection in $page.props.collections"
      :key="collection.hashid"
      :href="route('c.show', collection.hashid)"
      :active="route().current('c.show', collection.hashid)"
      icon="medium/clipboard"
    >
      {{ collection.name }}
    </IndexLink>

    <div class="relative border-t-0 border-l-0 border-r-0 border-b border-gray-200 dark:border-gray-700">
      <input
        v-model="newCollectionName"
        type="text"
        class="py-3 px-2 w-full border-none bg-transparent placeholder-gray-400 dark:placeholder-gray-700 text-gray-900 dark:text-gray-100 focus:ring-0"
        placeholder="New collection..."
        @keydown.enter="addCollection"
      >
    </div>

    <template v-if="$page.props.sharedCollections.length > 0">
      <h2 class="mt-10 pb-3 border-b font-bold border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
        Shared with you
      </h2>

      <IndexLink
        v-for="collection in $page.props.sharedCollections"
        :key="collection.hashid"
        :href="route('c.show', collection.hashid)"
        :active="route().current('c.show', collection.hashid)"
        icon="medium/clipboard"
      >
        {{ collection.name }}
      </IndexLink>
    </template>
  </div>
</template>

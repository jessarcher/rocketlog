<template>
    <journal-layout>
        <div class="space-y-12">
            <div v-for="month in months" :key="month.name">
                <h2 class="pb-3 font-bold border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                    {{ month.name }}
                </h2>
                <new-bullet :placeholder="`What would you like to get done in ${month.name}?`" />
            </div>
        </div>

        <!-- <subscription-prompt-modal :show="showingSubscriptionPrompt" @close="showingSubscriptionPrompt = false" /> -->
    </journal-layout>
</template>

<script>
import JournalLayout from '@/Layouts/JournalLayout'
import NewBullet from '@/Components/NewBullet'

export default {
    components: {
        JournalLayout,
        NewBullet,
    },

    computed: {
        months() {
            return Array.from(Array(6).keys()).map((value, index) => {
                let month = this.$date().startOf('month').add(index + 1, 'month');
                return {
                    name: month.format('MMMM')
                }
            })
        }
    }
}
</script>

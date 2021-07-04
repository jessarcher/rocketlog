<template>
    <journal-layout>
        <div v-if="days.length === 0" class="mb-10 leading-relaxed text-gray-500 dark:text-gray-400">
            <h1 class="text-xl font-semibold text-gray-600 dark:text-gray-300">
                <Icon name="medium/calendar" auto-size class="mr-1 text-gray-500 dark:text-gray-400" />
                Daily Log
            </h1>
            <p class="mt-4">Add the tasks you would like to get done.</p>
            <p class="mt-4">Your daily log only shows six days. Beyond that, tasks fade away, guilt free.</p>
            <p class="mt-4">If something important is about to fade, use the bullet menu to migrate it forward.</p>
            <p class="mt-4">Empty days are ignored, so if you need to step away for a few days, everything will be here when you get back.</p>
            <p class="mt-4">Enter your first task to get started...</p>
        </div>

        <div v-for="(day, i) in daysIncludingToday" :key="day.date" :class="{ 'mt-12': i > 0 }">
            <h2
                class="pb-3 font-bold border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200"
                :class="{
                    'opacity-50': i === 4,
                    'opacity-30': i === 5,
                }"
            >
                {{ $date(day.date).format('ddd, MMM D') }}
            </h2>

            <bullet
                v-for="bullet in day.bullets"
                :key="bullet.id"
                :bullet="bullet"
                :fade="{
                    'opacity-50': i === 4,
                    'opacity-30': i === 5,
                }"
                type="bullet"
                @input="updateBullet"
                @migrate="migrateBullet"
                @migrateTo="migrateBulletTo"
                @delete="deleteBullet"
            >
                <template #tags>
                    <inertia-link
                        v-if="bullet.collection_id"
                        :href="route('c.show', $page.props.collections.find(collection => collection.id === bullet.collection_id).hashid)"
                        title="Appears in collection"
                        class="inline-block lg:px-2 lg:py-1 lg:bg-gray-100 lg:dark:bg-gray-700 rounded text-gray-500 dark:text-gray-500 lg:dark:text-gray-300 text-xs lg:hover:bg-gray-200 lg:dark:hover:bg-gray-600 focus:outline-none lg:focus:bg-gray-200 lg:dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        :class="[
                            bullet.complete ? 'opacity-50' : ''
                        ]"
                    >
                        {{ $page.props.collections.find(collection => collection.id === bullet.collection_id).name }}
                    </inertia-link>
                </template>
            </bullet>

            <new-bullet v-if="i == 0" @input="storeBullet" />
        </div>

        <subscription-prompt-modal :show="showingSubscriptionPrompt" @close="showingSubscriptionPrompt = false" />
    </journal-layout>
</template>

<script>
    import JournalLayout from '@/Layouts/JournalLayout'
    import Bullet from '@/Components/Bullet'
    import NewBullet from '@/Components/NewBullet'
    import SubscriptionPromptModal from '@/Components/SubscriptionPromptModal'
    import Icon from '@/Components/Icon'

    export default {
        components: {
            Bullet,
            JournalLayout,
            NewBullet,
            SubscriptionPromptModal,
            Icon,
        },

        props: ['days'],

        data() {
            return {
                today: this.$today(),
                showingSubscriptionPrompt: false,
            }
        },

        computed: {
            daysIncludingToday() {
                if (this.days.length > 0 && ! this.today.isAfter(this.$date(this.days[0].date))) {
                    return this.days
                }

                return [
                    { date: this.today.format('YYYY-MM-DD'), bullets: [] },
                    ...this.days.slice(0, 5)
                ]
            }
        },

        mounted() {
            const todayInterval = setInterval(() => {
                if (! this.today.isSame(this.$today())) {
                    this.today = this.$today()
                }
            }, 1000)

            this.$once('hook:destroyed', () => clearInterval(todayInterval))
        },

        methods: {
            async storeBullet(bullet) {
                await this.$inertia.post(
                    route('daily-log.store'),
                    { ...bullet, date: this.$today().format('YYYY-MM-DD') },
                    { preserveScroll: true }
                )

                if (this.$page.props.showSubscriptionPrompt) {
                    this.showingSubscriptionPrompt = true;
                }
            },

            async updateBullet(bullet) {
                await this.$inertia.patch(
                    route('daily-log.update', bullet.id),
                    bullet,
                    { preserveScroll: true }
                )
            },

            async deleteBullet(bullet) {
                await this.$inertia.delete(
                    route('daily-log.destroy', bullet.id),
                    { preserveScroll: true }
                )
            },

            async migrateBullet(bullet) {
                await this.$inertia.patch(
                    route('daily-log.update', bullet.id),
                    { date: this.$today().format('YYYY-MM-DD') },
                    { preserveScroll: true }
                )
            },

            async migrateBulletTo(bullet, collection) {
                await this.$inertia.put(
                    route('c.bullets.move', collection.hashid),
                    { id: bullet.id },
                    { preserveScroll: true }
                )
            },
        },
    }
</script>

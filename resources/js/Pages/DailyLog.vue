<template>
    <journal-layout>
        <div v-for="(day, i) in daysIncludingToday" :key="day.date" :class="{ 'mt-12': i > 0 }">
            <h2 class="pb-3 font-bold border-b border-gray-200 dark:border-gray-700" :class="[i >= 4 ? 'text-gray-400 dark:text-gray-600' : 'text-gray-800 dark:text-gray-200']">
                {{ $date(day.date).format('ddd, MMM D') }}
            </h2>

            <bullet
                v-for="bullet in day.bullets"
                :key="bullet.id"
                :bullet="bullet"
                :fade="i >= 4"
                type="bullet"
                @input="updateBullet"
                @migrate="migrateBullet"
                @delete="deleteBullet"
            />

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

    export default {
        components: {
            Bullet,
            JournalLayout,
            NewBullet,
            SubscriptionPromptModal,
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
                if (! this.today.isAfter(this.$date(this.days[0].date))) {
                    return this.days
                }

                return [
                    { date: this.today.format('YYYY-MM-DD'), bullets: [] },
                    ...this.days.slice(0, -1)
                ]
            }
        },

        mounted() {
            setInterval(() => {
                this.today = this.$today()
            }, 1000)
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
            }
        },
    }
</script>
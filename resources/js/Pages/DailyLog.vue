<template>
    <journal-layout>
        <ContentUpdateNotification v-if="contentUpdateAvailable" :reloading="reloading" @reload="reload">
            Daily log updated
        </ContentUpdateNotification>

        <div v-if="days.length === 0" class="mb-10 leading-relaxed text-gray-600 dark:text-gray-300">
            <h1 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                <Icon name="medium/calendar" auto-size class="mr-1 text-gray-600 dark:text-gray-400" />
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
                :key="bullet.id + bullet.updated_at"
                :bullet="bullet"
                :fade="{
                    'opacity-50': i === 4,
                    'opacity-30': i === 5,
                }"
                type="bullet"
                :enable-migrate-forward="true"
                @input="updateBullet"
                @migrate="migrateBullet"
                @migrateTo="migrateBulletTo"
                @delete="deleteBullet"
            >
                <template #tags>
                    <Link
                        v-if="bullet.collection_id"
                        :href="route('c.show', $page.props.collections.find(collection => collection.id === bullet.collection_id).hashid)"
                        title="Appears in collection"
                        class="inline-block lg:px-2 lg:py-1 lg:bg-gray-100 lg:dark:bg-gray-700 rounded text-gray-500 dark:text-gray-500 lg:dark:text-gray-300 text-xs lg:hover:bg-gray-200 lg:dark:hover:bg-gray-600 focus:outline-none lg:focus:bg-gray-200 lg:dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        :class="[
                            bullet.complete ? 'opacity-50' : ''
                        ]"
                    >
                        {{ $page.props.collections.find(collection => collection.id === bullet.collection_id).name }}
                    </Link>
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
    import ContentUpdateNotification from '@/Components/ContentUpdateNotification'
    import NewBullet from '@/Components/NewBullet'
    import SubscriptionPromptModal from '@/Components/SubscriptionPromptModal'
    import Icon from '@/Components/Icon'
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        components: {
            Bullet,
            ContentUpdateNotification,
            JournalLayout,
            Link,
            NewBullet,
            SubscriptionPromptModal,
            Icon,
        },

        props: ['days'],

        data() {
            return {
                today: this.$today(),
                showingSubscriptionPrompt: false,
                contentUpdateAvailable: false,
                reloading: false,
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
            this.setToday()
            this.listenForUpdates()
            this.reloadWhenHiddenIfContentAvailable()
        },

        methods: {
            setToday() {
                const todayInterval = setInterval(() => {
                    if (! this.today.isSame(this.$today())) {
                        this.today = this.$today()
                    }
                }, 1000)

                this.$once('hook:destroyed', () => clearInterval(todayInterval))
            },

            listenForUpdates() {
                window.Echo
                    .private(`user.${this.$page.props.user.id}`)
                    .listen('DailyLogUpdated', (e) => {
                        if (document.visibilityState === 'hidden' || !document.hasFocus()) {
                            this.reload()
                        } else {
                            this.contentUpdateAvailable = true
                        }
                    })

                window.Echo.connector.pusher.connection.bind('reconnected', () => this.reload());

                this.$once('hook:destroyed', () => {
                    window.Echo.leave(`user.${this.$page.props.user.id}`)
                    window.Echo.connector.pusher.connection.unbind('reconnected')
                })
            },

            reloadWhenHiddenIfContentAvailable() {
                const handler = (e) => {
                    if (document.visibilityState === 'hidden' && this.contentUpdateAvailable) {
                        this.reload()
                    }
                }

                document.addEventListener('visibilitychange', handler)

                this.$once('hook:destroyed', () => document.removeEventListener('visibilitychange', handler))
            },

            storeBullet(bullet) {
                return new Promise((resolve, reject) => {
                    this.$inertia.post(
                        route('daily-log.store'),
                        { ...bullet, date: this.$today().format('YYYY-MM-DD') },
                        {
                            preserveScroll: true,
                            headers: { 'X-Socket-ID': Echo.socketId() },
                            onSuccess: () => {
                                if (this.$page.props.showSubscriptionPrompt) {
                                    this.showingSubscriptionPrompt = true
                                }
                                resolve()
                            },
                            onError: () => reject(),
                        }
                    )
                })
            },

            updateBullet(bullet) {
                this.$inertia.patch(
                    route('daily-log.update', bullet.id),
                    bullet,
                    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
                )
            },

            deleteBullet(bullet) {
                this.$inertia.delete(
                    route('daily-log.destroy', bullet.id),
                    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
                )
            },

            migrateBullet(bullet) {
                this.$inertia.patch(
                    route('daily-log.update', bullet.id),
                    { date: this.$today().format('YYYY-MM-DD') },
                    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
                )
            },

            migrateBulletTo(bullet, collection) {
                this.$inertia.put(
                    route('c.bullets.move', collection.hashid),
                    { id: bullet.id },
                    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
                )
            },

            reload() {
                this.reloading = true;

                this.$inertia.reload({
                    only: ['days'],
                    onFinish: () => {
                        this.contentUpdateAvailable = false
                        this.$nextTick(() => this.reloading = false)
                    },
                    headers: { 'X-Socket-ID': Echo.socketId() },
                })
            },
        },
    }
</script>

<script setup>
import JournalLayout from '@/Layouts/JournalLayout.vue'
import Bullet from '@/Components/Bullet.vue'
import ContentUpdateNotification from '@/Components/ContentUpdateNotification.vue'
import NewBullet from '@/Components/NewBullet.vue'
import SubscriptionPromptModal from '@/Components/SubscriptionPromptModal.vue'
import Icon from '@/Components/Icon.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { computed, nextTick, onMounted, onUnmounted, ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import dayjs from 'dayjs'

const props = defineProps(['days'])

const today = ref(dayjs().startOf('day'))
const showingSubscriptionPrompt = ref(false)
const contentUpdateAvailable = ref(false)
const reloading = ref(false)

const daysIncludingToday = computed(() => {
    if (props.days.length > 0 && ! today.value.isAfter(dayjs(props.days[0].date))) {
        return props.days
    }

    return [
        { date: today.value.format('YYYY-MM-DD'), bullets: [] },
        ...props.days.slice(0, 5)
    ]
})

onMounted(() => {
    setToday()
    listenForUpdates()
    reloadWhenHiddenIfContentAvailable()
})

const setToday = () => {
    const todayInterval = setInterval(() => {
        if (! today.value.isSame(dayjs().startOf('day'))) {
            today.value = dayjs().startOf('day')
        }
    }, 1000)

    onUnmounted(() => clearInterval(todayInterval))
}

const listenForUpdates = () => {
    const userId = usePage().props.value.user.id
    window.Echo
        .private(`user.${userId}`)
        .listen('DailyLogUpdated', (e) => {
            if (document.visibilityState === 'hidden' || !document.hasFocus()) {
                reload()
            } else {
                contentUpdateAvailable.value = true
            }
        })

    window.Echo.connector.pusher.connection.bind('reconnected', () => reload())

    onUnmounted(() => {
        window.Echo.leave(`user.${userId}`)
        window.Echo.connector.pusher.connection.unbind('reconnected')
    })
}

const reloadWhenHiddenIfContentAvailable = () => {
    const handler = (e) => {
        if (document.visibilityState === 'hidden' && contentUpdateAvailable.value) {
            reload()
        }
    }

    document.addEventListener('visibilitychange', handler)

    onUnmounted(() => document.removeEventListener('visibilitychange', handler))
}

const storeBullet = (bullet) => new Promise((resolve, reject) => {
    Inertia.post(
        route('daily-log.store'),
        { ...bullet, date: dayjs().startOf('day').format('YYYY-MM-DD') },
        {
            preserveScroll: true,
            headers: { 'X-Socket-ID': Echo.socketId() },
            onSuccess: () => {
                if (props.showSubscriptionPrompt) {
                    showingSubscriptionPrompt.value = true
                }
                resolve()
            },
            onError: () => reject(),
        }
    )
})

const updateBullet = (bullet) => Inertia.patch(
    route('daily-log.update', bullet.id),
    bullet,
    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
)

const deleteBullet = (bullet) => Inertia.delete(
    route('daily-log.destroy', bullet.id),
    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
)

const migrateBullet = (bullet) => Inertia.patch(
    route('daily-log.update', bullet.id),
    { date: dayjs().startOf('day').format('YYYY-MM-DD') },
    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
)

const migrateBulletTo = (bullet, collection) => Inertia.put(
    route('c.bullets.move', collection.hashid),
    { id: bullet.id },
    { preserveScroll: true, headers: { 'X-Socket-ID': Echo.socketId() } }
)

const reload = () => {
    reloading.value = true

    Inertia.reload({
        only: ['days'],
        onFinish: () => {
            contentUpdateAvailable.value = false
            nextTick(() => reloading.value = false)
        },
        headers: { 'X-Socket-ID': Echo.socketId() },
    })
}
</script>

<template>
    <JournalLayout>
        <ContentUpdateNotification v-if="contentUpdateAvailable" :reloading="reloading" @reload="reload">
            Daily log updated
        </ContentUpdateNotification>

        <div v-if="days.length === 0" class="mb-10 leading-relaxed text-gray-600 dark:text-gray-300">
            <h1 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                <Icon name="medium/calendar" autosize class="mr-1 text-gray-600 dark:text-gray-400" />
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
                {{ dayjs(day.date).format('ddd, MMM D') }}
            </h2>

            <Bullet
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
            </Bullet>

            <NewBullet v-if="i == 0" @input="storeBullet" />
        </div>

        <SubscriptionPromptModal :show="showingSubscriptionPrompt" @close="showingSubscriptionPrompt = false" />
    </JournalLayout>
</template>

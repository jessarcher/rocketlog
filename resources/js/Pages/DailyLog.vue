<template>
    <journal-layout>
        <div :class="{'opacity-50': saving}">
            <div v-for="(day, i) in days" :key="day.date" :class="{ 'mt-12': i > 0 }">
                <h2 class="pb-3 font-bold border-b border-gray-200" :class="[i >= 5 ? 'text-gray-300' : 'text-gray-800']">
                    {{ date(day.date).format('ddd, MMM D') }}
                </h2>

                <bullet
                    v-for="bullet in day.bullets"
                    :key="bullet.id"
                    :bullet="bullet"
                    :fade="i >= 5"
                    type="bullet"
                    @input="updateBullet"
                    @delete="deleteBullet"
                />

                <new-bullet v-if="i == 0" @input="storeBullet" />
            </div>
        </div>
    </journal-layout>
</template>

<script>
    import JournalLayout from '@/Layouts/JournalLayout'
    import Bullet from '@/Components/Bullet'
    import NewBullet from '@/Components/NewBullet'

    export default {
        components: {
            Bullet,
            JournalLayout,
            NewBullet,
        },

        props: ['days'],

        data() {
            return {
                test: 'test1',
                saving: false,
            }
        },

        methods: {
            async storeBullet(bullet) {
                await this.$inertia.post(
                    route('daily-log.store'),
                    bullet,
                    { preserveScroll: true }
                )
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
                    { date: this.date() },
                    { preserveScroll: true }
                )
            }
        },
    }
</script>

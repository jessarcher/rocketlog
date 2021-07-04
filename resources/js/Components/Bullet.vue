<template>
    <div>
        <div class="py-1 md:py-2 flex">
            <div class="relative flex-shrink-0" :class="$slots.tags ? 'pt-3 lg:pt-0' : ''">
                <template v-if="type === 'bullet'">
                    <div class="border border-transparent" :class="fade">
                        <button
                            class="relative h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-2xl disabled:opacity-50"
                            :class="[
                                complete ? 'text-gray-500 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100',
                                processing ? 'cursor-default' : 'hover:border-gray-200 dark:hover:border-gray-600 hover:shadow focus:outline-none focus:border-gray-200 dark:focus:border-gray-600 focus:shadow-inner'
                            ]"
                            @click="menu = true"
                            :disabled="processing"
                        >
                            <div v-show="processing" class="absolute inset-0 border border-transparent flex items-center justify-center">
                                <Icon name="medium/spinner" class="h-10 w-10 md:h-8 md:w-8 animate-spin text-gray-400" />
                            </div>
                            <Icon name="small/bullet" v-show="state === 'incomplete'" class="h-6 w-6 md:h-5 md:w-5" />
                            <Icon name="small/x" v-show="state === 'complete'" class="h-6 w-6 md:h-5 md:w-5" />
                        </button>
                    </div>

                    <div v-show="menu" class="fixed inset-0 z-40" @click="menu = false; showingMigration = false">
                    </div>

                    <transition
                        enter-active-class="transition ease-out duration-200"
                        enter-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <div
                            v-show="menu"
                            class="absolute top-0 left-0 -ml-2 rounded-2xl text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-500 bg-white dark:bg-gray-700 shadow-xl z-50 overflow-hidden"
                            @blur="menu = false; showingMigration = false"
                            @xclick="menu = false; showingMigration = false"
                        >
                            <div class="px-2 flex items-center text-2xl">
                                <button class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none" @click="menu = false; showingMigration = false">
                                    <Icon name="small/x" v-if="state === 'complete'" class="h-6 w-6 md:h-5" />
                                    <Icon name="small/bullet" v-if="state === 'incomplete'" class="h-6 w-6 md:h-5" />
                                </button>

                                <button v-if="state !== 'incomplete'" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none" @click="state = 'incomplete'; menu = false" title="Mark as incomplete">
                                    <Icon name="small/bullet" class="w-6 h-6 md:w-5 md:h-5" />
                                </button>

                                <button v-else-if="state !== 'complete'" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none" @click="state = 'complete'; menu = false" title="Mark as complete">
                                    <Icon name="small/x" class="w-6 h-6 md:w-5 md:h-5" />
                                </button>

                                <button v-if="enableMigrateForward && bullet.date && $date(bullet.date).isBefore($today())" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none" @click="migrate(); menu = false" title="Migrate forward">
                                    <Icon name="small/chevron-up" class="h-6 w-6 md:h-5 md:w-5" />
                                </button>

                                <button class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none" @click="showingMigration = ! showingMigration" title="Migrate to collection">
                                    <Icon name="small/chevron-right" class="h-6 w-6 md:h-5 md:w-5" />
                                </button>

                                <button
                                    v-if="bullet.collection_id !== null"
                                    class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center"
                                    :class="[
                                        bullet.date && mine ? 'text-pink-600' : '',
                                        mine ? 'hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none' : 'text-gray-600 cursor-pointer',
                                    ]"
                                    :disabled="! mine"
                                    @click="toggleInDailyLog(); menu = false"
                                    :title="mine ? (bullet.date ? 'Hide in daily log' : 'Show in daily log') : 'Unable to show in daily log'"
                                >
                                    <Icon name="medium/calendar" class="h-6 w-6 md:h-5 md:w-5" />
                                </button>

                                <button class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none" @click="destroy(); menu = false" title="Delete">
                                    <Icon name="small/trash" class="h-6 w-6 md:w-5 md:h-5" />
                                </button>
                            </div>

                            <div v-if="showingMigration" class="pb-1 border-t border-gray-200 dark:border-gray-600">
                                <div v-if="$page.props.collections.length === 0" class="px-4 py-1 leading-loose text-gray-500 whitespace-nowrap">No collections available</div>
                                <button
                                    v-if="bullet.collection_id !== null"
                                    class="block w-full text-left px-4 py-1 leading-loose font-medium whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-800"
                                    @click="migrateToDailyLog(); menu = false"
                                >
                                    <Icon name="small/chevron-right" class="w-5 h-5" />
                                    Daily Log
                                </button>
                                <template v-for="collection in $page.props.collections">
                                    <button
                                        :key="collection.id"
                                        v-if="collection.id !== bullet.collection_id"
                                        class="block w-full text-left px-4 py-1 leading-loose font-medium whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-800"
                                        @click="migrateTo(collection); menu = false"
                                    >
                                        <Icon name="small/chevron-right" class="w-5 h-5" />
                                        {{ collection.name }}
                                    </button>
                                </template>
                                <template v-for="collection in $page.props.sharedCollections">
                                    <button
                                        :key="collection.id"
                                        v-if="collection.id !== bullet.collection_id"
                                        class="block w-full text-left px-4 py-1 leading-loose font-medium whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-800"
                                        @click="migrateTo(collection); menu = false"
                                    >
                                        <Icon name="small/chevron-right" class="w-5 h-5" />
                                        {{ collection.name }}
                                    </button>
                                </template>
                            </div>
                        </div>
                    </transition>
                </template>

                <template v-else-if="type === 'checklist'">
                    <div class="border border-transparent">
                        <div class="relative h-10 w-10 md:h-8 md:w-8 flex items-center justify-center">
                            <div v-show="processing" class="absolute inset-0 border border-transparent flex items-center justify-center">
                                <Icon name="medium/spinner" class="h-10 w-10 md:h-8 md:w-8 animate-spin text-gray-400" />
                            </div>
                            <input
                                type="checkbox"
                                class="relative h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-900"
                                :class="{ 'opacity-0': processing }"
                                v-model="complete"
                                :disabled="processing"
                            />
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex-1 ml-1 lg:flex">
                <div v-if="$slots.tags" class="mt-1 -mb-1 md:mb-0 lg:hidden ml-2 md:ml-1 lg:flex-shrink-0">
                    <slot name="tags" />
                </div>
                <div class="lg:flex-1">
                    <textarea
                        ref="name"
                        v-model="name"
                        :disabled="processing"
                        class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 focus:ring-0"
                        :class="[
                            fade,
                            complete ? 'text-gray-500 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100'
                        ]"
                        style="resize: none;"
                        rows="1"
                        maxlength="255"
                        @keydown.enter="
                            if (! $event.shiftKey && $event.target.value.length) {
                                $event.preventDefault()
                                save()
                            }
                        "
                        @keydown.up="up"
                        @keydown.down="down"
                        @blur="$event.target.value.length > 0 ? save() : destroy()"
                        spellcheck="false"
                    ></textarea>
                </div>
                <div v-if="$slots.tags" class="hidden lg:block -mt-1 mb-2 lg:mb-0 ml-2 md:ml-1 lg:mt-1 lg:flex-shrink-0">
                    <slot name="tags" />
                </div>
            </div>
            <div class="flex-shrink-0">
                <slot name="status" />
            </div>
        </div>

        <div class="border-b border-gray-200 dark:border-gray-700" :class="fade"></div>
    </div>
</template>

<script>
import autosize from 'autosize'
import Icon from '@/Components/Icon'

export default {
    components: {
        Icon,
    },

    props: [
        'bullet',
        'type',
        'props',
        'fade',
        'enableMigrateForward',
    ],

    data() {
        return {
            dirty: false,
            processing: false,
            name: this.bullet.name,
            state: this.bullet.state,
            menu: false,
            showingMigration: false,
        }
    },

    computed: {
        complete: {
            get() {
                return this.state === 'complete'
            },
            set(newValue) {
                this.state = newValue ? 'complete' : 'incomplete'
            }
        },

        mine() {
            return this.bullet.user_id === this.$page.props.user.id
        },
    },

    watch: {
        async state(state) {
            this.processing = true;
            await this.$listeners.input({ id: this.bullet.id, state })
            this.processing = false;
        },

        name() {
            this.dirty = true;
        }
    },

    mounted() {
        autosize(this.$refs.name)
    },

    methods: {
        async save() {
            if (!this.dirty) {
                return;
            }

            this.processing = true;

            await this.$listeners.input({ id: this.bullet.id, name: this.name })

            this.processing = false;
            this.dirty = false;
        },

        async toggleInDailyLog() {
            if (this.bullet.collection_id === null) {
                return;
            }

            this.processing = true;

            await this.$listeners.input({ id: this.bullet.id, date: this.bullet.date ? null : this.$today().format('YYYY-MM-DD') })

            this.processing = false;
        },

        async migrate() {
            this.processing = true;

            await this.$listeners.migrate(this.bullet)

            this.processing = false;
        },

        async migrateTo(collection) {
            this.processing = true;

            await this.$listeners.migrateTo(this.bullet, collection)

            this.processing = false;
        },

        async migrateToDailyLog() {
            this.processing = true;

            await this.$listeners.migrateToDailyLog(this.bullet)

            this.processing = false;
        },

        async destroy() {
            this.processing = true;

            await this.$listeners.delete(this.bullet)

            this.processing = false;
        },

        up() {
            if (this.$refs.name.selectionStart === 0 && this.$refs.name.selectionStart === 0) {
                this.$emit('up')
            }
        },

        down() {
            if (this.$refs.name.selectionStart === this.$refs.name.value.length && this.$refs.name.selectionStart === this.$refs.name.value.length) {
                this.$emit('down')
            }
        },

        focus() {
            this.$refs.name.focus()
        },
    },
}
</script>

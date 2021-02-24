<template>
    <div class="py-1 md:py-2 border-b border-gray-200 flex">
        <div class="relative flex-shrink-0">
            <template v-if="type === 'bullet'">
                <div class="border border-transparent" :class="state === 'complete' || fade ? 'opacity-50' : ''">
                    <button
                        class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent hover:border-gray-200 hover:shadow focus:outline-none focus:border-gray-200 focus:shadow-inner disabled:opacity-50"
                        @click="menu = true"
                        :disabled="processing"
                    >
                        <incomplete-icon v-show="state === 'incomplete'" class="h-6 w-6 md:h-5" />
                        <complete-icon v-show="state === 'complete'" class="h-6 w-6 md:h-5" />
                    </button>
                </div>

                <div v-if="menu" class="fixed inset-0 z-40" @click="menu = false">
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
                        v-if="menu"
                        class="absolute top-0 left-0 -ml-2 inline-flex px-2 rounded-full border border-gray-200 bg-white shadow-xl text-gray-700 z-50 overflow-hidden"
                        @blur="menu = false"
                        @click="menu = false"
                    >
                        <button class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center focus:bg-gray-100 focus:outline-none" @click="menu = false">
                            <complete-icon v-if="state === 'complete'" class="h-6 w-6 md:h-5" />
                            <incomplete-icon v-if="state === 'incomplete'" class="h-6 w-6 md:h-5" />
                        </button>

                        <button v-if="state !== 'incomplete'" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 focus:bg-gray-100 focus:outline-none" @click="state = 'incomplete'">
                            <incomplete-icon class="w-6 h-6 md:w-5 md:h-5" />
                        </button>

                        <button v-else-if="state !== 'complete'" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 focus:bg-gray-100 focus:outline-none" @click="state = 'complete'">
                            <complete-icon class="w-6 h-6 md:w-5 md:h-5" />
                        </button>

                        <button v-if="bullet.collection_id === null && $date(bullet.date).isBefore($today())" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 focus:bg-gray-100 focus:outline-none" @click="migrate">
                            <migrate-icon class="w-6 h-6 md:w-5 md:h-5" />
                        </button>

                        <button class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 focus:bg-gray-100 focus:outline-none" @click="destroy">
                            <trash-icon class="h-6 w-6 md:w-5 md:h-5 text-gray-500" />
                        </button>
                    </div>
                </transition>
            </template>

            <template v-else-if="type === 'checklist'">
                <div class="border border-transparent">
                    <div class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center">
                        <input
                            type="checkbox"
                            class="h-5 w-5 rounded border-gray-300"
                            v-model="complete"
                        />
                    </div>
                </div>
            </template>
        </div>

        <div class="w-full mx-1">
            <div :class="state === 'complete' || fade ? 'opacity-50' : ''">
                <textarea
                    ref="name"
                    v-model="name"
                    :disabled="processing"
                    class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75"
                    style="resize: none;"
                    rows="1"
                    @keydown.enter="
                        if (! $event.shiftKey && $event.target.value.length) {
                            $event.preventDefault()
                            save()
                        }
                    "
                    @keydown.up="up"
                    @keydown.down="down"
                    @blur="$event.target.value.length > 0 ? save() : destroy()"
                ></textarea>
            </div>
        </div>

        <div class="w-10 h-10 md:w-8 md:h-8 border border-transparent flex items-center justify-center">
            <svg v-if="processing" class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</template>

<script>
import autosize from 'autosize'
import CompleteIcon from './Icons/CompleteIcon'
import IncompleteIcon from './Icons/IncompleteIcon'
import MigrateIcon from './Icons/MigrateIcon'
import TrashIcon from './Icons/TrashIcon'

export default {
    components: {
        IncompleteIcon,
        CompleteIcon,
        MigrateIcon,
        TrashIcon,
    },

    props: [
        'bullet',
        'type',
        'props',
        'fade',
    ],

    data() {
        return {
            dirty: false,
            processing: false,
            name: this.bullet.name,
            state: this.bullet.state,
            menu: false,
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
        }
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

        async migrate() {
            this.processing = true;

            await this.$listeners.migrate(this.bullet)

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

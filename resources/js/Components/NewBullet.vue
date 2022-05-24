<template>
    <form
        @submit.prevent="create"
        class="py-1 md:py-2 border-b border-gray-200 dark:border-gray-700 flex"
    >
        <div class="border border-transparent flex-shrink-0">
            <div class="relative h-10 w-10 md:h-8 md:w-8 flex items-center justify-center">
                <div v-show="creating" class="absolute inset-0 border border-transparent flex items-center justify-center">
                    <Icon name="medium/spinner" class="h-10 w-10 md:h-8 md:w-8 animate-spin text-gray-400" />
                </div>
                <icon name="small/bullet" class="h-5 w-5 text-gray-200 dark:text-gray-700" />
            </div>
        </div>

        <div class="flex-1">
            <textarea
                v-model="name"
                ref="name"
                :disabled="creating"
                class="w-full p-2 md:p-1 text-gray-900 dark:text-gray-100 overflow-hidden bg-transparent border-none disabled:opacity-50 placeholder-gray-300 dark:placeholder-gray-600 focus:ring-0"
                style="resize: none; height: 1em;"
                rows="1"
                maxlength="255"
                :placeholder="placeholder"
                @keydown.up="up"
                @keydown.down="down"
                @keydown.enter.exact.prevent="create"
                @blur="create"
            ></textarea>
        </div>
    </form>
</template>

<script>
import autosize from 'autosize'
import Icon from '@/Components/Icon'

export default {
    components: {
        Icon,
    },

    props: {
        placeholder: {
            type: String,
            default: 'Unburden your mind...',
        },
    },

    data() {
        return {
            creating: false,
            name: '',
        }
    },

    mounted() {
        autosize(this.$refs.name)
    },

    methods: {
        async create(event) {
            if (event.target.value.trim() === '' || this.creating) {
                return
            }

            this.creating = true;

            await this.$listeners.input({ name: this.name })

            this.name = '';
            this.creating = false;

            this.$nextTick(() => {
                autosize.update(this.$refs.name)
                this.$refs.name.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
            })
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

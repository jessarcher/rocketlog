<template>
    <form
        @submit.prevent="create"
        class="py-1 md:py-2 border-b border-gray-200 flex"
        x-init="autosize($refs.name)"
        x-ref="form"
    >
        <div class="border border-transparent flex-shrink-0">
            <div class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center">
                <incomplete-icon class="h-5 w-5 text-gray-200" />
            </div>
        </div>

        <div class="w-full mx-1">
            <textarea
                v-model="name"
                ref="name"
                :disabled="creating"
                class="w-full p-2 md:p-1 text-gray-900 overflow-hidden bg-transparent border-none disabled:opacity-50 placeholder-gray-300"
                style="resize: none; height: 1em;"
                rows="1"
                placeholder="Unburden your mind..."
                @keydown.enter="
                    if (! $event.shiftKey && $event.target.value.length) {
                        $event.preventDefault()
                        create()
                    }
                "
                @blur="
                    if ($event.target.value.length) {
                        create()
                    }
                "
            ></textarea>
        </div>

        <div class="w-10 h-10 md:w-8 md:h-8 border border-transparent flex items-center justify-center">
            <svg v-show="creating" class="animate-spin h-6 w-6 md:h-5 md:w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </form>
</template>

<script>
import autosize from 'autosize'
import IncompleteIcon from '@/Components/Icons/IncompleteIcon'

export default {
    components: {
        IncompleteIcon,
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
        async create() {
            this.creating = true;

            await this.$listeners.input({ name: this.name })

            this.name = '';
            this.creating = false;

            this.$nextTick(() => {
                autosize.update(this.$refs.name)
                this.$refs.name.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
            })
        },
    },
}
</script>

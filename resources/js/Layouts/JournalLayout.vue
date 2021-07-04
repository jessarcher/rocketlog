<template>
    <app-layout>
        <transition
            leave-active-class="transition ease-out duration-200"
            leave-class="transform opacity-100"
            leave-to-class="transform opacity-0"
        >
            <div v-if="showingWelcome" class="mb-4 md:mb-0 mt-4 md:mt-10 max-w-7xl w-full mx-auto px-4 sm:px-6">
                <div class="p-4 lg:p-6 rounded-lg bg-cover bg-bottom" style="background-image: url('/images/space.jpg')">
                    <div>
                        <h2 class="inline-block p-4 lg:p-6 bg-white dark:bg-gray-800 text-gray-800 dark:text-white font-bold text-lg md:text-xl shadow-xl">Welcome to RocketLog, <span class="whitespace-nowrap">fellow traveller 👋</span></h2>
                    </div>
                    <div class="mt-6">
                        <div class="inline-block max-w-4xl p-4 lg:p-6 bg-white dark:bg-gray-800 text-gray-800 dark:text-white text-base md:text-lg shadow-xl space-y-4">
                            <p>To get the most out of RocketLog, it's best to understand the practice of bullet journalling that inspired this app. Learn at <a href="https://bulletjournal.com/pages/learn" target="_blank" rel="noopener noreferer" class="font-medium underline">bulletjournal.com/pages/learn</a>.</p>
                            <p>Being digital, things do work a little differently here, but either way you'll have a set of tools to get your todo list under control.</p>
                            <JetButton type="button" @click.native="dismissWelcome">Okay</JetButton>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div class="md:py-12 flex-1 flex flex-col">
            <div class="flex-1 max-w-7xl w-full mx-auto md:px-6 flex flex-col md:flex-row-reverse">
                <aside class="hidden md:block md:ml-12 md:pt-12 lg:w-80">
                    <index />
                </aside>

                <div class="flex-1 p-4 sm:p-6 md:p-12 bg-white dark:bg-gray-800 sm:rounded-lg md:shadow-xl">
                    <slot></slot>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './AppLayout'
    import JetButton from '@/Jetstream/Button'
    import Index from '@/Components/Index'

    export default {
        components: {
            AppLayout,
            JetButton,
            Index,
        },

        data() {
            return {
                showingWelcome: ! this.$page.props.user.preferences?.dismissed_welcome,
            }
        },

        methods: {
            dismissWelcome() {
                this.showingWelcome = false;

                axios.patch(
                    route('user-preferences.update'),
                    { dismissed_welcome: true },
                    { preserveScroll: true }
                );
            }
        }
    }
</script>

<template>
    <jet-dialog-modal :show="show" @close="$emit('close')">
        <template #content>
            <div class="sm:flex">
                <img src="/images/jess-archer.jpg" class="h-14 w-14 rounded-full" />
                <div class="mt-4 sm:mt-0 sm:ml-4">
                    <p class=""><strong>Hey there, {{ $page.props.user.name }}!</strong></p>
                    <p class="mt-4">I'm here if you need any help or have any ideas for making RocketLog even better.</p>
                    <p class="mt-4">Please send an email to <a class="font-medium underline" href="mailto:jess@jessarcher.com">jess@jessarcher.com</a> or tweet me <a class="font-medium underline" href="https://twitter.com/rocketlogapp" target="_blank">@rocketlogapp</a> and I'll get you sorted.</p>
                    <p class="mt-4">Alternatively, if you're on GitHub, feel free to create a <a class="font-medium underline" href="https://github.com/jessarcher/rocketlog/discussions" target="_blank">discussion</a>, <a class="font-medium underline" href="https://github.com/jessarcher/rocketlog/issues" target="_blank">issue</a>, or even a <a class="font-medium underline" href="https://github.com/jessarcher/rocketlog/pulls" target="_blank">pull request</a>!</p>
                    <p class="mt-4">Jess.</p>
                </div>
            </div>
        </template>
        <template #footer>
            <jet-secondary-button @click.native="$emit('close')">
                Close
            </jet-secondary-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
export default {
    components: {
        JetDialogModal,
        JetButton,
        JetSecondaryButton,
    },
    props: ['show'],
}
</script>

<template>
    <journal-layout>
        <div class="flex flex-col">
            <div class="-mt-3 flex items-center justify-between border-b border-gray-200">
                <input
                    type="text"
                    v-model.lazy="name"
                    class="flex-1 px-0 py-3 text-gray-800 font-bold border-none"
                />

                <div class="-mr-2 flex gap-2 text-gray-400">
                    <button
                        type="button"
                        @click="hideDone = ! hideDone"
                        class="p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                        :class="hideDone ? 'text-gray-400 hover:text-gray-500 focus:text-gray-500' : 'text-purple-600 hover:text-purple-700 focus:text-purple-700'"
                        title="Show done"
                    >
                        <clipboard-check-icon class="w-6 h-6 md:w-5 md:h-5" />
                    </button>

                    <button
                        type="button"
                        @click="drawer = drawer === 'share' ? '' : 'share'"
                        class="p-2 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        :class="drawer === 'share' ? 'bg-gray-100 text-gray-500' : 'text-gray-400'"
                    >
                        <share-icon class="w-6 h-6 md:w-5 md:h-5" />
                    </button>

                    <button
                        type="button"
                        @click="drawer = drawer === 'settings' ? '' : 'settings'"
                        class="p-2 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        :class="drawer === 'settings' ? 'bg-gray-100 text-gray-500' : 'text-gray-400'"
                    >
                        <adjustments-icon class="w-6 h-6 md:w-5 md:h-5" />
                    </button>
                </div>
            </div>

            <div
                v-show="drawer"
                class="-mx-12 px-12 py-6 bg-gray-100 shadow-inner"
            >
                <div v-show="drawer === 'settings'" class="flex items-center justify-between flex-wrap gap-x-20 gap-y-6">
                    <div class="flex flex-wrap gap-x-4 gap-y-4">
                        <div class="flex">
                            <label class="flex items-center">
                                <input type="radio" v-model="type" name="type" value="bullet" class="h-5 w-5 border-gray-400 text-purple-700">
                                <span class="ml-2 font-semibold text-gray-700">Bullets</span>
                            </label>
                            <label class="ml-4 flex items-center">
                                <input type="radio" v-model="type" name="type" value="checklist" class="h-5 w-5 border-gray-400 text-purple-700">
                                <span class="ml-2 font-semibold text-gray-700">Checklist</span>
                            </label>
                        </div>
                    </div>

                    <div class="-mx-2 flex flex-wrap gap-x-2 gap-y-2">
                        <button
                            class="px-2 py-1 inline-flex items-center font-semibold text-gray-600 rounded-md whitespace-no-wrap hover:bg-gray-200 hover:text-gray-800 focus:outline-none focus:bg-gray-200 focus:text-gray-800"
                            @click="confirmingClearDone = true"
                        >
                            <svg class="mr-1 text-gray-500" style="height: 1em; width: 1em;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Clear Done
                        </button>

                        <button
                            class="px-2 py-1 inline-flex items-center font-semibold text-gray-600 rounded-md whitespace-no-wrap hover:bg-gray-200 hover:text-gray-800 focus:outline-none focus:bg-gray-200 focus:text-gray-800"
                            @click="confirmingDeleteCollection = true"
                        >
                            <svg class="mr-1 text-gray-500" style="height: 1em; width: 1em;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Collection
                        </button>
                    </div>
                </div>

                <div v-show="drawer === 'share'" class="grid gap-6">
                    <div v-if="collection.users.length > 0" class="p-6 space-y-6 border border-gray-300 rounded">
                        <div v-for="user in collection.users" :key="user.id" class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" :src="user.profile_photo_url" :alt="user.name">
                                <div class="ml-4">{{ user.name }}</div>
                            </div>

                            <div class="flex items-center">
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" @click="confirmUserRemoval(user)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="addUserForm.post(route('c.users.store', collection.hashid))">
                        <h3 class="text-gray-800">
                            Add a new collaborator, allowing them to view and edit this collection.
                        </h3>

                        <div class="mt-2 max-w-xl text-sm text-gray-600">
                            Please provide the email address of the person you would like to add to this collection. The email address must be associated with an existing account.
                        </div>

                        <label for="email" class="mt-4 block font-semibold text-gray-600">Email</label>

                        <div class="mt-1 flex flex-wrap justify-end gap-4">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="flex-1 block border-gray-300 rounded"
                                v-model="addUserForm.email"
                            />

                            <button
                                type="submit"
                                class="px-4 py-2 flex items-center border border-gray-300 rounded font-medium"
                                :disabled="addUserForm.processing"
                            >
                                <user-add-icon class="mr-1 text-gray-400" style="height: 1em; width: 1em;" />
                                Add
                            </button>
                        </div>

                        <jet-input-error for="email" :message="addUserForm.errors.email" class="mt-2" />
                    </form>
                </div>
            </div>
        </div>

        <div>
            <bullet
                v-for="bullet in collection.bullets"
                v-show="! bullet.complete || ! hideDone"
                :key="bullet.id"
                :bullet="bullet"
                :type="type"
                @input="updateBullet"
                @delete="deleteBullet"
            />
        </div>

        <new-bullet @input="storeBullet" />

        <jet-confirmation-modal :show="confirmingClearDone" @close="confirmingClearDone = false">
            <template #title>
                Clear Done
            </template>
            <template #content>
                Are you sure you want to clear all complete items?
            </template>
            <template #footer>
                <jet-secondary-button @click.native="confirmingClearDone = false">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="clearDone" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Clear Done
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <jet-confirmation-modal :show="confirmingDeleteCollection" @close="confirmingDeleteCollection = false">
            <template #title>
                Delete Collection
            </template>
            <template #content>
                Are you sure you want to delete this collection?
            </template>
            <template #footer>
                <jet-secondary-button @click.native="confirmingDeleteCollection = false">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteCollection" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Delete Collection
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <jet-confirmation-modal :show="userBeingRemoved" @close="userBeingRemoved = null">
            <template #title>
                Remove User
            </template>
            <template #content>
                Are you sure you want to remove this user?
            </template>
            <template #footer>
                <jet-secondary-button @click.native="userBeingRemoved = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="removeUser" :class="{ 'opacity-25': removeUserForm.processing }" :disabled="removeUserForm.processing">
                    Remove User
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </journal-layout>
</template>

<script>
import JournalLayout from '@/Layouts/JournalLayout'
import Bullet from '@/Components/Bullet'
import NewBullet from '@/Components/NewBullet'
import ClipboardCheckIcon from '@/Components/Icons/ClipboardCheckIcon'
import UserAddIcon from '@/Components/Icons/UserAddIcon'
import ShareIcon from '@/Components/Icons/ShareIcon'
import AdjustmentsIcon from '@/Components/Icons/AdjustmentsIcon'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetInputError from '@/Jetstream/InputError'

export default {
    components: {
        Bullet,
        JournalLayout,
        NewBullet,
        ClipboardCheckIcon,
        UserAddIcon,
        ShareIcon,
        AdjustmentsIcon,
        JetConfirmationModal,
        JetSecondaryButton,
        JetDangerButton,
        JetInputError,
    },

    props: ['collection'],

    data() {
        return {
            processing: false,
            name: this.collection.name,
            type: this.collection.type,
            hideDone: this.collection.hide_done,
            drawer: false,
            confirmingClearDone: false,
            confirmingDeleteCollection: false,

            addUserForm: this.$inertia.form({
                email: '',
            }),

            userBeingRemoved: null,
            removeUserForm: this.$inertia.form(),
        }
    },

    watch: {
        name() {
            this.update()
        },
        type() {
            this.update()
        },
        hideDone() {
            this.update()
        }
    },

    methods: {
        async update() {
            this.$inertia.patch(
                route('c.update', this.collection.hashid),
                {
                    name: this.name,
                    type: this.type,
                    hide_done: this.hideDone,
                },
                { preserveScroll: true }
            )
        },

        async storeBullet(bullet) {
            await this.$inertia.post(
                route('c.bullets.store', this.collection.hashid),
                bullet,
                { preserveScroll: true }
            )
        },

        async updateBullet(bullet) {
            await this.$inertia.patch(
                route('c.bullets.update', [this.collection.hashid, bullet.id]),
                bullet,
                { preserveScroll: true }
            )
        },

        async deleteBullet(bullet) {
            await this.$inertia.delete(
                route('c.bullets.destroy', [this.collection.hashid, bullet.id]),
                { preserveScroll: true }
            )
        },

        async clearDone() {
            this.processing = true
            await this.$inertia.delete(
                route('c.destroy-done', this.collection.hashid),
                { preserveScroll: true }
            )
            this.processing = false
            this.confirmingClearDone = false
        },

        async deleteCollection() {
            this.processing = true
            await this.$inertia.delete(
                route('c.destroy', this.collection.hashid),
                { preserveScroll: true }
            )
            this.processing = false
        },

        async addUser() {
            this.processing = true
            await this.$inertia.post(
                route('c.users.store', this.collection.hashid),
                { email: this.addUserEmail },
                { preserveScroll: true }
            )
            this.processing = false
            this.addUserEmail = ''
        },

        confirmUserRemoval(user) {
            this.userBeingRemoved = user
        },

        removeUser() {
            this.removeUserForm.delete(route('c.users.destroy', [this.collection.hashid, this.userBeingRemoved]), {
                errorBag: 'removeUser',
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => (this.userBeingRemoved = null),
            })
        }
    }
}
</script>

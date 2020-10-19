<div class="flex flex-col">
    <div x-data="{
        drawer: '',
        hideDone: @entangle('collection.hide_done'),
    }">
        <div class="-mt-3 flex items-center justify-between border-b border-gray-200">
            <input
                type="text"
                wire:model.lazy="collection.name"
                class="flex-1 py-3 text-gray-800 font-bold"
                value="{{ $collection->name }}"
            />

            <div class="-mr-2 flex gap-2 text-gray-400">
                <button
                    type="button"
                    @click="drawer = drawer === 'share' ? '' : 'share'"
                    class="p-2 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    :class="drawer === 'share' ? 'bg-gray-100 text-gray-500' : 'text-gray-400'"
                >
                    <x-heroicon-o-share class="w-6 h-6 md:w-5 md:w-5" />
                </button>

                <button
                    type="button"
                    @click="drawer = drawer === 'settings' ? '' : 'settings'"
                    class="p-2 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    :class="drawer === 'settings' ? 'bg-gray-100 text-gray-500' : 'text-gray-400'"
                >
                    <x-heroicon-o-adjustments class="w-6 h-6" />
                </button>
            </div>
        </div>

        <div
            x-cloak
            x-show="drawer"
            class="-mx-12 px-12 py-6 bg-gray-700 shadow-inner text-white"
        >
            <div x-show="drawer === 'settings'" class="flex items-center justify-between flex-wrap gap-x-20 gap-y-6">
                <div class="flex flex-wrap gap-x-4 gap-y-4">
                    <div class="flex">
                        <label class="flex items-center">
                            <input type="radio" wire:model="collection.type" name="type" value="bullet" class="form-radio h-5 w-5 border-gray-500 bg-gray-800 text-purple-700">
                            <span class="ml-2 font-semibold text-gray-300">Bullets</span>
                        </label>
                        <label class="ml-4 flex items-center">
                            <input type="radio" wire:model="collection.type" name="type" value="checklist" class="form-radio h-5 w-5 border-gray-500 bg-gray-800 text-purple-700">
                            <span class="ml-2 font-semibold text-gray-300">Checklist</span>
                        </label>
                    </div>

                    <div class="border-l border-gray-600"></div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="collection.hide_done" value="1" class="form-checkbox h-5 w-5 border-gray-500 bg-gray-800 text-purple-700">
                            <span class="ml-2 font-semibold text-gray-300 whitespace-no-wrap">Hide done</span>
                        </label>
                    </div>
                </div>

                <div class="-mx-2 flex flex-wrap gap-x-2 gap-y-2">
                    <button
                        class="px-2 py-1 inline-flex items-center font-semibold text-gray-300 rounded-md whitespace-no-wrap hover:bg-gray-600 hover:text-gray-200 focus:outline-none focus:bg-gray-600 focus:text-gray-200"
                        wire:click="$toggle('confirmingClearDone')"
                    >
                        <svg class="mr-1 text-gray-400" style="height: 1em; width: 1em;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Clear Done
                    </button>

                    <div class="border-l border-gray-600"></div>

                    <button
                        class="px-2 py-1 inline-flex items-center font-semibold text-gray-300 rounded-md whitespace-no-wrap hover:bg-gray-600 hover:text-gray-200 focus:outline-none focus:bg-gray-600 focus:text-gray-200"
                        wire:click="$toggle('confirmingRemoveCollection')"
                    >
                        <svg class="mr-1 text-gray-400" style="height: 1em; width: 1em;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Remove Collection
                    </button>
                </div>
            </div>

            <div x-show="drawer === 'share'" class="grid gap-6">
                @if ($collection->users->isNotEmpty())
                    <div class="p-6 space-y-6 border border-gray-600 rounded">
                        @foreach ($collection->users->sortBy('name') as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    <div class="ml-4">{{ $user->name }}</div>
                                </div>

                                <div class="flex items-center">
                                    <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" wire:click="removeUser('{{ $user->id }}')">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form wire:submit.prevent="addUser">
                    <h3>
                        {{ __('Add a new collaborator, allowing them to view and edit this collection.') }}
                    </h3>

                    <div class="mt-2 max-w-xl text-sm text-gray-300">
                        {{ __('Please provide the email address of the person you would like to add to this collection. The email address must be associated with an existing account.') }}
                    </div>

                    <label for="email" class="mt-4 block font-semibold text-gray-300">Email</label>

                    <div class="mt-1 flex flex-wrap justify-end gap-4">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="flex-1 block form-input bg-gray-800 border-gray-500 focus:border-gray-500"
                            wire:model.defer="addUserEmail"
                        />

                        <button
                            type="submit"
                            class="px-4 py-2 flex items-center border border-gray-500 rounded font-medium"
                        >
                            <x-heroicon-s-user-add class="mr-1 text-gray-400" style="height: 1em; width: 1em;" />
                            Add
                        </button>
                    </div>

                    <x-jet-input-error for="email" class="mt-2" />
                </form>
            </div>
        </div>
    </div>

    <div :key="$collection->type">
        @foreach ($bullets as $bullet)
            <livewire:bullet :bullet="$bullet" :key="$bullet->id" :type="$collection->type" />
        @endforeach
    </div>

    <x-new-bullet />

    <x-jet-confirmation-modal wire:model="confirmingClearDone">
        <x-slot name="title">
            Clear Done
        </x-slot>

        <x-slot name="content">
            Are you sure you want to clear all complete items?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingClearDone')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="clearDone" wire:loading.attr="disabled">
                {{ __('Clear Done') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingRemoveCollection">
        <x-slot name="title">
            Remove Collection
        </x-slot>

        <x-slot name="content">
            Are you sure you want to remove this collection?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingRemoveCollection')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Remove Collection') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>

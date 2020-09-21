<div class="flex flex-col">
    <div x-data="{
        drawer: '',
        hideDone: @entangle('collection.hide_done'),
    }">
        <div class="-mt-3 flex items-center justify-between border-b border-gray-200">
            <input
                type="text"
                wire:model.lazy="collection.name"
                class="py-3 text-gray-900 font-bold"
                value="{{ $collection->name }}"
            />

            <div class="flex flex-wrap gap-4">
                <button
                    type="button"
                    @click="drawer = drawer === 'share' ? '' : 'share'"
                    class="hover:text-gray-600 focus:outline-none focus:text-gray-600"
                    :class="drawer === 'share' ? 'text-gray-600' : 'text-gray-400'"
                >
                    <x-heroicon-o-share class="w-5 h-5" />
                </button>

                <button
                    type="button"
                    @click="drawer = drawer === 'settings' ? '' : 'settings'"
                    class="hover:text-gray-600 focus:outline-none focus:text-gray-600"
                    :class="drawer === 'settings' ? 'text-gray-600' : 'text-gray-400'"
                >
                    <x-heroicon-o-adjustments class="w-5 h-5" />
                </button>
            </div>
        </div>

        <div
            x-cloak
            x-show="drawer"
            class="-mx-12 px-12 py-6 bg-gray-700 shadow-inner text-white"
        >
            <div x-show="drawer === 'settings'" class="flex items-center justify-between flex-wrap gap-x-20 gap-y-6">
                <div class="flex flex-wrap gap-x-12 gap-y-6">
                    <div class="whitespace-no-wrap">
                        <label class="font-semibold text-gray-300">Collection Type</label>
                        <div class="mt-2">
                            <label class="font-semibold">
                                <input type="radio" wire:model="collection.type" name="type" value="bullet" class="form-radio h-5 w-5 border-gray-500 bg-gray-800"> <span class="ml-1 text-gray-200">Bullet</span>
                            </label>
                            <label class="ml-4 font-semibold">
                                <input type="radio" wire:model="collection.type" name="type" value="checklist" class="form-radio h-5 w-5 border-gray-500 bg-gray-800"> <span class="ml-1 text-gray-200">Checklist</span>
                            </label>
                        </div>
                    </div>

                    <div class="whitespace-no-wrap">
                        <label class="font-semibold text-gray-300">Hide Done</label>
                        <div class="mt-2">
                            <span
                                role="checkbox"
                                tabindex="0"
                                :aria-checked="hideDone"
                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
                                :class="hideDone ? 'bg-blue-600' : 'bg-gray-800'"
                                @click="hideDone = ! hideDone"
                            >
                              <span
                                  aria-hidden="true"
                                  class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
                                  :class="hideDone ? 'translate-x-5' : 'translate-x-0'"
                              ></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-x-6 gap-y-2">
                    <div>
                        <button
                            class="inline-flex items-center font-medium text-gray-200 whitespace-no-wrap"
                            wire:click="clearDone"
                        >
                            <svg class="mr-1 text-gray-400" style="height: 1em; width: 1em;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Clear Done
                        </button>
                    </div>

                    <div>
                        <button
                            class="inline-flex items-center font-medium text-gray-200 whitespace-no-wrap"
                            wire:click="delete"
                        >
                            <svg class="mr-1 text-gray-400" style="height: 1em; width: 1em;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Remove Collection
                        </button>
                    </div>
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
            <livewire:bullet :bullet="$bullet" :key="$collection->type . $bullet->id" :type="$collection->type" />
        @endforeach
    </div>

    <x-new-bullet />
</div>

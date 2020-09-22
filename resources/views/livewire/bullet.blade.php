<div
    x-data="{
        menu: false,
        state: @entangle('bullet.state'),
        deleting: false,
    }"
    class="py-2 border-b border-gray-200 flex"
    x-init="autosize($refs.name)"
>
    <div class="relative flex-shrink-0" :class="deleting ? 'opacity-25' : ''">
        @if ($type === 'bullet')
            <div class="border border-transparent">
                <button
                    class="h-8 w-8 flex items-center justify-center rounded-full border border-transparent hover:border-gray-200 hover:shadow focus:outline-none focus:border-gray-200 focus:shadow-inner"
                    :class="[
                        ! $wire.fade && (state === 'incomplete' || state === 'note' || state === 'event') ? 'text-gray-700' : 'text-gray-400',
                    ]"
                    @click="menu = true"
                >
                    @if ($bullet->state === 'incomplete')
                        <x-icon.incomplete x-show="state === ''" class="h-5 w-5 text-gray-400" />
                    @endif
                    <x-icon.incomplete x-cloak x-show="state === 'incomplete'" class="w-5 h-5" />

                    @if ($bullet->state === 'complete')
                        <x-icon.complete x-show="state === ''" class="h-5 w-5 text-gray-400" />
                    @endif
                    <x-icon.complete x-cloak x-show="state === 'complete'" class="h-5 w-5" />

                    @if ($bullet->state === 'migrated')
                        <x-icon.migrated x-show="state === ''" class="w-5 h-5 text-gray-400" />
                    @endif
                    <x-icon.migrated x-cloak x-show="state === 'migrated'" class="w-5 h-5" />

                    @if ($bullet->state === 'note')
                        <x-icon.note x-show="state === ''" class="w-5 h-5 text-gray-400" />
                    @endif
                    <x-icon.note x-cloak x-show="state === 'note'" class="w-5 h-5" />

                    @if ($bullet->state === 'event')
                        <x-icon.event x-show="state === ''" class="w-5 h-5 text-gray-400" />
                    @endif
                    <x-icon.event x-cloak x-show="state === 'event'" class="w-5 h-5" />
                </button>
            </div>

            <div
                x-cloak
                x-show.transition.origin.top.left="menu"
                class="absolute top-0 left-0 -ml-2 inline-flex px-2 rounded-full border border-gray-200 bg-white shadow-xl text-gray-700 z-10 overflow-hidden"
                @click.away="menu = false"
                @click="menu = false"
            >
                <button class="h-8 w-8 flex items-center justify-center focus:outline-none" @click="menu = false">
                    <x-icon.complete x-show="state === 'complete'" class="h-5 w-5" />
                    <x-icon.incomplete x-show="state === 'incomplete'" class="w-5 h-5" />
                    <x-icon.migrated x-show="state === 'migrated'" class="w-5 h-5" />
                    <x-icon.note x-show="state === 'note'" class="w-5 h-5" />
                    <x-icon.event x-show="state === 'event'" class="w-5 h-5" />
                </button>

                <button x-show="state !== 'incomplete'" class="h-8 w-8 flex items-center justify-center hover:bg-gray-100 focus:outline-none" @click="state = 'incomplete'">
                    <x-icon.incomplete class="w-5 h-5" />
                </button>

                <button x-show="state !== 'complete'" class="h-8 w-8 flex items-center justify-center hover:bg-gray-100 focus:outline-none" @click="state = 'complete'">
                    <x-icon.complete class="h-5 w-5" />
                </button>

                <button x-show="state !== 'note'" class="h-8 w-8 flex items-center justify-center hover:bg-gray-100 focus:outline-none" @click="state = 'note'">
                    <x-icon.note class="h-5 w-5" />
                </button>

                @if ($bullet->collection_id === null)
                    <button x-show="state !== 'event'" class="h-8 w-8 flex items-center justify-center hover:bg-gray-100 focus:outline-none" @click="state = 'event'">
                        <x-icon.event class="h-5 w-5" />
                    </button>
                @endif

                @if ($bullet->collection_id === null && $bullet->created_at <= today())
                    <button x-show="state !== 'migrated'" class="h-8 w-8 flex items-center justify-center hover:bg-gray-100 focus:outline-none" @click="state = 'migrated'" wire:click="migrate">
                        <x-icon.migrated class="h-5 w-5" />
                    </button>
                @endif

                <button class="h-8 w-8 flex items-center justify-center hover:bg-gray-100 focus:outline-none" @click="deleting = true" wire:click="delete">
                    <x-heroicon-s-trash class="h-5 w-5 text-gray-500" />
                </button>
            </div>
        @elseif ($type === 'checklist')
            <div class="border border-transparent">
                <div class="h-8 w-8 flex items-center justify-center">
                    <input
                        type="checkbox"
                        class="form-checkbox h-5 w-5"
                        wire:model="bullet.complete"
                    />
                </div>
            </div>
        @endif
    </div>

    <div class="w-full mx-2">
        <textarea
            wire:ignore
            x-ref="name"
            wire:model.lazy="bullet.name"
            wire:loading.attr="disabled"
            class="w-full py-1 text-gray-900 overflow-hidden bg-transparent disabled:opacity-50"
            style="resize: none; height: 1em;"
            rows="1"
            :class="[
                ! $wire.fade && (state === 'incomplete' || state === 'note' || state === 'event') ? 'text-gray-900' : 'text-gray-400',
                deleting ? 'opacity-25' : ''
            ]"
        ></textarea>

        <x-jet-input-error for="bullet.name" class="mt-2" />
        <x-jet-input-error for="bullet.state" class="mt-2" />
    </div>

    <div class="w-8 h-8 flex items-center justify-center">
        <svg wire:loading class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>

<form
    wire:submit.prevent="addBullet"
    class="py-2 border-b border-gray-200 flex"
    x-data
    x-init="autosize($refs.name)"
    x-ref="form"
>
    <div class="border border-transparent flex-shrink-0">
        <div class="h-8 w-8 flex items-center justify-center">
            <x-icon.incomplete class="h-5 w-5 text-gray-200" />
        </div>
    </div>

    <textarea
        wire:ignore
        wire:model.defer="newBulletName"
        x-ref="name"
        type="text"
        class="ml-2 w-full py-1 text-gray-900 overflow-hidden"
        placeholder="Unburden your mind..."
        style="resize: none; height: 1em;"
        rows="1"
        @keydown.enter="
            if (! $event.shiftKey) {
                $event.preventDefault()
                $wire.addBullet()
            }
        "
        @bullet-added.window="autosize.update($refs.name)"
    ></textarea>

    <div class="w-8 h-8 flex items-center">
        <svg wire:loading wire:target="addBullet" class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</form>

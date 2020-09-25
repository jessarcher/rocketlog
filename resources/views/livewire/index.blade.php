<div>
    <h2 class="pb-3 border-b font-bold border-gray-200 text-gray-900">Index</h2>

    <a href="/daily-log" class="flex items-center py-3 border-b border-gray-200 font-medium">
        <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span class="ml-2 text-gray-900">Daily Log</span>
    </a>

    {{-- <a href="/daily-log" class="flex items-center py-3 border-b border-gray-200 font-medium"> --}}
    {{--     <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> --}}
    {{--         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /> --}}
    {{--     </svg> --}}
    {{--     <span class="ml-2 text-gray-900">Monthly Log</span> --}}
    {{-- </a> --}}

    @foreach($collections as $collection)
        <a href="/c/{{ $collection->hashid() }}" class="flex items-center py-3 border-b border-gray-200 font-medium">
            <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="ml-2 text-gray-900">{{ $collection->name }}</span>
        </a>
    @endforeach

    <div class="relative">
        <input type="text" wire:model.lazy="newCollectionName" wire:keydown.enter="addCollection" class="py-3 px-2 border-b border-gray-200 w-full bg-transparent" placeholder="New collection...">
    </div>

    @if ($sharedCollections->isNotEmpty())
        <h2 class="mt-10 pb-3 border-b font-bold border-gray-200 text-gray-900">Shared with you</h2>

        @foreach($sharedCollections as $collection)
            <a href="/c/{{ $collection->hashid() }}" class="flex items-center py-3 border-b border-gray-200 font-medium">
                <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span class="ml-2 text-gray-900">{{ $collection->name }}</span>
            </a>
        @endforeach
    @endif
</div>

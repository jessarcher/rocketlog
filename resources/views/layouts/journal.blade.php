<x-app-layout>
    <div class="md:py-12 flex-1 flex flex-col">
        <div class="flex-1 max-w-7xl w-full mx-auto md:px-6 flex flex-col md:flex-row-reverse">
            <aside class="hidden md:block md:ml-12 md:pt-12 lg:w-80">
                @livewire('index')
            </aside>

            <div class="flex-1 p-6 md:p-12 bg-white overflow-hidden sm:rounded-lg md:shadow-xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>

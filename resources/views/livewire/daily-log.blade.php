<div>
    <div
        x-data="{ timezone: @entangle('user.timezone') }"
        x-init="timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;"
    ></div>
    @foreach ($days as $day)
        @php
            $fade = $loop->iteration >= 5;
        @endphp

        <h2 class="{{ $loop->first ? '' : 'mt-12' }} pb-3 font-bold border-b border-gray-200 {{ $fade ? 'text-gray-300' : 'text-gray-800' }}" wire:key="{{ $day->date }}">{{ $day->date->format('D, M d') }}</h2>

        <div>
            @foreach ($day->bullets as $bullet)
                <livewire:bullet :bullet="$bullet" type="bullet" :fade="$fade" :key="$bullet->id" />
            @endforeach
        </div>

        @if ($loop->first)
            <x-new-bullet />
        @endif
    @endforeach
</div>

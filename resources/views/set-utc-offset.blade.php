@extends('base')
@push('scripts')
    <script>
        const date = new Date()
        const offset = -(date.getTimezoneOffset())
        window.location = '{{ request()->url() }}?utc_offset=' + offset
    </script>
@endpush

@extends('base', ['bodyClass' => 'bg-white md:bg-gray-100 dark:bg-gray-800 md:dark:bg-gray-900'])

@section('body')
    @inertia
@endsection

@push('scripts')
    @vite('resources/js/app.js')
@endpush

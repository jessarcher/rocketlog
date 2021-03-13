@extends('base', ['bodyClass' => 'bg-gray-100 dark:bg-gray-900'])

@section('body')
    @inertia
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
@endpush

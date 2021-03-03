@extends('base')

@section('body')
    @inertia
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
@endpush

@extends( 'layouts.app' )

@section( 'content' )

    @include( 'widget.search.wrapper' )

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush

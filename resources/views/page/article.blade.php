<?php
/** @var array $article */
?>

@extends( 'layouts.app' )

@section( 'content' )

<div class="container">
    <div class="simple-page-wrapper">
        <h1>{{ $article[ 'title' ] }}</h1>
        <div class="article-wrapper">
            @if ( ( $article[ 'banner' ][ 'thumbs' ][ 'b' ][ 'path' ] ?? null ) !== null )
            <div class="article-img">
                <img src="{{ Storage::url( $article[ 'banner' ][ 'thumbs' ][ 'b' ][ 'path' ] ) }}" alt="" />
            </div>
            @endif
            <div class="article-text ql-editor">
                {!! $article[ 'content' ] !!}
            </div>
        </div>
    </div>
</div>

@endsection

@push( 'styles' )
    <link rel="stylesheet" href="//cdn.quilljs.com/1.3.6/quill.core.css">
@endpush

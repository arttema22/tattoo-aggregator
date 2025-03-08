<?php
/** @var Illuminate\Pagination\LengthAwarePaginator $articles */
?>

@extends( 'layouts.app' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper" style="min-height: calc(100vh - 332px);">
            <div class="row">
                <div class="col-md-10">
                    <h1>Блог</h1>

                    @if ( $articles->isNotEmpty() )
                    <div class="row ">
                        @foreach( $articles as $article )
                            @include( 'blocks.blog.item', $article )
                        @endforeach
                    </div>
                    @else
                        <p>К сожалению, здесь пока ни чего нет, но в скором времени появиться</p>
                    @endif

                    {{-- Пагинация --}}
                    {{ $articles->links() }}
                </div>
                <div class="col-md-2">
                    @include( 'blocks.blog.categories' )
                </div>
            </div>
        </div>
    </div>

@endsection

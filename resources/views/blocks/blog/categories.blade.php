<?php
/** @var array $categories */
$currentRoute = \Illuminate\Support\Facades\Route::current()?->parameters[ 'alias' ] ?? '';
?>

<div class="sidebar-wrapper">
    <h2>Рубрики:</h2>
    @foreach( $categories as $item )
        <div class="link-block">
            <a {!! $currentRoute === $item[ 'alias' ] ? 'class="active"' : '' !!} href="{{ route( 'article.category.all', [ 'alias' => $item[ 'alias' ] ] ) }}">
                {{ $item[ 'name' ] }}
            </a>
        </div>
    @endforeach
</div>

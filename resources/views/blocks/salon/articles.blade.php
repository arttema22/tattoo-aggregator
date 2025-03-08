<?php
/** @var \App\Models\Article[] $articles */
?>

<div class="sidebar-article">
    <h2>Популярные статьи блога</h2>

    @foreach( $articles as $item )
    <div class="sidebar-article-item">
        <div class="sidebar-article-body">
            <a href="/{{ $item[ 'alias' ] }}"><h3>{{ $item[ 'title' ] }}</h3></a>
            <p>{{ $item[ 'description' ] }}</p>
        </div>
    </div>
    @endforeach

</div>

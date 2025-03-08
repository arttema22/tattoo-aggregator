<div class="tags-wrapper ptb">
    <div class="container">
        <h2>Смотрите также или Возможно вы искали</h2>

        @foreach( $user_tags as $tag )
            <a class="landing-tag-link" href="{{ $tag[ 'link' ] }}" title="{{ $tag[ 'name' ] }}">#{{ $tag[ 'name' ] }}</a>
        @endforeach

        @foreach( $tags as $tag )
            <a class="landing-tag-link" href="{{ $tag[ 'link' ] }}" title="{{ $tag[ 'name' ] }}">#{{ $tag[ 'name' ] }}</a>
        @endforeach
    </div>
</div>

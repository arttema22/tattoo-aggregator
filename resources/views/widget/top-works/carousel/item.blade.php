<?php
/** @var string $type */
/** @var array $works */
?>

<div id="carousel_{{ $type }}" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach( $works as $item )
            @if ( ( $loop->iteration - 1 ) % 3 === 0 )
                <div class="carousel-item{{ $loop->first ? ' active' : '' }}">
                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <div class="row">
            @endif
            @include( 'widget.search.result.item', $item )
            @if ( $loop->iteration % 3 === 0 )
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <button  class="carousel-control-prev" type="button" data-bs-target="#carousel_{{ $type }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Предыдущий</span>
    </button >
    <button  class="carousel-control-next" type="button" data-bs-target="#carousel_{{ $type }}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Следующий</span>
    </button >
</div>

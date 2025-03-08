<?php
/** @var \App\Models\Review[] $reviews */
?>
<div class="tab-pane fade" id="review">
    <h2>Отзывы</h2>

    {{-- <p>Есть что сказать? Напиши отзыв, помоги другим посетителям определиться с выбором!</p> --}}

    <div class="salon-reviews-wrapper">
        <div class="row">

            @foreach( $reviews as $item )
                <div class="col-md-6">
                    <div class="salon-review-item">
                        <div class="salon-review-item-name">{{ $item->name }}</div>
                        <div class="salon-review-item-data">{{ $item->published_at->format( 'd.m.Y' ) }}</div>
                        <div class="salon-review-item-text">{{ $item->content }}</div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

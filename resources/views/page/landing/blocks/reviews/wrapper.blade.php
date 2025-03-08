<?php
/** @var \Illuminate\Support\Collection $reviews */
?>

<div class="reviews-wrapper ptb">
    <div class="container">
        <h2>Наши отзывы</h2>
        <div class="flex-wrap">
            <?php $reviews_count = $reviews->count() ?>
            @foreach( $reviews as $i => $review )
                @if ( $i === 0 || $i === (int) ($reviews_count / 2) )
                    <div class="col-6">
                @endif
                    <div class="col p-3">
                        <div class="landing-review-item">
                            <div class="landing-review-item-name">{{ $review->name }}</div>
                            <div class="landing-review-item-text">{{ $review->content }}</div>
                        </div>
                    </div>
                @if ( $i === (int) ($reviews_count / 2 - 1) || $i === $reviews_count - 1 )
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
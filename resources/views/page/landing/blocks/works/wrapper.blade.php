<div class="landing-works-wrapper ptb">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div id="works-results" class="row search-results-wrapper">
                    @if( isset( $works['result'] ) && $works['result']->isNotEmpty() )
                        @foreach( $works['result'] as $item )
                            @include( 'widget.search.result.item', $item )
                        @endforeach
                    @else
                        <div class="text-center" style="margin-top: 20px">По данному запросу ничего не найдено</div>
                    @endif
                </div>
            </div>

            @include( 'page.landing.blocks.works.filters.wrapper', ['filters' => $works['filters']] )
        </div>

        @if( isset( $works['result'] ) && $works['result']->isNotEmpty() )
            {{-- Пагинация --}}
        @endif
    </div>
</div>
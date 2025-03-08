<?php
/** @var \App\Models\Contact $salon */
/** @var \App\Models\WorkingHours[] $working_hours */
/** @var \Illuminate\Support\Collection $albums */
/** @var \Illuminate\Support\Collection $reviews */
?>

@extends( 'layouts.app' )

@section( 'content' )

    @include( 'blocks.salon.caption' )

    @include( 'blocks.salon.tabs' )

    <div class="salon-body-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-lg-10 tab-content" id="myTabContent">

                    @include( 'blocks.salon.tab.description' )
                    @include( 'blocks.salon.tab.services' )

                    @includeWhen(
                        $albums->where( 'type', '=', \App\Enums\SpecializationTypes::TATTOO )->first()->files->isNotEmpty(),
                        'blocks.salon.tab.image-gallery',
                        [
                            'salon'  => $salon,
                            'tab_id' => 'tattoo-gallery',
                            'album'  => $albums->where( 'type', '=', \App\Enums\SpecializationTypes::TATTOO )->first()
                        ]
                    )
                    @includeWhen(
                        $albums->where( 'type', '=', \App\Enums\SpecializationTypes::PIERCING )->first()->files->isNotEmpty(),
                        'blocks.salon.tab.image-gallery',
                        [
                            'salon'  => $salon,
                            'tab_id' => 'piercing-gallery',
                            'album'  => $albums->where( 'type', '=', \App\Enums\SpecializationTypes::PIERCING )->first()
                        ]
                    )
                    @includeWhen(
                        $albums->where( 'type', '=', \App\Enums\SpecializationTypes::TATUAJE )->first()->files->isNotEmpty(),
                        'blocks.salon.tab.image-gallery',
                        [
                            'salon'  => $salon,
                            'tab_id' => 'tatuaje-gallery',
                            'album'  => $albums->where( 'type', '=', \App\Enums\SpecializationTypes::TATUAJE )->first()
                        ]
                    )

                    @includeWhen(
                        $videos->isNotEmpty(),
                        'blocks.salon.tab.video-gallery',
                        [
                            'videos' => $videos
                        ]
                    )
                    @include( 'blocks.salon.tab.contact' )
                    @include( 'blocks.salon.tab.review', [ 'reviews' => $reviews ] )

                </div>
                <div class="col-md-3 col-lg-2 salon-sidebar">

                    @include( 'blocks.salon.work-time' )

                    @include( 'blocks.salon.articles' )

                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush

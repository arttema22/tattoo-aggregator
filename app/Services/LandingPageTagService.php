<?php

namespace App\Services;

use App\Enums\ModelsRelations\LandingPageTagRelations;
use App\Filters\LandingPageTagFilter;
use App\Repositories\LandingPageTagRepository;

class LandingPageTagService
{
    public function __construct(
        private LandingPageTagRepository $repository
    ) {}

    public function get( int $excludeLandingPage ): array
    {
        $filter = app( LandingPageTagFilter::class );
        $filter->setCustomFields( [
            'excludeLandingPage' => $excludeLandingPage,
            'limit'              => 8
        ] );

        $result = $this->repository->search(
            $filter,
            [
                LandingPageTagRelations::PAGE_WITH_CITY
            ]
        );

        $output = [];
        foreach ( $result as $item ) {
            $output[] = [
                'name' => $item->name,
                'link' => route( 'landing-page.index', [ 'city' => $item->landingPage->city->alias, 'landing_page_name' => $item->landingPage->slug ] )
            ];
        }

        return $output;
    }
}

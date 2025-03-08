<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\LandingPageService;
use App\Services\LandingPageDefaultPriceService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class FillLandingPageServiceSeeder extends Seeder
{
    public function __construct(
        private LandingPageDefaultPriceService $service
    ) {}

    /**
     * @return void
     */
    public function run() : void
    {
        $landing_pages = $this->getLandingPages();
        /** @var LandingPage $item */
        foreach ($landing_pages as $item) {
            $data = $this->service->get($item->type, $item->city_id);
            $this->addServices($item->id, $item->type, $data);
        }
    }

    /**
     * @return Collection
     */
    protected function getLandingPages() : Collection
    {
        return LandingPage::all();
    }

    /**
     * @param int $landing_page_id
     * @param int $type
     * @param array $data
     * @return void
     */
    protected function addServices(int $landing_page_id, int $type, array $data): void
    {
        foreach ($data as $item) {
            LandingPageService::factory()
                ->state([
                    'landing_page_id' => $landing_page_id,
                    'type'            => $type,
                    'name'            => $item[ 'name' ],
                    'price'           => $item[ 'price' ],
                    'currency'        => $item[ 'currency' ],
                    'is_start_price'  => $item[ 'start' ],
                ])
                ->create();
        }
    }
}

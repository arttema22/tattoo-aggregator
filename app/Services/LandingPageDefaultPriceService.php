<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class LandingPageDefaultPriceService
{
    /**
     * @var array
     */
    protected array $source = [];

    /**
     * @var array
     */
    protected array $cities = [];

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        $this->source = File::getRequire( resource_path( '/sources/landing_page/services.php' ) );
        $this->cities = app( CityService::class )->getAll()->toArray();
    }

    /**
     * @param int $type
     * @param string $city
     * @return array
     */
    public function get( int $type, string $city ) : array
    {
        $source = $this->getSource( $type );
        $city   = $this->getCityName( $source, $city );

        return $this->getData( $source, $city );
    }

    /**
     * @param int $type
     * @return array
     */
    protected function getSource( int $type ) : array
    {
        return current( array_filter( $this->source, fn ( $item ) => $item[ 'type' ] === $type ) );
    }

    /**
     * @param array $source
     * @param string $city
     * @return string
     */
    protected function getCityName( array $source, string $city ) : string
    {
        // получить список городов из источника
        $first = current( $source[ 'services' ] )[ 'prices' ] ?? [];
        $first = array_map( fn( $item ) => $item[ 'city' ], $first );

        // если город есть в этом списке, его и возвращаем
        if ( in_array( $city, $first, true ) ) {
            return $city;
        }

        // формируем список городов и кол-во населения
        $cities = [];
        foreach ( $this->cities as $item ) {
            $cities[ $item[ 'name' ][ 'ru' ] ] = $item[ 'population' ];
        }
        arsort( $cities );

        $diff = null;
        $resultCity = null;
        $cityPopulation = $cities[ $city ] ?? 0;

        // поиск города с похожим населением
        foreach ( $first as $item ) {
            $itemPopulation = $cities[ $item ] ?? 0;
            $diffItem = $itemPopulation - $cityPopulation;

            if ( $diff === null || ( $diff > $diffItem && $diffItem > 0 ) ) {
                $diff = $diffItem;
                $resultCity = $item;
            }
        }

        return $resultCity;
    }

    /**
     * @param array $source
     * @param string $city
     * @return array
     */
    protected function getData( array $source, string $city ) : array
    {
        $output = [];

        $scale = $source[ 'settings' ][ 'scale' ];

        foreach ( $source[ 'services' ] as $item ) {
            $priceObj = current( array_filter( $item[ 'prices' ], fn ( $v ) => $v[ 'city' ] === $city ) );
            $price = $priceObj[ 'price' ];
            $price = mt_rand( 0, 1 ) === 0
                ? $price - ( ceil( $price / 100 ) * mt_rand( 0, $scale[ 'under' ] ) )
                : $price + ( ceil( $price / 100 ) * mt_rand( 0, $scale[ 'under' ] ) );

            $output[] = [
                'name'     => $item[ 'name' ],
                'price'    => (int) $price,
                'currency' => $priceObj[ 'currency' ],
                'start'    => $source[ 'settings' ][ 'start' ]
            ];
        }

        return $output;
    }
}

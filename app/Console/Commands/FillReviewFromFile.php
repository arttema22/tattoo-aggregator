<?php

namespace App\Console\Commands;

use App\Enums\ReviewApprove;
use App\Enums\ReviewType;
use App\Models\City;
use App\Models\Contact;
use App\Models\Review;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FillReviewFromFile extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:review-db {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill reviews with data from file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle()
    {
        $file = $this->argument( 'file' );
        if ( File::exists( $file ) === false ) {
            $this->error( 'File doesn\'t exists' );

            return 1;
        }

        $reviews = @json_decode( File::get( $file ), true );
        if ( $reviews === null ) {
            $this->error( 'File is bad' );

            return 1;
        }

        $reviews_count = count( $reviews );
        $cities_map    = $this->getCitiesToReviewsMap( $reviews_count );
        shuffle( $reviews );

        $this->reviewToBase( $reviews, $cities_map );

        return 0;
    }

    /**
     * @param int $reviews_count
     * @return array
     * @throws \Exception
     */
    protected function getCitiesToReviewsMap( int $reviews_count ) : array
    {
        $output = [];

        $population_count = City::where( 'country_id', '=', 1 )->get( 'population' )->sum( fn( $a ) => $a->population );
        $salon_count      = Contact::where( 'country_id', '=', 1 )->count();

        $cities = City::with( 'contacts' )->where( 'country_id', '=', 1 )->get();
        foreach ( $cities as $city ) {
            $salons = $city->contacts->count();
            if ( $salons === 0 ) {
                continue;
            }

            $population_percent = $city->population / $population_count * 100;
            $salon_percent      = $salons / $salon_count * 100;
            $current_percent    = $population_percent * ( $salon_percent > 1 ? 1.15 : $salon_percent );

            $review_to_city     = ceil( $reviews_count / 100 * $current_percent );
            $review_per_salon   = ceil( $review_to_city / $salons );
            $min                = floor( $review_per_salon / 2 );
            $max                = floor( $review_per_salon * 1.5 );

            $range = $this->getRange( $min, $max, $salons, $review_to_city );
            $output[] = [
                'city'  => $city->id,
                'range' => $range
            ];
        }

        return $output;
    }

    /**
     * @param int $min
     * @param int $max
     * @param int $count
     * @param int $all
     * @return array
     * @throws \Exception
     */
    protected function getRange( int $min, int $max, int $count, int $all ) : array
    {
        $output = [];

        for ( $i = 0; $i < $count; $i++ ) {
            $c = random_int( $min, $max );
            if ( ( $all - $c ) < 0 ) {
                $c = $all;
            }

            $all -= $c;
            $output[] = $c;
        }

        return $output;
    }

    protected function reviewToBase( array $reviews, array $map ) : void
    {
        $gen_review = $this->getReview( $reviews );
        $dates = collect( array_map( fn ( $item ) => $item->format( 'Y-m-d' ), CarbonPeriod::between( '2021-01-01', Carbon::now()->format( 'Y-m-d' ) )->toArray() ) );

        foreach ( $map as [ 'city' => $city_id, 'range' => $range ] ) {
            $salons = Contact::where( 'city_id', '=', $city_id )->get();

            foreach ( $salons as $k => $salon ) {
                $count = $range[ $k ];
                $inserts = [];

                for ( $i = 0; $i < $count; $i++ ) {
                    $review = $gen_review->current();
                    $gen_review->next();

                    $dt = ( $review[ 'dt' ] === '0000-00-00'
                        ? $dates->random()
                        : $review[ 'dt' ] ) . ' 00:00:00';

                    $inserts[] = [
                        'contact_id'   => $salon->id,
                        'name'         => $review[ 'name' ],
                        'content'      => preg_replace( '/(http.+?)(?:\s|$)/', '', $review[ 'content' ] ),
                        'type'         => ReviewType::AUTO,
                        'is_approved'  => ReviewApprove::YES,
                        'published_at' => $dt
                    ];
                }

                Review::insert( $inserts );
            }
        }
    }

    /**
     * @param array $reviews
     * @return \Generator
     */
    protected function getReview( array $reviews ) : \Generator
    {
        foreach ( $reviews as $review ) {
            yield $review;
        }
    }
}

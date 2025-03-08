<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SitemapXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap-xml:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация sitemap.xml';

    /**
     * @var string
     */
    protected $now = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->now = now()->format( 'Y-m-d' );
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $output = [];

        // получения данных
        foreach ( config( 'sitemap-xml' ) as $item ) {
            $output[] = $this->getData( $item );
        }
        $output = array_merge( ...$output );

        $xml = $this->toXML( $output );
        File::put( public_path( 'sitemap.xml' ), $xml );

        return 0;
    }

    /**
     * @param array $input
     * @return array|array[]
     */
    protected function getData( array $input ) : array
    {
        $output = [];

        // одна станица без всего
        if ( $input[ 'model' ] === null && $input[ 'enum' ] === null ) {
            return [ $this->getItem(
                route( $input[ 'route' ] ),
                $input[ 'freq' ],
                $input[ 'priority' ]
            ) ];
        }

        // есть только enum
        if ( $input[ 'model' ] === null && $input[ 'enum' ] !== null ) {
            foreach ( $input[ 'enum' ]::cases() as $item ) {
                $output[] = $this->getItem(
                    route( $input[ 'route' ], [ $input[ 'param' ] => $item ] ),
                    $input[ 'freq' ],
                    $input[ 'priority' ]
                );
            }
        }

        // есть только enum
        if ( $input[ 'model' ] !== null && $input[ 'enum' ] === null ) {
            $models = ( isset( $input[ 'filter' ] ) )
                ? $input[ 'model' ]::where( ...$input[ 'filter' ] )->get()
                : $input[ 'model' ]::all();

            foreach ( $models as $item ) {
                $output[] = $this->getItem(
                    route( $input[ 'route' ], [ $item->{ $input[ 'param' ] } ] ),
                    $input[ 'freq' ],
                    $input[ 'priority' ]
                );
            }
        }

        return $output;
    }

    /**
     * @param string $link
     * @param string $freq
     * @param float $priority
     * @return array
     */
    protected function getItem( string $link, string $freq, float $priority ) : array
    {
        return [
            'loc'        => $link,
            'lastmod'    => $this->now,
            'changefreq' => $freq,
            'priority'   => $priority,
        ];
    }

    protected function toXML( array $data ) : string
    {
        $output[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $output[] = '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ( $data as $item ) {
            $output[] = '<url>';

            foreach ( $item as $k => $v ) {
                $output[] = '<' . $k . '>' . $v . '</' . $k . '>';
            }

            $output[] = '</url>';
        }

        $output[] = '</urlset>';

        return implode( "\n", $output );
    }
}

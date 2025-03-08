<?php

namespace App\Http\Controllers;

use App\Helpers\SpecialisationDictionaryHelper;
use App\Helpers\SpecialisationTypeHelper;
use App\Services\ContactService;
use App\Services\FileService;

class WorkController extends BasePublicController
{
    public function __construct(
        private FileService $file_service,
        private ContactService $contact_service,
    )
    {
        parent::__construct();
    }

    public function short( string $salon_alias, int $album_id, int $file_id )
    {
        $file = $this->file_service->getByAlbumAndId( $album_id, $file_id );
        if ( $file === null ) {
            abort( 404 );
        }

        $salon = $this->contact_service->findByAlias( $salon_alias );
        if ( $salon === null ) {
            abort( 404 );
        }

        return view(
            'page.work.short',
            [
                'file'         => $file,
                'salon'        => $salon,
                'type'         => SpecialisationTypeHelper::getTypeFromId( $file?->album->type ?? 0 ),
                'dictionaries' => current( SpecialisationDictionaryHelper::get( $file?->album->type ?? 0 ) ),
            ]
        );
    }

    public function full( string $salon_alias, int $album_id, int $file_id )
    {
        $file = $this->file_service->getByAlbumAndId( $album_id, $file_id );
        if ( $file === null ) {
            abort( 404 );
        }

        $salon = $this->contact_service->findByAlias( $salon_alias );
        if ( $salon === null ) {
            abort( 404 );
        }

        return view(
            'page.work.full',
            [
                'file'         => $file,
                'salon'        => $salon,
                'type'         => SpecialisationTypeHelper::getTypeFromId( $file?->album->type ?? 0 ),
                'dictionaries' => current( SpecialisationDictionaryHelper::get( $file?->album->type ?? 0 ) ),
            ]
        );
    }
}

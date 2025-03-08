<?php

namespace App\Jobs;

use App\DTO\File\FileDTO;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    public int $tries = 3;

    private FileDTO $file_dto;

    /**
     * ProcessImageJob constructor.
     * @param FileDTO $file_dto
     */
    public function __construct( FileDTO $file_dto )
    {
        $this->file_dto = $file_dto;
    }


    /**
     * @param FileService $file_service
     */
    public function handle( FileService $file_service ): void
    {
        if ( $file_service->processOriginalImage( $this->file_dto ) === false ) {
            $this->fail();
        }
    }
}

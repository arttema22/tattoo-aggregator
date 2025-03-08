<?php

namespace App\Events;

use App\DTO\File\FileDTO;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadedImageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private FileDTO $file_DTO;

    /**
     * UploadedImageEvent constructor.
     * @param FileDTO $file_DTO
     */
    public function __construct( FileDTO $file_DTO )
    {
        $this->file_DTO = $file_DTO;
    }

    /**
     * @return FileDTO
     */
    public function getFileDTO(): FileDTO
    {
        return $this->file_DTO;
    }
}

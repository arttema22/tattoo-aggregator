<?php

namespace App\Events;

use App\DTO\Contact\ContactDTO;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalonCoordinatesChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @return void
     */
    public function __construct(
        private ContactDTO $contact_dto
    ) {}

    /**
     * @return ContactDTO
     */
    public function getContactDto(): ContactDTO
    {
        return $this->contact_dto;
    }


}

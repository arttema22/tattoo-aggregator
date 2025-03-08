<?php

namespace App\Repositories;

use App\DTO\Contact\ContactDTO;
use App\Models\Contact;

class ContactRepository
{
    use HasSearch,
        HasUpdate,
        HasDelete,
        HasFirst;

    protected static function model(): string
    {
        return Contact::class;
    }

    /**
     * @param ContactDTO $dto
     * @return Contact|null
     */
    public function store( ContactDTO $dto ): ?Contact
    {
        $contact = new Contact();
        $contact->profile_id = $dto->profile_id;
        $contact->country_id = $dto->country_id ?? null;
        $contact->city_id    = $dto->city_id ?? null;
        $contact->metro_id   = $dto->metro_id ?? 0;
        $contact->alias      = $dto->alias ?? '';
        $contact->name       = $dto->name ?? '';
        $contact->address    = $dto->address ?? '';
        $contact->phone      = $dto->phone ?? '';
        $contact->site       = $dto->site ?? '';
        $contact->email      = $dto->email ?? '';
        $contact->district   = $dto->district ?? '';
        $contact->lat        = $dto->lat ?? 0.0;
        $contact->lon        = $dto->lon ?? 0.0;

        return $contact->save() ? $contact : null;
    }
}

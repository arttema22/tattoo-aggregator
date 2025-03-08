<?php

namespace App\Repositories;

use App\DTO\SocialNetwork\SocialNetworkDTO;
use App\Models\SocialNetwork;

class SocialNetworkRepository
{
    use HasSearch, HasUpdate, HasDelete;

    protected static function model(): string
    {
        return SocialNetwork::class;
    }

    /**
     * @param SocialNetworkDTO $dto
     * @return SocialNetwork|null
     */
    public function store( SocialNetworkDTO $dto ): ?SocialNetwork
    {
        $social_network = new SocialNetwork();
        $social_network->profile_id = $dto->profile_id;
        $social_network->contact_id = $dto->contact_id ?? null;
        $social_network->sn_id      = $dto->sn_id;
        $social_network->value      = $dto->value;
        $social_network->status     = $dto->status;

        return $social_network->save() ? $social_network : null;
    }

    /**
     * @param int $contact_id
     * @return bool
     */
    public function deleteByContactId( int $contact_id ): bool
    {
        return (bool)SocialNetwork::whereContactId( $contact_id )->delete();
    }
}

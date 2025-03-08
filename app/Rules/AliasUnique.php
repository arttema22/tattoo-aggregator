<?php

namespace App\Rules;

use App\Filters\ContactFilter;
use App\Helpers\AliasHelper;
use App\Services\ContactService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class AliasUnique implements Rule
{
    private ContactService $contact_service;

    /**
     * AliasUnique constructor.
     * @param string $alias
     * @param int|null $contact_id
     */
    public function __construct( private string $alias, private ?int $contact_id )
    {
        $this->contact_service = App::make( ContactService::class );
    }

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        /** @var ContactFilter $filter */
        $filter = App::make( ContactFilter::class );
        $filter->setCustomFields( [ 'alias' => AliasHelper::getFromString( $this->alias ) ] );

        $contact = $this->contact_service->search( $filter )?->first();

        return $contact === null || $contact->id === $this->contact_id;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Данный алиас уже используется';
    }
}

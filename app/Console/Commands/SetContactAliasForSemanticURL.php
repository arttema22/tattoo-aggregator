<?php

namespace App\Console\Commands;

use App\Helpers\AliasHelper;
use App\Models\Contact;
use Illuminate\Console\Command;

class SetContactAliasForSemanticURL extends Command
{
    /**
     * @var string
     */
    protected $signature = 'contacts:alias-semantic-url';

    /**
     * @var string
     */
    protected $description = 'Set contacts aliases for semantic url';

    /**
     * @return int
     */
    public function handle(): int
    {
        $contacts = Contact::all();
        $contacts->each( function ( Contact $contact ) use ( $contacts ) {
            if ( !is_numeric( $contact->alias ) ) {
                return;
            }

            $semantic_alias = AliasHelper::getFromString( $contact->name );
            if ( $contacts->where( 'alias', $semantic_alias )->first() !== null ) {
                // попробуем приклеить улицу из адреса, если уже есть в алиасе
                $street = self::getStreetNameFromAddress( $contact->address );
                $semantic_alias .= '-' . AliasHelper::getFromString( $street );

                if ( $contacts->where( 'alias', $semantic_alias )->first() !== null ) {
                    echo 'duplicate alias record: ' . $contact->id . ', ' . $semantic_alias . "\n";
                    return;
                }
            }

            $contact->alias = $semantic_alias;
            $contact->save();
        } );

        return 0;
    }

    /**
     * @param string $address
     * @return string
     */
    private static function getStreetNameFromAddress( string $address ): string
    {
        $comma_pos = strpos( $address, ',' );
        if ( $comma_pos !== false ) {
            return substr( $address, 0, $comma_pos );
        }

        return $address;
    }
}

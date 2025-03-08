<?php

namespace App\Console\Commands;

use App\DTO\User\UserDTO;
use App\Filters\ContactFilter;
use App\Models\Contact;
use App\Models\User;
use App\Services\ContactService;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApproveProfileOwner extends Command
{
    /**
     * @var string
     */
    protected $signature = 'profile:approve {contact_url} {email}';

    /**
     * @var string
     */
    protected $description = 'Approve profile by contact url';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private UserService $user_service,
        private ProfileService $profile_service,
        private ContactService $contact_service )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $salon_alias = pathinfo( $this->argument('contact_url'), PATHINFO_FILENAME );
        if ( !$salon_alias ) {
            $this->error( 'Can\'t get salon alias from url' );
            return 1;
        }

        $email = $this->argument('email');
        if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
            $this->error( 'Email is not valid' );
            return 1;
        }

        $contact = $this->getContact( $salon_alias );
        if ( $contact === null ) {
            $this->error( 'Can\'t get contact by alias \'' . $salon_alias . '\'' );
            return 1;
        }

        if ( $contact->profile->contacts_count > 1 ) {
            $this->warn( 'Profile have ' . $contact->profile->contacts_count . ' contacts: ' );
            $contact->profile->contacts->each(
                fn ( $contact ) => $this->warn( 'Name: ' . $contact->name . ' , Alias: ' . $contact->alias ) );

            if ( $this->confirm( 'Do you wish to continue? [y/n]' ) === false ) {
                return 1;
            }
        }

        $password = Str::random( 12 );
        $user = $this->updateUserInfo( $contact->profile->user_id, $email, $password );
        if ( $user === null ) {
            $this->error( 'Error for updating user' );
            return 1;
        }

        $this->info( '-------------------------------------' );
        $this->info( 'New email:    ' . $email );
        $this->info( 'New password: ' . $password );
        $this->info( '-------------------------------------' );

        if ( $this->profile_service->approve( $contact->profile_id ) === null ) {
            $this->error( 'Error for approve profile model' );
            return 1;
        }

        return 0;
    }

    /**
     * @param string $alias
     * @return Contact|null
     */
    private function getContact( string $alias ): ?Contact
    {
        /** @var ContactFilter $filter */
        $filter = App::make( ContactFilter::class );
        $filter->setCustomFields( [ 'alias' => $alias ] );

        return $this->contact_service->search( $filter )?->first();
    }

    /**
     * @param int $user_id
     * @param string $email
     * @param string $password
     * @return User|null
     */
    private function updateUserInfo( int $user_id, string $email, string $password ): ?User
    {
        /** @var UserDTO $dto */
        $dto = App::make( UserDTO::class );
        $dto->email = $email;
        $dto->password = Hash::make( $password );

        return $this->user_service->update( $user_id, $dto );
    }
}

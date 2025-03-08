<?php

namespace App\Observers;

use App\Helpers\JobsHelper;
use App\Models\Contact;

class ContactObserver
{
    public function updated( Contact $contact ) : void
    {
        JobsHelper::calculateContactFilledPercent( $contact->id );
    }
}

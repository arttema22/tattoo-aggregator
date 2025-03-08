<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CityObserver
{
    public function created( Model $model ) : void
    {
        $this->clear();
    }

    public function updated( Model $model ) : void
    {
        $this->clear();
    }

    public function deleted( Model $model ) : void
    {
        $this->clear();
    }

    public function restored( Model $model ) : void
    {
        $this->clear();
    }

    protected function clear() : void
    {
        Cache::forget( 'cities' );
    }
}

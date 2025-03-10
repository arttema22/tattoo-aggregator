<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClearOriginal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:original';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear folder \'original\'';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = new Filesystem;
        $file->cleanDirectory( 'storage/app/original' );
        return 0;
    }
}

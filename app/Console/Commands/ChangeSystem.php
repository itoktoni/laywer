<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Collective\Remote\RemoteFacade;

class ChangeSystem extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands To Change Directory System';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        \SSH::into('local')->run([
		'cd '.base_path(),
		'cd ..',
		'chmod 777 -R system',
		'php artisan email:system',
		]);

        $this->info('The system has been change successfully!');
    }

}

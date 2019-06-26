<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Collective\Remote\RemoteFacade;

class ChangePublic extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands To Change Directory Public';

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
		'chmod 777 -R public',
		]);

        $this->info('The public has been change successfully!');
    }

}

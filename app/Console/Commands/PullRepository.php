<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;

use VisualAppeal\Gitolite\Config as Repository;

class PullRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull latest changes from gitolite';

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
     * @return mixed
     */
    public function handle()
    {
    	$this->info(sprintf('Pulling repository %s', Config::get('services.gitolite.path')));
        $repository = new Repository(Config::get('services.gitolite.path'), false);
        $repository->pull();
    }
}

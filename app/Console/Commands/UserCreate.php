<?php

namespace App\Console\Commands;

use Hash;
use Illuminate\Console\Command;

use Carbon\Carbon;

use App\User;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password?} {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

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
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password') ?: str_random(12);
        $admin = $this->option('admin');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'valid_until' => $admin ? null : Carbon::now()->addMonths(6),
        ]);

        if (empty($this->argument('password')))
            $this->comment(sprintf('Password: %s', $password));
    }
}

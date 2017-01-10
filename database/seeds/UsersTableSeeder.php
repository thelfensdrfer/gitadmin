<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'ttest',
            'name' => 'Tom Test',
            'email' => 'tomtest@example.com',
            'password' => Hash::make('123456'),
            'valid_until' => null,
            'admin' => true,
        ]);

        User::create([
            'username' => 'mmusterma',
            'name' => 'Max Mustermann',
            'email' => 'maxmustermann@example.com',
            'password' => Hash::make('123456'),
            'valid_until' => Carbon\Carbon::now()->addMonths(6),
        ]);

        User::create([
            'username' => 'invalid',
            'name' => 'Invalid user',
            'email' => 'invalid@example.com',
            'password' => Hash::make('123456'),
            'valid_until' => Carbon\Carbon::now()->subDay(),
        ]);
    }
}

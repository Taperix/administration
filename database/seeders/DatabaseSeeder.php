<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = User::factory()->create([
            'email' => 'lars.wiegers@taperix.com',
            'password' => Hash::make('yO$27$*z9njy@OJYEWvylo7')
        ]);
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'testuser\'s Team',
            'personal_team' => true
        ]);
        $this->call(InvoiceSeeder::class);
    }
}

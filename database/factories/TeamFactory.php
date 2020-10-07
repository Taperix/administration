<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(User::count() == 0) {
            User::factory()->create();
        }
        return [
            'name' => $this->faker->name,
            'personal_team' => 1,
            'user_id' => User::all()->random(1)->first()->id
        ];
    }
}

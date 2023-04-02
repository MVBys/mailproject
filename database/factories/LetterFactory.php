<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Letter>
 */
class LetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $userIds =  User::query()->pluck('id')->toArray();
        return [
//            'user_id'=>$this->faker->unique()->numberBetween(1),
            'user_id'=>$this->faker->randomElement($userIds),
            'recipient'=>$this->faker->email(),
            'img_token' => $this->faker->uuid(),
            'subject_letter'=>$this->faker->sentence(4),
            'last_open'=>$this->faker->dateTime(),
            'read_count'=>$this->faker->numberBetween(0,9),
        ];
    }
}

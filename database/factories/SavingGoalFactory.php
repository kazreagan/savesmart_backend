<?php

namespace Database\Factories;

use App\Models\SavingGoal;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingGoalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SavingGoal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'target_amount' => $this->faker->word,
        'deadline' => $this->faker->word,
        'is_completed' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

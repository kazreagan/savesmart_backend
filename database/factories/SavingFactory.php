<?php

namespace Database\Factories;

use App\Models\Saving;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Saving::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'target_amount' => $this->faker->word,
        'current_amount' => $this->faker->word,
        'target_date' => $this->faker->word,
        'description' => $this->faker->text,
        'user_id' => $this->faker->randomDigitNotNull
        ];
    }
}

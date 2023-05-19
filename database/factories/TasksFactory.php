<?php

namespace Database\Factories;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\Factory;

class TasksFactory extends Factory
{
    /**
     * Определение модели, связанной с фабрикой.
     *
     * @var string
     */
    protected $model = Tasks::class;

    /**
     * Определение значений атрибутов модели, сгенерированных фабрикой.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'application_id' => $this->faker->randomNumber(2),
            'master_id' => $this->faker->randomNumber(2),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
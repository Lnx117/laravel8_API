<?php

namespace Database\Factories;

use App\Models\Applications;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationsFactory extends Factory
{
    /**
     * Определение модели, связанной с фабрикой.
     *
     * @var string
     */
    protected $model = Applications::class;

    /**
     * Определение значений атрибутов модели, сгенерированных фабрикой.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bitrix_customer_id' => $this->faker->randomNumber(5),
            'customer_first_name' => $this->faker->name,
            'customer_last_name' => $this->faker->name,
            'customer_patronymic' => $this->faker->name,
            'customer_phone' => $this->faker->randomNumber(8),
            'app_city' => $this->faker->randomElement(['Москва', 'Питер', 'Берлин']),
            'app_street' => $this->faker->randomElement(['Поляны', 'Аалтайская', 'Вторая']),
            'app_house_number' => $this->faker->randomNumber(2),
            'app_house_building' => $this->faker->randomNumber(2),
            'app_flat_num' => $this->faker->randomNumber(2),
            'app_floor_num' => $this->faker->randomNumber(2),
            'app_house_entrance' => $this->faker->randomNumber(2),
            'app_created_at' => now(),
            'app_to_execute_at' => now()->addDays(7),
            'problem_text' => $this->faker->text(100),
            'master_id' => $this->faker->randomNumber(2),
            'app_status' => 'Принято',
        ];
    }
}
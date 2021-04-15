<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'qualification' => $this->faker->name,
            'educational_card_number' => $this->faker->bankAccountNumber,
            'educational_card_picture' => $this->faker->name,
            'class' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => '0121506261',
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'password' => 'password',
        ];
    }
}

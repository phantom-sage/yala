<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_name' => $this->faker->name,
            'phone_number' => '0121506261',
            'address' => $this->faker->name,
            'bank_name' => $this->faker->name,
            'account_number' => $this->faker->bankAccountNumber,
            'education_level' => $this->faker->name,
            'class' => $this->faker->name,
            'name' => $this->faker->name,
            'password' => 'password',
        ];
    }
}

<?php

namespace Tests\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Student;

class StudentControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    /**
     * Test store new student account
     * @test
     */
    public function store()
    {
        $this->post('/api/students', [
            'parent_name' => $this->faker->name,
            'phone_number' => 1912345678,
            'address' => $this->faker->address,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'education_level' => $this->faker->name,
            'class' => $this->faker->name,
            'name' => $this->faker->name,
            'password' => 'password',
        ])->assertOk()
        ->assertJson([
            'message' => 'New student created successfully',
        ]);

        $this->assertEquals(1, Student::count());
    }
}

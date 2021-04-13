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
     * Test case for index.
     * @test
     */
    public function index()
    {
        Student::factory()->count(3)->create();
        $this->getJson('/api/students')
            ->assertOk();
    }


    /**
     * Test case for show.
     * @test
     */
    public function show()
    {
        Student::factory()->count(1)->create();
        $id = Student::first()->id;
        $this->getJson("/api/students/$id")
            ->assertOk();
    }


    /**
     * Test store new student account
     * @test
     */
    public function store()
    {
        $this->postJson('/api/students', [
            'parent_name' => $this->faker->name,
            'phone_number' => 1912345678,
            'address' => $this->faker->address,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'education_level' => $this->faker->name,
            'class' => $this->faker->name,
            'name' => $this->faker->name,
            'password' => 'password',
        ])->assertOk();

        $this->assertEquals(1, Student::count());
    }


    /**
     * Test case for update.
     * @test
     */
    public function update()
    {
        $this->store();
        $this->assertDatabaseCount('students', 1);

        $id = Student::first()->id;
        $this->putJson("/api/students/$id", [
            'parent_name' => 'new parent name',
            'phone_number' => 1912345678,
            'address' => $this->faker->address,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'education_level' => $this->faker->name,
            'class' => $this->faker->name,
            'name' => $this->faker->name,
            'password' => 'password',
        ])->assertOk();
        $this->assertDatabaseCount('students', 1);
    }


    /**
     * Test case for destroy.
     * @test
     */
    public function destroy()
    {
        $this->store();
        $this->assertDatabaseCount('students', 1);


        $id = Student::first()->id;
        $this->deleteJson("/api/students/$id")
            ->assertOk();
        $this->assertDatabaseCount('students', 0);
    }
}

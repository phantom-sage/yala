<?php

namespace Tests\Unit;

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test case for create new teacher.
     * @test
     */
    public function create_new_teacher()
    {
        Teacher::create([
            'name' => $this->faker->name,
            'qualification' => $this->faker->name,
            'educational_card_number' => $this->faker->bankAccountNumber,
            'educational_card_picture' => 'pict.png',
            'class' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => 10123456789,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'password' => 'password',
        ]);

        $this->assertDatabaseCount('teachers', 1);
    }


    /**
     * Test case for delete teacher.
     * @test
     */
    public function delete_teacher()
    {
        Teacher::factory()->count(1)->create();
        $this->assertDatabaseCount('teachers', 1);

        $id = Teacher::first()->id;
        $teacher = Teacher::find($id);
        $teacher->delete();
        $this->assertDatabaseCount('teachers', 0);
    }


    /**
     * Test case for update teacher.
     * @test
     */
    public function update_teacher()
    {
        Teacher::factory()->count(1)->create();
        $this->assertDatabaseCount('teachers', 1);

        $id = Teacher::first()->id;
        Teacher::where('id', $id)
            ->update([
                'name' => 'new teacher name',
                'qualification' => $this->faker->name,
                'educational_card_number' => $this->faker->bankAccountNumber,
                'educational_card_picture' => 'pict.png',
                'class' => $this->faker->name,
                'address' => $this->faker->address,
                'phone_number' => 10123456789,
                'bank_name' => $this->faker->company,
                'account_number' => $this->faker->bankAccountNumber,
                'password' => 'password',
            ]);
        $this->assertDatabaseCount('teachers', 1);
        $this->assertEquals('new teacher name', Teacher::first()->name);
    }
}

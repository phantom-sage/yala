<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test case for create new student.
     * @test
     */
    public function create_new_student()
    {
        Student::create([
            'parent_name' => $this->faker->name,
            'phone_number' => 10123456789,
            'address' => $this->faker->title,
            'bank_name' => $this->faker->name,
            'account_number' => '34234-dfg-j',
            'education_level' => $this->faker->name,
            'class' => $this->faker->name,
            'name' => $this->faker->name,
            'password' => 'password',
        ]);

        $this->assertEquals(1, Student::count());
        $this->assertDatabaseCount('students', 1);
    }


    /**
     * Test case for delete student.
     * @test
     */
    public function delete_student()
    {
        Student::factory()->count(1)->create();
        $this->assertDatabaseCount('students', 1);

        $id = Student::first()->id;
        $student = Student::find($id);
        $student->delete();
        $this->assertDatabaseCount('students', 0);
    }


    /**
     * Test case for update student.
     * @test
     */
    public function update_student()
    {
        Student::factory()->count(1)->create();
        $this->assertDatabaseCount('students', 1);

        $id = Student::first()->id;
        Student::where('id', $id)
            ->update([
                'parent_name' => 'new parent name',
                'phone_number' => 10123456789,
                'address' => 'new address',
                'bank_name' => 'new bank name',
                'account_number' => '34234-dfg-j',
                'education_level' => 'new edu level',
                'class' => 'new class',
                'name' => 'new name',
                'password' => 'new password',
            ]);
        $this->assertDatabaseCount('students', 1);

        $this->assertEquals('new parent name', Student::first()->parent_name);
    }
}

<?php

namespace Tests\Api;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TeacherControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test case for index.
     * @test
     */
    public function index()
    {
        Teacher::factory()->count(5)->create();
        $this->getJson('/api/teachers')
            ->assertOk();
    }


    /**
     * Test case for show.
     * @test
     */
    public function show()
    {
        $this->withoutExceptionHandling();
        $this->store();

        $this->assertDatabaseCount('subjects', 1);

        $id = Subject::first()->id;
        $this->getJson("/api/subjects/$id")
            ->assertOk();
    }


    /**
     * Test case for create new teacher.
     * @test
     */
    public function store()
    {
        $this->withoutExceptionHandling();

        Subject::factory()->count(1)->create();

        Storage::fake('profiles');
        $file = UploadedFile::fake()->image('profile.jpg');

        $this->postJson('/api/teachers', [
            'name' => $this->faker->name,
            'qualification' => $this->faker->name,
            'educational_card_number' => $this->faker->bankAccountNumber,
            'educational_card_picture' => $file,
            'class' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => 1234567891,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'password' => 'password',
            'subject_id' => Subject::first()->id,
        ])->assertOk();

        $this->assertEquals(1, Teacher::count());
        $this->assertEquals(1, Subject::count());
        Storage::disk('public')->assertExists('profiles/' . $file->hashName());
        $this->assertNotNull(Subject::first()->teacher_id);
        $this->assertEquals(Teacher::first()->id, Subject::first()->teacher_id);
    }


    /**
     * Test case for updated teacher.
     * @test
     */
    public function update()
    {
        $this->store();

        $this->withoutExceptionHandling();

        Storage::fake('profiles');
        $file = UploadedFile::fake()->image('profile.jpg');
        $id = Teacher::first()->id;

        $this->putJson("/api/teachers/$id", [
            'name' => $this->faker->name,
            'qualification' => $this->faker->name,
            'educational_card_number' => $this->faker->bankAccountNumber,
            'educational_card_picture' => $file,
            'class' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => 1234567891,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'password' => 'password',
            'subject_id' => Subject::first()->id,
        ])->assertOk();

        $this->assertEquals(1, Teacher::count());
        $this->assertEquals(1, Subject::count());
        Storage::disk('public')->assertExists('profiles/' . $file->hashName());
        $this->assertNotNull(Subject::first()->teacher_id);
        $this->assertEquals(Teacher::first()->id, Subject::first()->teacher_id);
    }


    /**
     * Test case for destroy.
     * @test
     */
    public function destroy()
    {
        $this->store();
        $this->assertDatabaseCount('teachers', 1);
        $id = Teacher::first()->id;
        $this->deleteJson("/api/teachers/$id")
            ->assertOk();
        $this->assertDatabaseCount('teachers', 0);
    }
}

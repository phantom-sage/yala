<?php

namespace Tests\Api;

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
     * Test create new teacher.
     * @test
     */
    public function store()
    {
        $this->withoutExceptionHandling();

        Storage::fake('profiles');
        $file = UploadedFile::fake()->image('profile.jpg');

        $this->post('/api/teachers', [
            'name' => $this->faker->name,
            'qualification' => $this->faker->name,
            'educational_card_number' => $this->faker->bankAccountNumber,
            'educational_card_picture' => $file,
            'class' => $this->faker->name,
            'subject' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => 1234567891,
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'password' => 'password',
        ])->assertOk();

        $this->assertEquals(1, Teacher::count());
        Storage::disk('public')->assertExists('profiles/' . $file->hashName());
    }
}

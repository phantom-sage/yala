<?php

namespace Tests\Api;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LessonControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test store new lesson without any pictures.
     * @test
     */
    public function store_with_pictures()
    {
        $this->withoutExceptionHandling();

        Storage::fake('pictures');
        $file = UploadedFile::fake()->image('profile.jpg');
        $file2 = UploadedFile::fake()->image('profile.jpg');

        $this->post('/api/lessons', [
            'title' => $this->faker->title,
            'description' => $this->faker->text(200),
            'pictures' => [$file, $file2],
        ])->assertOk();

        $this->assertEquals(1, Lesson::count());
        Storage::disk('public')->assertExists('pictures/' . $file->hashName());
    }


    /**
     * Test show single lesson.
     * @test
     */
    public function show()
    {
        Lesson::factory()->count(1)->create();
        $id = Lesson::first()->id;
        $this->get("/api/lessons/$id")->assertOk()
        ->assertJsonStructure([
            'data' => [
                'title',
                'description',
            ]
        ]);
    }
}

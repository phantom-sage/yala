<?php

namespace Tests\Api;

use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LessonControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test case for index.
     * @test
     */
    public function index()
    {
        Lesson::factory()->count(10)->create();
        $this->assertDatabaseCount('lessons', 10);
        $this->getJson('/api/lessons')->assertOk();
    }


    /**
     * Test case for show.
     * @test
     */
    public function show()
    {
        Lesson::factory()->count(1)->create();
        $id = Lesson::first()->id;
        $this->getJson("/api/lessons/$id")->assertOk();
    }


    /**
     * Test case for store.
     * @test
     */
    public function store()
    {
        $this->withExceptionHandling();
        Storage::fake('pictures');
        $file_1 = UploadedFile::fake()->image('lesson1.jpg');
        $file_2 = UploadedFile::fake()->image('lesson2.jpg');
        $file_3 = UploadedFile::fake()->image('lesson3.jpg');

        Subject::factory()->count(1)->create();

        $this->postJson('/api/lessons', [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'pictures' => [$file_1, $file_2, $file_3],
            'subject_id' => Subject::first()->id,
        ])->assertOk();

        $this->assertDatabaseCount('lessons', 1);
        $this->assertDatabaseCount('subjects', 1);
        $this->assertEquals(Subject::first()->id, Lesson::first()->id);
        Storage::disk('public')->assertExists('pictures/' . $file_1->hashName());
        Storage::disk('public')->assertExists('pictures/' . $file_2->hashName());
        Storage::disk('public')->assertExists('pictures/' . $file_3->hashName());
    }


    /**
     * Test case for update.
     * @test
     */
    public function update()
    {
        $this->store();

        $this->withExceptionHandling();
        Storage::fake('pictures');
        $file_1 = UploadedFile::fake()->image('lesson1.jpg');
        $file_2 = UploadedFile::fake()->image('lesson2.jpg');
        $file_3 = UploadedFile::fake()->image('lesson3.jpg');


        $id = Lesson::first()->id;
        $this->putJson("/api/lessons/$id", [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'pictures' => [$file_1, $file_2, $file_3],
            'subject_id' => Subject::first()->id,
        ])->assertOk();

        $this->assertDatabaseCount('lessons', 1);
        $this->assertDatabaseCount('subjects', 1);
        $this->assertDatabaseCount('pictures', 3);
        $this->assertEquals(Subject::first()->id, Lesson::first()->id);
        Storage::disk('public')->assertExists('pictures/' . $file_1->hashName());
        Storage::disk('public')->assertExists('pictures/' . $file_2->hashName());
        Storage::disk('public')->assertExists('pictures/' . $file_3->hashName());
    }


    /**
     * Test case for destroy.
     * @test
     */
    public function destroy()
    {
        $this->store();
        $id = Lesson::first()->id;
        $this->deleteJson("/api/lessons/$id")->assertOk();
        $this->assertDatabaseCount('lessons', 0);
        $this->assertDatabaseCount('pictures', 0);
    }


    /**
     * Test case for add quiz to lesson.
     * @test
     */
    public function add_quiz_to_lesson()
    {
        $lesson_data = array(
            'options' => array(
                'a- Fire',
                'b- Wood',
                'c- Cargo',
                'd- None'
            ),
            'right_answer' => 'b- wood'
        );
        $lesson_data = json_encode($lesson_data);

        Lesson::factory()->count(1)->create();
        $this->assertDatabaseCount('lessons', 1);
        $id = Lesson::first()->id;
        $this->putJson("/api/lessons/add-quiz-to-lesson/$id", [
            'quiz' => $lesson_data,
        ])->assertOk();

        $this->assertDatabaseCount('lessons', 1);
    }
}

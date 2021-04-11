<?php

namespace Tests\Unit;

use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test case for create new quiz record.
     * @test
     */
    public function create_new_quiz()
    {
        $quiz = new Quiz();
        $quiz->title = $this->faker->title;
        $quiz->content = $this->faker->text;
        $quiz->save();

        $this->assertDatabaseCount('quizzes', 1);
    }
}

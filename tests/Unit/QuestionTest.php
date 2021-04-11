<?php

namespace Tests\Unit;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test case for create new question recrod.
     * @test
     */
    public function create_new_question()
    {
        $question = new Question();
        $question->title = $this->faker->title;
        $question->save();

        $this->assertDatabaseCount('questions', 1);
    }


    /**
     * Test case for adding option id to question.
     * @test
     */
    public function add_option_id_to_question()
    {
        Option::factory()->count(1)->create();
        $question = new Question();
        $question->title = $this->faker->title;
        $question->option_id = Option::first()->id;
        $question->save();

        $this->assertDatabaseCount('options', 1);
        $this->assertDatabaseCount('questions', 1);

    }
}

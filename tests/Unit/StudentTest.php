<?php

namespace Tests\Unit;

use App\Models\Option;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test case for student answer question.
     * @test
     */
    public function student_answer_question()
    {
        // student answer question
        Student::factory()->count(1)->create();
        Question::factory()->count(1)->create();
        Option::factory()->count(1)->create();

        $question = Question::first();
        $question->option_id = Option::first()->id;
        $question->save();
        $this->assertEquals(Question::first()->option_id, Option::first()->id);


        # student answer
        $student = Student::first();
        $student->options()->attach(Option::first()->id);
        $this->assertEquals(1, $student->options[0]->id);

        # Assert records inserted successfully.
        $this->assertDatabaseCount('students', 1);
        $this->assertDatabaseCount('questions', 1);
        $this->assertDatabaseCount('options', 1);
    }
}

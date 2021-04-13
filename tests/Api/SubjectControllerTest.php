<?php

namespace Tests\Api;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubjectControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Assign teacher to subject.
     * @test
     */
    public function assign_teacher_to_subject()
    {
        Teacher::factory()->count(1)->create();

        $this->postJson('/api/subjects', [
            'name' => $this->faker->name,
            'teacher_id' => Teacher::first()->id,
        ])
            ->assertOk();

        $this->assertEquals(Subject::first()->teacher_id, Teacher::first()->id);
        $this->assertDatabaseCount('teachers', 1);
        $this->assertDatabaseCount('subjects', 1);
    }

    /**
     * Test case for index.
     * @test
     */
    public function index()
    {
        Subject::factory()->count(3)->create();
        $this->assertDatabaseCount('subjects', 3);
        $this->getJson('/api/subjects')
            ->assertOk();
    }


    /**
     * Test case for show.
     * @test
     */
    public function show()
    {
        Subject::factory()->count(1)->create();
        $this->assertDatabaseCount('subjects', 1);

        $id = Subject::first()->id;
        $this->getJson("/api/subjects/$id")
            ->assertOk();
    }

    /**
     * Test case for store.
     * @test
     */
    public function store()
    {
        $this->withoutExceptionHandling();
        $this->postJson('/api/subjects', [
            'name' => $this->faker->name,
        ])->assertOk();
        $this->assertDatabaseCount('subjects', 1);
    }


    /**
     * Test case for update.
     * @test
     */
    public function update()
    {
        $this->withoutExceptionHandling();

        $this->store();
        $this->assertDatabaseCount('subjects', 1);

        $id = Subject::first()->id;
        $this->putJson("/api/subjects/$id", [
            'name' => 'new name',
        ])->assertOk();
        $this->assertDatabaseCount('subjects', 1);
        $this->assertEquals('new name', Subject::first()->name);
    }

    /**
     * Test case for destroy.
     * @test
     */
    public function destroy()
    {
        $this->withoutExceptionHandling();
        $this->store();
        $this->assertDatabaseCount('subjects', 1);

        $id = Subject::first()->id;
        $this->deleteJson("/api/subjects/$id")
            ->assertOk();

        $this->assertDatabaseCount('subjects', 0);
    }
}

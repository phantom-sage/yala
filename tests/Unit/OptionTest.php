<?php

namespace Tests\Unit;

use App\Models\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OptionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test case for create new option.
     * @test
     */
    public function create_new_option()
    {
        $option = new Option();
        $option->option = $this->faker->title;
        $option->save();

        $this->assertDatabaseCount('options', 1);
    }
}

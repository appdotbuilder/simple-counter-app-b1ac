<?php

namespace Tests\Feature;

use App\Models\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_counter_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                 ->has('count')
        );
    }

    public function test_counter_starts_at_zero(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->where('count', 0)
        );
    }

    public function test_counter_can_be_incremented(): void
    {
        // Create initial counter
        Counter::create(['count' => 5]);

        $response = $this->post('/', []);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                 ->where('count', 6)
        );

        $this->assertDatabaseHas('counters', [
            'count' => 6
        ]);
    }

    public function test_counter_persists_between_requests(): void
    {
        // Increment counter multiple times
        $this->post('/', []);
        $this->post('/', []);
        $this->post('/', []);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->where('count', 3)
        );
    }

    public function test_counter_creates_record_if_none_exists(): void
    {
        // Ensure no counter exists
        $this->assertDatabaseCount('counters', 0);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->where('count', 0)
        );

        $this->assertDatabaseCount('counters', 1);
        $this->assertDatabaseHas('counters', [
            'count' => 0
        ]);
    }
}
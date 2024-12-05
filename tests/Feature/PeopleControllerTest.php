<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\People;
use Illuminate\Support\Str;

class PeopleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_people_with_pagination()
    {
        // Create 10 test people
        $people = People::factory()->count(10)->create();

        // Make a GET request to the endpoint
        $response = $this->getJson('/api/people');

        // Check the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'first_name', 'last_name', 'created_at', 'updated_at']
                ]
            ]);

        // Verify the number of results
        $this->assertCount(10, $response->json('data'));
    }

    public function test_index_filters_by_first_name()
    {
        // Create people with different first names
        People::factory()->create(['first_name' => 'John']);
        People::factory()->create(['first_name' => 'Bjone']);
        People::factory()->create(['first_name' => 'Bob']);

        // Filter by first name
        $response = $this->getJson('/api/people?first_name=Jo');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['first_name' => 'John'])
            ->assertJsonFragment(['first_name' => 'Bjone']);
    }

    public function test_index_filters_by_last_name()
    {
        // Create people with different last names
        People::factory()->create(['last_name' => 'Martin']);
        People::factory()->create(['last_name' => 'Tino']);
        People::factory()->create(['last_name' => 'Martie']);

        // Test cases with filters and expected results
        $testCases = [
            ['filter' => 'Tin', 'expected' => ['Martin', 'Tino']],
            ['filter' => 'Mar', 'expected' => ['Martin', 'Martie']],
        ];

        foreach ($testCases as $case) {
            $response = $this->getJson("/api/people?last_name={$case['filter']}");

            $response->assertStatus(200)
                ->assertJsonCount(count($case['expected']), 'data');

            foreach ($case['expected'] as $expectedlast_name) {
                $response->assertJsonFragment(['last_name' => $expectedlast_name]);
            }
        }
    }

    public function test_store_creates_new_person_with_validation()
    {
        $personData = [
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $response = $this->postJson('/api/people', $personData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'created_at',
                'updated_at'
            ])
            ->assertJson($personData);

        $this->assertDatabaseHas('people', $personData);
    }

    public function test_store_fails_with_invalid_data()
    {
        $invalidData = [
            'first_name' => '',
            'last_name' => ''
        ];

        $response = $this->postJson('/api/people', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name']);
    }

    public function test_show_returns_single_person()
    {
        $people = People::factory()->create();

        $response = $this->getJson("/api/people/{$people->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'created_at',
                'updated_at'
            ])
            ->assertJson([
                'id' => $people->id,
                'first_name' => $people->first_name,
                'last_name' => $people->last_name
            ]);
    }

    public function test_show_returns_404_for_nonexistent_person()
    {
        $nonExistentId = Str::uuid();

        $response = $this->getJson("/api/people/{$nonExistentId}");

        $response->assertStatus(404);
    }

    public function test_update_modifies_person_with_partial_data()
    {
        $people = People::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        $updateData = ['first_name' => 'Jane'];

        $response = $this->putJson("/api/people/{$people->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'first_name' => 'Jane',
                'last_name' => 'Doe'
            ]);

        $this->assertDatabaseHas('people', [
            'id' => $people->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe'
        ]);
    }

    public function test_update_fails_with_invalid_data()
    {
        $people = People::factory()->create();

        $invalidData = [
            'first_name' => '',
        ];

        $response = $this->putJson("/api/people/{$people->id}", $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name']);
    }

    public function test_destroy_deletes_person()
    {
        $people = People::factory()->create();

        $response = $this->deleteJson("/api/people/{$people->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('people', ['id' => $people->id]);
    }

    public function test_destroy_fails_for_nonexistent_person()
    {
        $nonExistentId = Str::uuid();

        $response = $this->deleteJson("/api/people/{$nonExistentId}");

        $response->assertStatus(404);
    }
}

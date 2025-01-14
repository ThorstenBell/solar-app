<?php

namespace Tests\Unit;

use App\Models\Installation;
use Tests\TestCase;

class InstallationTest extends TestCase
{
    public function test_store_creates_installation()
    {
        $data = [
            'name' => 'New Installation',
            'color' => '#EAEAEA',
        ];

        $response = $this->postJson('/api/v1/installation', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'color'
            ],
            'message',
        ]);

        $this->assertDatabaseHas('installations', [
            'name' => 'New Installation',
            'color' => '#EAEAEA',
        ]);

        $installation = Installation::where('name', 'New Installation')->first();
        if ($installation) {
            $installation->delete();
        }
    }

    public function test_store_validation_fails_for_missing_name_field()
    {
        $data = [
            'name' => '',
            'color' => '#000000',
        ];

        $response = $this->postJson('/api/v1/installation', $data);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => 'The name field is required.',
        ]);
    }
}

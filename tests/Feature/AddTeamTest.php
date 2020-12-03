<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddTeamTest extends TestCase
{
    /** @test */
    public function canAddTeams()
    {
        Storage::fake();

        $response = $this->postJson('/api/core/teams', [
            'name' => 'Test Name',
            'logo' => UploadedFile::fake()->image('logo.jpg'),
            'description' => 'Test Team Description',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Name',
                'description' => 'Test Team Description',
            ]);
        $this->assertCount(1, Team::all());
        tap(Team::first(), function ($team) {
            $this->assertEquals('Test Name', $team->name);
            $this->assertEquals('Test Team Description', $team->description);
            Storage::disk('public')->assertExists($team->logo);
        });
    }

    /** @test */
    public function nameIsRequired()
    {
        Storage::fake();

        $response = $this->postJson('/api/core/teams', [
            'logo' => UploadedFile::fake()->image('logo.jpg'),
            'description' => 'Test Team Description',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
        $this->assertCount(0, Team::all());
    }

    /** @test */
    public function descriptionIsOptional()
    {
        $this->withoutExceptionHandling();

        Storage::fake();

        $response = $this->postJson('/api/core/teams', [
            'name' => 'Test Name',
            'logo' => UploadedFile::fake()->image('logo.jpg'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Name',
            ]);
        $this->assertCount(1, Team::all());
        tap(Team::first(), function ($team) {
            $this->assertEquals('Test Name', $team->name);
            $this->assertNull($team->description);
            Storage::disk('public')->assertExists($team->logo);
        });
    }

    /** @test */
    public function logoIsOptional()
    {
        $this->withoutExceptionHandling();
        
        Storage::fake();

        $response = $this->postJson('/api/core/teams', [
            'name' => 'Test Name',
            'description' => 'Test Description',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Name',
                'description' => 'Test Description',
            ]);
        $this->assertCount(1, Team::all());
        tap(Team::first(), function ($team) {
            $this->assertEquals('Test Name', $team->name);
            $this->assertEquals('Test Description', $team->description);
            $this->assertNull($team->logo);
        });
    }
}

<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddPlayerTest extends TestCase
{
    /** @test */
    public function canAddPlayer()
    {
        $this->withoutExceptionHandling();

        Storage::fake();

        $team = Team::factory()->create();

        $response = $this->postJson("/api/core/teams/{$team->id}/players", [
            'first_name' => 'First',
            'last_name' => 'Last',
            'birthdate' => '1993-11-27',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'first_name' => 'First',
                'last_name' => 'Last',
                'team_id' => $team->id,
            ]);
        $this->assertCount(1, Player::all());
        tap(Player::first(), function ($player) use ($team) {
            $this->assertEquals('First', $player->first_name);
            $this->assertEquals('Last', $player->last_name);
            $this->assertTrue($player->birthdate->equalTo(Carbon::parse('1993-11-27')));
            $this->assertTrue($player->team->is($team));
            Storage::disk('public')->assertExists($team->photo);
        });
    }

    /** @test */
    public function firstNameIsRequired()
    {
        Storage::fake();

        $team = Team::factory()->create();

        $response = $this->postJson("/api/core/teams/{$team->id}/players", [
            'last_name' => 'Last',
            'birthdate' => '1993-11-27',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('first_name');
        $this->assertCount(0, Player::all());
    }

    /** @test */
    public function lastNameIsRequired()
    {
        Storage::fake();

        $team = Team::factory()->create();

        $response = $this->postJson("/api/core/teams/{$team->id}/players", [
            'first_name' => 'First',
            'birthdate' => '1993-11-27',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('last_name');
        $this->assertCount(0, Player::all());
    }

    /** @test */
    public function birthIsRequired()
    {
        Storage::fake();

        $team = Team::factory()->create();

        $response = $this->postJson("/api/core/teams/{$team->id}/players", [
            'first_name' => 'First',
            'last_name' => 'Last',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('birthdate');
        $this->assertCount(0, Player::all());
    }

    /** @test */
    public function photoIsRequired()
    {
        Storage::fake();

        $team = Team::factory()->create();

        $response = $this->postJson("/api/core/teams/{$team->id}/players", [
            'first_name' => 'First',
            'last_name' => 'Last',
            'birthdate' => '1993-11-27',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('photo');
        $this->assertCount(0, Player::all());
    }
}

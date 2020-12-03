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

class UpdatePlayerTest extends TestCase
{
    /** @test */
    public function canUpdatePlayer()
    {
        $this->withoutExceptionHandling();

        Storage::fake();

        $photoPath = UploadedFile::fake()->image('photo.jpg')->store('photos', 'public');
        $team = Team::factory()->create();
        $player = Player::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => Carbon::parse('1995-10-10'),
            'photo' => $photoPath,
            'team_id' => $team->id,
        ]);

        $response = $this->postJson("/api/core/teams/{$team->id}/players/{$player->id}/edit", [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'birthdate' => '1996-11-11',
            'photo' => UploadedFile::fake()->image('new-photo.jpg'),
        ]);

        $response->assertStatus(200);
        tap($player->fresh(), function ($player) use ($photoPath) {
            $this->assertEquals($player->first_name, 'Updated First Name');
            $this->assertEquals($player->last_name, 'Updated Last Name');
            $this->assertTrue(Carbon::parse('1996-11-11')->equalTo($player->birthdate));
            $this->assertNotEquals($photoPath, $player->photo);
            Storage::disk('public')->assertExists($player->photo);
        });
    }
}

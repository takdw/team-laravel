<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePlayerTest extends TestCase
{
    /** @test */
    public function canUpdatePlayer()
    {
        $this->withoutExceptionHandling();

        $team = Team::factory()->create();
        $player = Player::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => Carbon::parse('1995-10-10'),
            'photo' => 'old_path',
            'team_id' => $team->id,
        ]);

        $response = $this->postJson("/api/v1/teams/{$team->id}/players/{$player->id}/edit", [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'birthdate' => '1996-11-11',
            'photo' => 'new_path',
        ]);

        $response->assertStatus(200);
        tap($player->fresh(), function ($player) {
            $this->assertEquals($player->first_name, 'Updated First Name');
            $this->assertEquals($player->last_name, 'Updated Last Name');
            $this->assertTrue(Carbon::parse('1996-11-11')->equalTo($player->birthdate));
            $this->assertEquals($player->photo, 'new_path');
        });
    }
}

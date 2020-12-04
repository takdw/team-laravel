<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamsTest extends TestCase
{
    /** @test */
    public function aTeamHasPlayers()
    {
        $team = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $team->id]);

        $this->assertCount(1, $team->players);
        $this->assertTrue($team->players->first()->is($player));
    }

    /** @test */
    public function gettingTeams()
    {
        $team = Team::factory()->create([
            'name' => 'Kickass Team',
        ]);

        $this->getJson("/api/v1/teams/{$team->id}")
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Kickass Team',
            ]);
    }

    /** @test */
    public function canLoadPlayersWithTeam()
    {
        $team = Team::factory()->create([
            'name' => 'Kickass Team',
        ]);

        $this->getJson("/api/v1/teams/{$team->id}?with=players")
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Kickass Team',
                'players' => [],
            ]);
    }

    /** @test */
    public function gettingTeamPlayers()
    {
        $team = Team::factory()->create();
        $playerA = Player::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'team_id' => $team->id,
        ]);
        $playerB = Player::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'team_id' => $team->id,
        ]);

        $this->getJson("/api/v1/teams/{$team->id}/players")
            ->assertStatus(200)
            ->assertJson([
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
                [
                    'first_name' => 'Jane',
                    'last_name' => 'Doe',
                ]
            ]);
    }
}

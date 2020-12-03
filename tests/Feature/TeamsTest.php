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
}

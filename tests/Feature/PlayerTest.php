<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    /** @test */
    public function aPlayerBelongsToATeam()
    {
        $team = Team::factory()->create();
        $player = Player::factory()->create([
            'team_id' => $team->id,
        ]);

        $this->assertTrue($player->team->is($team));
    }
}

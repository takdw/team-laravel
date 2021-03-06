<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamPlayerController extends Controller
{
    public function index(Team $team)
    {
        return response()->json($team->players, 200);
    }

    public function show(Team $team, Player $player)
    {
        return response()->json($player, 200);
    }
    
    public function store(Team $team)
    {
        request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'birthdate' => ['required'],
            'photo' => ['required'],
        ]);

        $player = $team->players()->create([
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'birthdate' => request()->birthdate,
            'photo' => request()->photo,
        ]);

        return response()->json($player, 201);
    }

    public function update(Team $team, Player $player)
    {
        $validated = request()->validate([
            'first_name' => ['required', 'sometimes'],
            'last_name' => ['required', 'sometimes'],
            'birthdate' => ['required', 'sometimes'],
            'photo' => ['required', 'sometimes'],
        ]);

        $player->update($validated);

        return response()->json($player, 200);
    }
}

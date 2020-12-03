<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamPlayerController extends Controller
{
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
            'photo' => request()->photo->store('photos', 'public'),
        ]);

        return response()->json($player, 201);
    }
}

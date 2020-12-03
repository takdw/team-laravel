<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function store()
    {
        request()->validate([
            'name' => ['required'],
        ]);

        $hasLogo = request()->has('logo') && request()->logo;

        $team = Team::create([
            'name' => request()->name,
            'description' => request()->description,
            'logo' => $hasLogo ? request()->logo->store('logos', 'public') : null,
        ]);

        return response()->json($team, 201);
    }
}
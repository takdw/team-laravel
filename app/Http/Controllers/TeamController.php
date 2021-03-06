<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json(Team::all(), 200);
    }
    
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

    public function show(Team $team)
    {
        $allowedIncludes = ['players'];

        if (request()->has('with')) {
            $loads = explode(',', request()->with);
            foreach ($loads as $load) {
                if (array_search($load, $allowedIncludes) !== false) {
                    $team->load($load);
                }
            }
        }

        return response()->json($team, 200);
    }
}

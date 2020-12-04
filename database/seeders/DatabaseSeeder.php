<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $og = Team::factory()->create([
            'name' => 'OG',
        ]);

        Team::factory()->create(['name' => 'Liquid']);
        Team::factory()->create(['name' => 'Secret']);
        Team::factory()->create(['name' => 'Natus Vincere']);
        Team::factory()->create(['name' => 'Virtus Pro']);

        $ana = Player::factory()->create([
            'team_id' => $og->id,
            'first_name' => 'Anathan "ana"',
            'last_name' => 'Pham',
            'birthdate' => Carbon::parse('1999-10-26'),
            'photo' => 'https://res.cloudinary.com/ika/image/upload/v1607044776/dnhyjymzac51klp7xncv.jpg',
        ]);

        $ceb = Player::factory()->create([
            'team_id' => $og->id,
            'first_name' => 'Sébastien "Ceb"',
            'last_name' => 'Debs',
            'birthdate' => Carbon::parse('1992-05-11'),
            'photo' => 'https://res.cloudinary.com/ika/image/upload/v1607044695/wptzn7rrsxzfipskpay8.jpg',
        ]);

        $topson = Player::factory()->create([
            'team_id' => $og->id,
            'first_name' => 'Topias "Topson"',
            'last_name' => 'Taavitsainen',
            'birthdate' => Carbon::parse('1998-04-14'),
            'photo' => 'https://res.cloudinary.com/ika/image/upload/v1607044613/bko5gwzotzfmn8z3gzfr.jpg',
        ]);

        $jerax = Player::factory()->create([
            'team_id' => $og->id,
            'first_name' => 'Jesse "JerAx"',
            'last_name' => 'Vainikka',
            'birthdate' => Carbon::parse('1992-05-07'),
            'photo' => 'https://res.cloudinary.com/ika/image/upload/v1607040278/ru4inssnqcraawfqbf6n.jpg',
        ]);

        $n0tail = Player::factory()->create([
            'team_id' => $og->id,
            'first_name' => 'Johan "N0tail"',
            'last_name' => 'Sundstein',
            'birthdate' => Carbon::parse('1993-10-08'),
            'photo' => 'https://res.cloudinary.com/ika/image/upload/v1607038576/etw4fhdpr6mgye10hk6e.jpg',
        ]);
    }
}

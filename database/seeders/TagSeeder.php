<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Action', 'RPG', 'FPS', 'Battle Royale', 'Open World',
            'Strategy', 'Simulation', 'Horror', 'Multiplayer', 'Single Player',
            'Indie', 'AAA', 'MMO', 'MOBA', 'Fighting',
        ];

        foreach ($tags as $name) {
            Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}

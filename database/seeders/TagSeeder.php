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
            'Adventure', 'Racing', 'Sports', 'Puzzle', 'Platformer',
            'Roguelike', 'Sandbox', 'Survival', 'Stealth', 'Rhythm',
            'Visual Novel', 'Tower Defense', 'Card Game', 'Party Game',
            'Casual', 'Arcade', 'Retro', 'VR', 'Cross-Platform',
            'Free to Play', 'Co-op', 'PvP', 'Story-Rich', 'Fantasy',
            'Sci-Fi', 'Cyberpunk', 'Zombie', 'Anime', 'Pixel Art',
            'Soulslike', 'Metroidvania', 'City Builder', 'Deckbuilder',
            'Looter Shooter', 'Tactical', 'Turn-Based', 'Real-Time',
            'Hack and Slash', 'Hero Shooter', 'Tactical Shooter',
        ];

        foreach ($tags as $name) {
            Tag::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}

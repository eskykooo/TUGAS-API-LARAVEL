<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'PC Gaming', 'slug' => 'pc-gaming', 'description' => 'Berita dan review seputar gaming PC, hardware, dan aksesoris'],
            ['name' => 'Console', 'slug' => 'console', 'description' => 'Informasi terbaru PlayStation, Xbox, Nintendo, dan konsol lainnya'],
            ['name' => 'Mobile', 'slug' => 'mobile', 'description' => 'Game mobile terpopuler dan tips trik bermain di perangkat seluler'],
            ['name' => 'E-Sports', 'slug' => 'esports', 'description' => 'Turnamen, tim, dan berita kompetisi esports nasional dan internasional'],
            ['name' => 'Reviews', 'slug' => 'reviews', 'description' => 'Review mendalam game-game terbaru dari berbagai platform'],
            ['name' => 'Guides', 'slug' => 'guides', 'description' => 'Panduan dan tips bermain game untuk pemula hingga pro'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}

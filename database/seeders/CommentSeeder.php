<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            ['title_like' => '%RTX 5090%', 'content' => 'Harganya bikin kantong bolong tapi performanya gila banget. Mimin, kapan ada review buat yang budget 10 jutaan?'],
            ['title_like' => '%RTX 5090%', 'content' => 'DLSS 4 kedengarannya revolusioner. Tapi apa benar bisa 2x lipat frame rate tanpa turun kualitas?'],
            ['title_like' => '%PlayStation 6%', 'content' => 'PS5 aja belum punya, udah ngomongin PS6 aja. Tapi seru juga lihat bocoran spesifikasinya.'],
            ['title_like' => '%PlayStation 6%', 'content' => 'Semoga backward compatibility-nya benar-benar seamless. Koleksi game PS5 gue jangan sia-sia.'],
            ['title_like' => '%Nintendo Switch 2%', 'content' => 'Akhirnya! Joy-con anti drift adalah fitur terbaik menurut gue. Nintendo dengerin keluhan pengguna juga.'],
            ['title_like' => '%Nintendo Switch 2%', 'content' => 'Zelda Tears of the Kingdom Director Cut? Langsung pre-order gue. Semoga harganya masuk akal di Indonesia.'],
            ['title_like' => '%Mobile Legends%', 'content' => 'Lunox kelihatannya OP banget. Pasti bakal kena nerf dalam 2 minggu ke depan.'],
            ['title_like' => '%Mobile Legends%', 'content' => 'Akhirnya Zilong di-rework. Udah lama banget hero ini jadi meme di ranked.'],
            ['title_like' => '%Genshin%', 'content' => 'Natlan keren banget! Tapi mending nabung primogem dulu buat Mavuika.'],
            ['title_like' => '%Genshin%', 'content' => 'Artifact farming yang lebih ramah? Akhirnya Hoyo dengerin keluhan pemain!'],
            ['title_like' => '%EVO 2026%', 'content' => 'Gue nonton live dan nangis pas GarudaFist menang. Bangga jadi orang Indonesia!'],
            ['title_like' => '%EVO 2026%', 'content' => 'Ini baru prestasi. Semoga pemerintah sadar bahwa esports butuh dukungan serius.'],
            ['title_like' => '%ONIC%', 'content' => 'Grand final 7 game yang luar biasa. ONIC pantas juara, tapi RRQ juga main bagus.'],
            ['title_like' => '%ONIC%', 'content' => 'Kairi MVP ternyata. Performa Lunox-nya bikin merinding.'],
            ['title_like' => '%Elden Ring%', 'content' => 'Shadow of the Erdtree benar-benar masterpiece. 100 jam lebih gue habisin untuk explore semua area.'],
            ['title_like' => '%Elden Ring%', 'content' => 'Boss Messmer the Impaler adalah boss terbaik yang pernah gue lawan. Desain dan moveset-nya brilliant.'],
            ['title_like' => '%Hollow Knight%', 'content' => 'Silksong akhirnya rilis dan gue udah 50 jam main. Worth the wait banget!'],
            ['title_like' => '%Hollow Knight%', 'content' => 'Soundtrack-nya bikin merinding. Christopher Larkin emang jenius.'],
            ['title_like' => '%Valorant%', 'content' => 'Guide yang bagus banget. Tips aim training-nya gue terapin dan rank naik dari Gold ke Platinum dalam 2 minggu.'],
            ['title_like' => '%Free Fire%', 'content' => 'Akhirnya ada guide FF yang proper. Selama ini susah cari konten ranked FF yang bener.'],
            ['title_like' => '%Free Fire%', 'content' => 'Tips rotasi di late game itu paling berguna. Gue sering kena third party gara-gara keburu push.'],
        ];

        $users = User::where('role', '!=', 'admin')->get();

        foreach ($comments as $item) {
            $articles = Article::where('title', 'like', $item['title_like'])->get();
            foreach ($articles as $article) {
                Comment::create([
                    'article_id' => $article->id,
                    'user_id' => $users->random()->id,
                    'content' => $item['content'],
                    'status' => 'approved',
                ]);
            }
        }

        $articlesWithout = Article::whereDoesntHave('comments')->get();
        foreach ($articlesWithout as $article) {
            Comment::factory(rand(2, 3))->create([
                'article_id' => $article->id,
                'user_id' => $users->random()->id,
                'status' => 'approved',
            ]);
        }
    }
}

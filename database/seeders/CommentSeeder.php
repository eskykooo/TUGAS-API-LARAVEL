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
            ['title_like' => '%Laravel%', 'content' => 'Artikel yang sangat membantu! Saya baru saja bermigrasi dari Laravel 10 dan penjelasan soal perubahan struktur folder-nya sangat jelas.'],
            ['title_like' => '%Laravel%', 'content' => 'Terima kasih sudah berbagi. Fitur SQLite sebagai default memang mengejutkan tapi masuk akal untuk keperluan development.'],
            ['title_like' => '%Laravel%', 'content' => 'Satu hal yang belum dibahas: bagaimana dengan performa di production? Apakah ada benchmark yang membandingkan Laravel 11 vs 10?'],
            ['title_like' => '%API%', 'content' => 'Panduan paling lengkap yang pernah saya baca soal Sanctum. Langsung saya coba dan berhasil dalam 30 menit!'],
            ['title_like' => '%API%', 'content' => 'Ada yang bisa bantu? Saya dapat error 401 padahal token sudah benar. Ternyata lupa tambahkan Accept: application/json di header. Semoga membantu yang lain.'],
            ['title_like' => '%Timnas%', 'content' => 'Bangga banget jadi orang Indonesia hari ini! Semoga anak-anak muda ini terus konsisten dan tidak cepat puas.'],
            ['title_like' => '%Timnas%', 'content' => 'Yang paling saya kagumi adalah mentalitas tim. Tidak ada yang sok bintang, semua kerja keras sama-sama.'],
            ['title_like' => '%Timnas%', 'content' => 'Semoga ini jadi titik balik sepak bola Indonesia. Sudah lama kita menunggu momen seperti ini.'],
            ['title_like' => '%Pemilu%', 'content' => 'Pemilu memang melelahkan tapi ini bukti bahwa demokrasi kita berjalan. Partisipasi pemilih yang tinggi patut diapresiasi.'],
            ['title_like' => '%Pemilu%', 'content' => 'Semoga pemimpin terpilih bisa membawa perubahan nyata. Rakyat sudah menunggu aksi nyata, bukan janji manis.'],
            ['title_like' => '%Film%', 'content' => 'Senang sekali melihat film Indonesia go international. Dulu kita cuma bisa bangga lihat film tetangga, sekarang giliran kita!'],
            ['title_like' => '%Film%', 'content' => 'Setuju banget dengan poin tentang kekuatan cerita lokal. Film seperti ini yang membuat kita makin cinta Indonesia.'],
            ['title_like' => '%AI%', 'content' => 'AI memang membantu, tapi kita juga harus hati-hati. Jangan sampai ketergantungan malah bikin kita lupa berpikir kritis.'],
            ['title_like' => '%Startup%', 'content' => 'Era bakar uang sudah berakhir. Sekarang zamannya startup yang benar-benar memberikan nilai tambah.'],
            ['title_like' => '%Bulu%', 'content' => 'Bulu tangkis adalah identitas bangsa. Semoga PBSI terus berbenah dan menghasilkan atlet-atlet juara dunia.'],
        ];

        $users = User::where('role', '!=', 'admin')->get();

        foreach ($comments as $item) {
            $articles = Article::where('title', 'like', $item['title_like'])->get();
            foreach ($articles as $article) {
                Comment::create([
                    'article_id' => $article->id,
                    'user_id'    => $users->random()->id,
                    'content'    => $item['content'],
                    'status'     => 'approved',
                ]);
            }
        }

        // Tambah komentar random untuk artikel tanpa komentar
        $articlesWithout = Article::whereDoesntHave('comments')->get();
        foreach ($articlesWithout as $article) {
            Comment::factory(rand(2, 3))->create([
                'article_id' => $article->id,
                'user_id'    => $users->random()->id,
                'status'     => 'approved',
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [

            // ===== KATEGORI TEKNOLOGI =====
            [
                'title'        => 'Mengenal Laravel 11: Fitur Baru yang Wajib Kamu Tahu',
                'excerpt'      => 'Laravel 11 hadir dengan berbagai pembaruan signifikan yang membuat pengembangan aplikasi web semakin cepat, efisien, dan menyenangkan bagi para developer.',
                'content'      => '
<p>Laravel 11 resmi diluncurkan pada Maret 2024 dan langsung menjadi perbincangan hangat di komunitas PHP dunia. Versi terbaru dari framework PHP paling populer ini membawa sejumlah perubahan mendasar yang mengubah cara kita membangun aplikasi web modern.</p>

<h2>Struktur Aplikasi yang Lebih Ramping</h2>
<p>Salah satu perubahan paling mencolok di Laravel 11 adalah penyederhanaan struktur folder aplikasi. Tim Laravel menghapus sejumlah file yang sebelumnya dianggap "bloat" seperti <code>kernel.php</code> untuk HTTP dan Console. Kini semua konfigurasi middleware dilakukan langsung di <code>bootstrap/app.php</code>.</p>

<p>Perubahan ini membuat proyek baru Laravel menjadi jauh lebih bersih. Developer pemula tidak lagi kebingungan dengan banyaknya file konfigurasi yang perlu dipahami di awal.</p>

<h2>SQLite sebagai Database Default</h2>
<p>Ini mungkin terdengar mengejutkan, tapi Laravel 11 kini menggunakan SQLite sebagai database default untuk instalasi baru. Keputusan ini diambil untuk mempermudah proses onboarding developer baru yang tidak perlu lagi setup MySQL atau PostgreSQL hanya untuk mencoba Laravel.</p>

<h2>Fitur Health Check Bawaan</h2>
<p>Laravel 11 menyertakan endpoint <code>/up</code> yang secara otomatis melakukan pengecekan kesehatan aplikasi. Fitur ini sangat berguna untuk integrasi dengan layanan monitoring seperti Laravel Pulse, Kubernetes health check, atau load balancer.</p>

<h2>Model Casting yang Lebih Elegan</h2>
<p>Cara mendefinisikan cast pada model Eloquent kini bisa dilakukan dengan metode <code>casts()</code> yang mengembalikan array. Ini lebih bersih dibanding properti <code>$casts</code> yang digunakan di versi sebelumnya.</p>

<h2>Kesimpulan</h2>
<p>Laravel 11 bukan sekadar pembaruan biasa. Ini adalah evolusi framework yang semakin matang, fokus pada developer experience, dan siap menghadapi tantangan pengembangan aplikasi modern. Jika kamu belum mencobanya, sekarang adalah waktu yang tepat untuk mulai bermigrasi.</p>
                ',
                'category_slug' => 'teknologi',
                'tags'          => ['laravel', 'php', 'tutorial'],
                'status'        => 'published',
                'views'         => 1240,
            ],

            [
                'title'        => 'Cara Membuat REST API dengan Laravel Sanctum dari Nol',
                'excerpt'      => 'Panduan lengkap membangun REST API yang aman menggunakan Laravel Sanctum, mulai dari instalasi hingga implementasi autentikasi token di aplikasi mobile dan web.',
                'content'      => '
<p>REST API adalah tulang punggung aplikasi modern. Hampir semua aplikasi mobile, SPA (Single Page Application), dan integrasi pihak ketiga membutuhkan API yang handal. Laravel, dengan ekosistemnya yang kaya, menyediakan Laravel Sanctum sebagai solusi autentikasi API yang ringan namun powerful.</p>

<h2>Apa itu Laravel Sanctum?</h2>
<p>Laravel Sanctum adalah paket autentikasi yang dirancang khusus untuk dua skenario utama: autentikasi SPA (Single Page Application) menggunakan cookie session, dan autentikasi API menggunakan token personal. Berbeda dengan Passport yang lebih kompleks dan menggunakan protokol OAuth2 penuh, Sanctum jauh lebih sederhana dan cocok untuk sebagian besar kebutuhan.</p>

<h2>Instalasi dan Konfigurasi</h2>
<p>Mulai dengan menginstal Sanctum via Composer:</p>
<pre><code>composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate</code></pre>

<h2>Membuat Endpoint Autentikasi</h2>
<p>Setelah instalasi, buat controller untuk menangani register, login, dan logout. Pastikan model User menggunakan trait <code>HasApiTokens</code> yang disediakan Sanctum.</p>

<h2>Melindungi Route dengan Middleware</h2>
<p>Gunakan middleware <code>auth:sanctum</code> untuk melindungi endpoint yang membutuhkan autentikasi. Setiap request ke endpoint tersebut harus menyertakan header <code>Authorization: Bearer {token}</code>.</p>

<h2>Testing dengan Postman</h2>
<p>Gunakan Postman atau Insomnia untuk menguji API yang sudah dibuat. Pastikan header <code>Accept: application/json</code> selalu disertakan agar Laravel mengembalikan respons dalam format JSON.</p>

<h2>Penutup</h2>
<p>Dengan Laravel Sanctum, membangun API yang aman tidak perlu rumit. Ikuti panduan ini dan kamu akan memiliki API yang siap digunakan dalam waktu singkat.</p>
                ',
                'category_slug' => 'teknologi',
                'tags'          => ['laravel', 'api', 'tutorial'],
                'status'        => 'published',
                'views'         => 980,
            ],

            [
                'title'        => 'Kecerdasan Buatan di 2025: Antara Harapan dan Kekhawatiran',
                'excerpt'      => 'Perkembangan AI yang pesat di tahun 2025 memunculkan berbagai pertanyaan besar: apakah teknologi ini akan menciptakan lapangan kerja baru atau justru menggantikan manusia?',
                'content'      => '
<p>Tahun 2025 menjadi tonggak penting dalam sejarah kecerdasan buatan. Model-model bahasa besar seperti GPT-5, Gemini Ultra, dan Claude 3 telah mencapai kemampuan yang beberapa tahun lalu masih dianggap fiksi ilmiah. Namun di balik semua kemajuan ini, muncul pertanyaan-pertanyaan yang belum terjawab.</p>

<h2>AI Masuk ke Dunia Kerja</h2>
<p>Laporan McKinsey Global Institute memproyeksikan bahwa pada 2025, sekitar 30% pekerjaan administratif dan analitik dapat diotomasi oleh AI. Di Indonesia sendiri, sejumlah perusahaan besar mulai mengadopsi AI untuk fungsi customer service, analisis data, dan bahkan penulisan konten.</p>

<h2>Sisi Positif yang Sering Terlupakan</h2>
<p>Di bidang kesehatan, AI telah membantu diagnosis kanker stadium awal dengan tingkat akurasi yang melampaui dokter spesialis berpengalaman. Di sektor pertanian, sensor AI membantu petani memprediksi cuaca dan mengoptimalkan penggunaan pupuk, meningkatkan hasil panen hingga 40%.</p>

<h2>Regulasi yang Tertinggal</h2>
<p>Salah satu tantangan terbesar adalah regulasi yang belum mampu mengikuti laju perkembangan teknologi. Indonesia baru memiliki draft regulasi AI yang masih dalam tahap pembahasan, sementara teknologinya sudah berlari kencang.</p>

<h2>Kesimpulan</h2>
<p>AI bukan musuh manusia, tapi juga bukan solusi ajaib untuk semua masalah. Yang dibutuhkan adalah kebijaksanaan dalam mengadopsi teknologi ini sambil memastikan tidak ada yang tertinggal dalam proses transformasi digital.</p>
                ',
                'category_slug' => 'teknologi',
                'tags'          => ['ai', 'review'],
                'status'        => 'published',
                'views'         => 2100,
            ],

            // ===== KATEGORI POLITIK =====
            [
                'title'        => 'Pemilu 2024: Pelajaran Demokrasi dari Bangsa yang Terus Belajar',
                'excerpt'      => 'Pemilu 2024 telah usai dengan segala dinamikanya. Kini saatnya kita merefleksikan perjalanan demokrasi Indonesia dan apa yang harus diperbaiki ke depan.',
                'content'      => '
<p>Indonesia baru saja melewati Pemilu Serentak 2024, salah satu pesta demokrasi terbesar di dunia yang melibatkan lebih dari 200 juta pemilih terdaftar. Proses yang panjang, melelahkan, dan penuh dinamika ini akhirnya menghasilkan kepemimpinan baru yang akan membawa bangsa ke babak berikutnya.</p>

<h2>Partisipasi Pemilih yang Menggembirakan</h2>
<p>Tingkat partisipasi pemilih pada Pemilu 2024 mencapai 81,78%, angka yang cukup tinggi dibandingkan rata-rata pemilu sebelumnya. Ini menunjukkan bahwa kesadaran politik masyarakat Indonesia terus meningkat, terutama di kalangan pemilih muda yang untuk pertama kalinya menggunakan hak suaranya.</p>

<h2>Peran Media Sosial dalam Kampanye</h2>
<p>Pemilu 2024 adalah pemilu pertama di Indonesia di mana kampanye media sosial memainkan peran dominan. TikTok, Instagram, dan X (Twitter) menjadi arena pertarungan narasi yang tak kalah sengitnya dengan debat televisi. Fenomena ini sekaligus membawa tantangan baru berupa maraknya disinformasi dan hoaks.</p>

<h2>Tantangan ke Depan</h2>
<p>Terlepas dari siapa pemenangnya, Indonesia masih menghadapi pekerjaan rumah besar: memperbaiki sistem pemilu yang terlalu mahal, mengurangi politik identitas, dan memastikan setiap suara dihitung dengan jujur dan adil.</p>
                ',
                'category_slug' => 'politik',
                'tags'          => ['breaking'],
                'status'        => 'published',
                'views'         => 3450,
            ],

            [
                'title'        => 'Korupsi Masih Jadi Musuh Utama Pembangunan Indonesia',
                'excerpt'      => 'Indeks Persepsi Korupsi Indonesia stagnan di angka 34 selama tiga tahun berturut-turut. Apa yang salah dan apa yang harus dilakukan?',
                'content'      => '
<p>Transparency International kembali merilis Corruption Perception Index (CPI) dan Indonesia masih terjebak di angka 34 dari skala 100 — jauh dari target 50 yang ditetapkan dalam RPJMN. Angka ini menempatkan Indonesia di peringkat 115 dari 180 negara yang disurvei.</p>

<h2>Korupsi Bukan Hanya Soal Uang</h2>
<p>Sering kali kita mereduksi korupsi sebagai sekadar masalah pencurian uang negara. Padahal korupsi jauh lebih luas dari itu: korupsi waktu, korupsi kewenangan, nepotisme dalam penerimaan pegawai, hingga suap dalam proses perizinan yang menghambat investasi.</p>

<h2>KPK dan Tantangannya</h2>
<p>Komisi Pemberantasan Korupsi (KPK) terus bekerja di tengah berbagai tekanan. Sejak revisi UU KPK pada 2019, lembaga ini menghadapi perdebatan soal efektivitas dan independensinya. Namun data menunjukkan bahwa KPK masih berhasil menangani ratusan kasus setiap tahunnya.</p>

<h2>Peran Masyarakat Sipil</h2>
<p>Pemberantasan korupsi tidak bisa hanya mengandalkan lembaga negara. Masyarakat sipil, media, dan akademisi memiliki peran krusial dalam menciptakan ekosistem antikorupsi yang berkelanjutan.</p>
                ',
                'category_slug' => 'politik',
                'tags'          => ['breaking'],
                'status'        => 'published',
                'views'         => 1870,
            ],

            // ===== KATEGORI OLAHRAGA =====
            [
                'title'        => 'Timnas Indonesia U-23: Generasi Emas yang Sedang Mekar',
                'excerpt'      => 'Penampilan memukau Timnas Indonesia U-23 di Piala Asia AFC membuat seluruh negeri bangga. Inilah profil para pemain muda berbakat yang menjadi harapan sepak bola nasional.',
                'content'      => '
<p>Stadion Gelora Bung Karno bergemuruh ketika wasit meniup peluit panjang tanda berakhirnya pertandingan. Timnas Indonesia U-23 baru saja mencatatkan sejarah dengan melaju ke semifinal Piala Asia AFC U-23 untuk pertama kalinya. Air mata kebanggaan tumpah ruah, bukan hanya di tribun penonton, tapi juga di ruang keluarga jutaan rakyat Indonesia yang menyaksikannya dari layar televisi.</p>

<h2>Siapa Mereka?</h2>
<p>Generasi ini lahir dari sistem pembinaan yang mulai diperbaiki sekitar satu dekade lalu. Banyak di antara mereka yang menjalani proses naturalisasi setelah memiliki darah Indonesia, sementara yang lainnya adalah produk asli akademi sepak bola dalam negeri.</p>

<h2>Kunci Kesuksesan: Kolektif di Atas Individu</h2>
<p>Yang membedakan timnas U-23 kali ini adalah semangat kolektif yang luar biasa. Tidak ada ego pemain bintang yang mengganggu harmoni tim. Setiap pemain tahu perannya dan menjalankannya dengan penuh dedikasi.</p>

<h2>Jalan Masih Panjang</h2>
<p>Euforia ini memang layak dirayakan, tapi kita tidak boleh larut terlalu lama. Perjalanan menuju sepak bola Indonesia yang benar-benar kompetitif di level dunia masih sangat panjang. Infrastruktur, kompetisi usia dini, dan tata kelola federasi masih perlu banyak pembenahan.</p>
                ',
                'category_slug' => 'olahraga',
                'tags'          => ['breaking'],
                'status'        => 'published',
                'views'         => 5600,
            ],

            [
                'title'        => 'Bulu Tangkis Indonesia: Warisan Juara yang Harus Dijaga',
                'excerpt'      => 'Indonesia pernah mendominasi bulu tangkis dunia selama puluhan tahun. Kini, di tengah persaingan yang semakin ketat, bagaimana nasib olahraga kebanggaan bangsa ini?',
                'content'      => '
<p>Jika ada satu olahraga yang identik dengan Indonesia di kancah internasional, jawabannya hampir pasti bulu tangkis. Sejak Piala Thomas pertama kali diperebutkan pada 1949, Indonesia telah mengoleksi trofi demi trofi yang menjadi kebanggaan nasional.</p>

<h2>Era Keemasan yang Tak Terlupakan</h2>
<p>Nama-nama seperti Rudy Hartono, Liem Swie King, Susi Susanti, Alan Budi Kusuma, Taufik Hidayat, dan Kevin/Marcus adalah legenda yang mengharumkan nama Indonesia di seluruh penjuru dunia. Mereka bukan sekadar atlet, mereka adalah pahlawan olahraga nasional.</p>

<h2>Tantangan Era Modern</h2>
<p>Namun bulu tangkis dunia kini semakin kompetitif. Tiongkok, Korea Selatan, Denmark, dan Japan terus meningkatkan kualitas pemain mereka dengan sistem pembinaan yang sistematis dan berteknologi tinggi.</p>

<h2>Harapan di Generasi Baru</h2>
<p>Meski tantangan besar, bibit-bibit unggul terus lahir dari pelatnas PBSI. Semangat para atlet muda ini adalah jaminan bahwa bulu tangkis Indonesia belum akan redup dalam waktu dekat.</p>
                ',
                'category_slug' => 'olahraga',
                'tags'          => ['review'],
                'status'        => 'published',
                'views'         => 2340,
            ],

            // ===== KATEGORI HIBURAN =====
            [
                'title'        => 'Film Indonesia Mendunia: Ketika Sineas Lokal Bicara di Panggung Global',
                'excerpt'      => 'Beberapa tahun terakhir, film-film Indonesia mulai mendapat pengakuan di festival internasional bergengsi. Apa rahasia di balik kebangkitan sinema Indonesia?',
                'content'      => '
<p>Dulu, menonton film Indonesia dianggap kurang keren oleh sebagian anak muda. Tapi anggapan itu kini sudah jauh berubah. Film-film Indonesia tidak hanya laris di dalam negeri, tapi mulai mendapat pengakuan di panggung internasional.</p>

<h2>Dari Sundance hingga Cannes</h2>
<p>Sejumlah film Indonesia berhasil menembus seleksi festival film bergengsi dunia seperti Sundance, Berlin International Film Festival, dan bahkan masuk dalam daftar longlist Academy Awards. Ini bukan pencapaian kecil bagi industri film yang baru benar-benar bangkit sekitar 15 tahun lalu.</p>

<h2>Kekuatan Cerita Lokal</h2>
<p>Paradoksnya, semakin lokal sebuah cerita, semakin universal resonansinya. Film-film terbaik Indonesia justru yang paling berani mengangkat isu-isu spesifik: konflik agraria di pedesaan Kalimantan, kehidupan komunitas nelayan di Sulawesi, atau drama keluarga di kampung-kampung Jawa.</p>

<h2>Platform Streaming Sebagai Katalis</h2>
<p>Kehadiran Netflix, Disney+, dan platform streaming lokal seperti Vidio dan GoPlay menjadi katalis penting bagi industri konten Indonesia. Investasi besar dari platform-platform ini mendorong lahirnya karya-karya berkualitas tinggi.</p>
                ',
                'category_slug' => 'hiburan',
                'tags'          => ['review'],
                'status'        => 'published',
                'views'         => 1560,
            ],

            // ===== KATEGORI BISNIS =====
            [
                'title'        => 'Startup Indonesia 2025: Bertahan, Berinovasi, atau Mati',
                'excerpt'      => 'Setelah era bakar uang berakhir, startup Indonesia memasuki fase baru yang lebih menantang: profitabilitas. Siapa yang bertahan dan siapa yang gugur?',
                'content'      => '
<p>Tahun 2022-2023 adalah masa-masa gelap bagi ekosistem startup Indonesia. Ratusan startup melakukan PHK massal, beberapa unicorn terpaksa menutup lini bisnisnya, dan investasi venture capital menyusut drastis. Tapi dari krisis itu, lahir generasi startup yang lebih tangguh.</p>

<h2>Akhir Era Bakar Uang</h2>
<p>Selama bertahun-tahun, model bisnis startup Indonesia bertumpu pada strategi "bakar uang" untuk merebut pasar: subsidi ongkos kirim, cashback besar-besaran, dan promo yang tidak masuk akal secara bisnis. Strategi ini mungkin efektif untuk akuisisi pengguna, tapi tidak berkelanjutan.</p>

<h2>Startup yang Bertahan: Apa Bedanya?</h2>
<p>Startup yang berhasil melewati masa sulit umumnya memiliki beberapa kesamaan: unit economics yang sehat, fokus pada segmen pasar yang spesifik, dan kemampuan untuk beradaptasi dengan cepat. Mereka tidak mengejar pertumbuhan pengguna semata, tapi pertumbuhan yang menghasilkan nilai nyata.</p>

<h2>Peluang di Sektor yang Belum Tersentuh</h2>
<p>Masih banyak sektor di Indonesia yang belum terdigitalisasi dengan baik: pertanian, pendidikan vokasi, layanan kesehatan di daerah terpencil, dan logistik last-mile di luar Jawa. Di sinilah peluang terbesar bagi startup generasi berikutnya.</p>

<h2>Kesimpulan</h2>
<p>Ekosistem startup Indonesia sedang dalam proses pendewasaan. Ini memang menyakitkan, tapi perlu. Startup yang lahir dan bertahan di masa-masa sulit ini kemungkinan besar akan menjadi pemimpin industri di masa depan.</p>
                ',
                'category_slug' => 'bisnis',
                'tags'          => ['startup', 'breaking'],
                'status'        => 'published',
                'views'         => 2890,
            ],

            [
                'title'        => 'UMKM Digital: Ketika Warung Madura Masuk Marketplace',
                'excerpt'      => 'Transformasi digital UMKM Indonesia bukan sekadar tren, tapi kebutuhan nyata. Kisah sukses pedagang kecil yang memanfaatkan teknologi untuk mengembangkan usahanya.',
                'content'      => '
<p>Pak Ridwan, pemilik warung sembako di sudut gang kecil di Surabaya, kini tidak lagi hanya melayani pelanggan yang datang langsung ke warungnya. Dengan bergabung ke aplikasi pemesanan bahan pokok dan marketplace digital, omzetnya meningkat tiga kali lipat dalam waktu enam bulan.</p>

<h2>Angka yang Tidak Bisa Diabaikan</h2>
<p>Indonesia memiliki lebih dari 65 juta unit UMKM yang menyerap sekitar 97% tenaga kerja nasional dan berkontribusi 61% terhadap PDB. Namun hingga 2024, baru sekitar 24 juta di antaranya yang telah go digital. Artinya masih ada lebih dari 40 juta UMKM yang belum tersentuh transformasi digital.</p>

<h2>Hambatan Nyata di Lapangan</h2>
<p>Hambatan utama bukan hanya soal akses teknologi, tapi juga literasi digital dan kepercayaan. Banyak pelaku UMKM yang masih skeptis dengan transaksi digital, khawatir soal keamanan data, atau sekadar tidak tahu harus mulai dari mana.</p>

<h2>Program Pemerintah dan Swasta</h2>
<p>Berbagai program onboarding digital dari Tokopedia, Shopee, Gojek, dan Grab, yang dikombinasikan dengan program pemerintah seperti UMKM Go Digital, terbukti efektif mempercepat adopsi digital di kalangan pelaku usaha kecil.</p>
                ',
                'category_slug' => 'bisnis',
                'tags'          => ['startup'],
                'status'        => 'published',
                'views'         => 1120,
            ],
        ];

        foreach ($articles as $data) {
            $category = Category::where('slug', $data['category_slug'])->first();
            $user = User::inRandomOrder()->first();
            $tags = $data['tags'];
            unset($data['category_slug'], $data['tags']);

            $article = Article::create([
                ...$data,
                'slug'         => Str::slug($data['title']),
                'category_id'  => $category->id,
                'user_id'      => $user->id,
                'published_at' => now()->subDays(rand(1, 90)),
            ]);

            $tagIds = \App\Models\Tag::whereIn('slug', $tags)->pluck('id');
            $article->tags()->attach($tagIds);
        }
    }
}

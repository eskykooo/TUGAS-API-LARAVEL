<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [

            // ===== PC GAMING =====
            [
                'title' => 'Review RTX 5090: Kartu Grafis Tercepat yang Pernah Ada',
                'excerpt' => 'Nvidia kembali mengguncang dunia gaming dengan RTX 5090. Dengan arsitektur Blackwell dan performa 2x lipat dari generasi sebelumnya, inilah kartu grafis tercepat yang pernah dibuat.',
                'content' => '
<p>Nvidia resmi meluncurkan GeForce RTX 5090, kartu grafis konsumen tercepat yang pernah dibuat. Berbasis arsitektur Blackwell dengan proses fabrikasi 3nm TSMC, kartu ini membawa lompatan performa yang belum pernah terjadi sebelumnya dalam sejarah GPU gaming.</p>

<h2>Spesifikasi Monster</h2>
<p>RTX 5090 hadir dengan 24.576 core CUDA, 192 unit RT core generasi ke-4, dan 768 Tensor core generasi ke-5. Dengan memory GDDR7 sebesar 32GB pada bus 512-bit, bandwidth mencapai 2 TB/dtk - angka yang mencengangkan untuk sebuah kartu grafis konsumen.</p>

<p>Dalam pengujian benchmark 4K, RTX 5090 mampu menjalankan Cyberpunk 2077 dengan ray tracing penuh dan DLSS 4 di atas 120 FPS. Angka yang sebelumnya hanya bisa dicapai dengan multiple GPU setup kini bisa diraih oleh satu kartu saja.</p>

<h2>DLSS 4 dan Neural Rendering</h2>
<p>Salah satu fitur paling revolusioner adalah DLSS 4 yang menggunakan AI untuk menghasilkan frame secara real-time. Teknologi ini mampu melipatgandakan frame rate tanpa mengorbankan kualitas gambar secara signifikan.</p>

<h2>Harga dan Ketersediaan</h2>
<p>Dengan harga mulai dari Rp 35 juta, RTX 5090 jelas bukan untuk semua orang. Namun bagi gamer hardcore dan kreator konten yang membutuhkan performa maksimal, investasi ini sangat masuk akal.</p>

<h2>Kesimpulan</h2>
<p>RTX 5090 adalah mahakarya engineering yang mendefinisikan ulang batas performa gaming. Tidak ada kartu lain yang bisa menyainginya saat ini. Jika budget bukan masalah, ini adalah GPU terbaik yang bisa kamu beli.</p>
                ',
                'category_slug' => 'pc-gaming',
                'tags' => ['action', 'fps', 'aaa'],
                'status' => 'published',
                'views' => 5600,
            ],

            [
                'title' => 'Rakit PC Gaming 10 Jutaan: Build Terbaik 2026',
                'excerpt' => 'Membangun PC gaming dengan budget 10 juta rupiah kini semakin mudah. Berikut rekomendasi build terbaik yang bisa kamu dapatkan dengan harga tersebut.',
                'content' => '
<p>Bermimpi memiliki PC gaming kencang tapi budget terbatas? Tenang, dengan 10 juta rupiah kamu sudah bisa merakit PC yang mampu menjalankan game-game AAA di setting medium-high 1080p. Berikut panduan lengkapnya.</p>

<h2>Komponen Utama</h2>
<p>Untuk prosesor, AMD Ryzen 5 5600 masih menjadi pilihan terbaik di kelasnya. Dengan 6 core 12 thread dan harga sekitar 1,8 juta, prosesor ini menawarkan performa gaming yang impresif. Dari kubu Intel, Core i5-12400F juga menjadi alternatif yang menarik dengan harga serupa.</p>

<p>Kartu grafis adalah komponen paling krusial. Di budget 10 juta, pilihan terbaik jatuh pada NVIDIA GeForce RTX 3060 12GB atau AMD Radeon RX 6600 XT. Keduanya mampu menjalankan game-game terbaru di 1080p dengan setting tinggi hingga ultra.</p>

<h2>Motherboard dan RAM</h2>
<p>Motherboard B550 untuk AMD atau B660 untuk Intel sudah cukup untuk build ini. Jangan lupa RAM 16GB (2x8GB) DDR4 3200MHz yang harganya sudah sangat terjangkau di kisaran 500-600 ribu rupiah.</p>

<h2>Storage dan Power Supply</h2>
<p>SSD NVMe 512GB atau 1TB wajib hukumnya. Untuk PSU, jangan pelit - pilih minimal 550W 80+ Bronze dari merek ternama seperti Corsair, Seasonic, atau Cooler Master. PSU murahan bisa membahayakan komponen lain.</p>

<h2>Kesimpulan</h2>
<p>PC gaming 10 jutaan bukan lagi mimpi. Dengan pemilihan komponen yang tepat, kamu bisa merasakan pengalaman gaming yang smooth di semua game terkini. Jangan lupa riset harga terbaru sebelum membeli!</p>
                ',
                'category_slug' => 'pc-gaming',
                'tags' => ['action', 'fps', 'strategy'],
                'status' => 'published',
                'views' => 4200,
            ],

            // ===== CONSOLE =====
            [
                'title' => 'PlayStation 6: Semua yang Perlu Kamu Tahu',
                'excerpt' => 'Sony dikabarkan sedang mempersiapkan PlayStation 6 dengan spesifikasi yang luar biasa. Bocoran terbaru mengungkap detail menarik tentang konsol generasi berikutnya.',
                'content' => '
<p>PS5 mungkin masih terasa baru, namun rumor tentang PlayStation 6 sudah mulai berhembus kencang di kalangan insider industri gaming. Berdasarkan bocoran dari berbagai sumber, berikut yang perlu kamu ketahui.</p>

<h2>Spesifikasi yang Bocor</h2>
<p>PS6 dikabarkan akan menggunakan APU custom dari AMD dengan arsitektur Zen 6 untuk CPU dan RDNA 5 untuk GPU. Dengan RAM 32GB GDDR7 dan SSD NVMe generasi terbaru, loading time diprediksi akan semakin singkat - bahkan bisa dihilangkan sama sekali.</p>

<p>Yang paling menarik adalah dukungan terhadap 8K native dengan ray tracing penuh pada 60 FPS stabil. Teknologi upscaling berbasis AI ala DLSS juga dipercaya akan menjadi fitur andalan konsol ini.</p>

<h2>Fitur Revolusioner</h2>
<p>Sony dikabarkan sedang mengembangkan teknologi haptic feedback generasi baru yang lebih imersif, serta integrasi cloud gaming yang lebih seamless. Fitur backward compatibility dengan PS5 dan PS4 hampir pasti akan dipertahankan.</p>

<h2>Tanggal Rilis</h2>
<p>Jika mengikuti siklus rilis PlayStation sebelumnya, PS6 diperkirakan akan meluncur antara tahun 2027 hingga 2028. Namun dengan persaingan yang semakin ketat, Sony mungkin akan mempercepat jadwalnya.</p>

<h2>Harga</h2>
<p>Dengan spesifikasi yang gila-gilaan, harga PS6 diprediksi akan berada di kisaran 10-12 juta rupiah. Mahal? Mungkin, tapi untuk pengalaman gaming generasi berikutnya, sepertinya worth it.</p>
                ',
                'category_slug' => 'console',
                'tags' => ['action', 'aaa', 'single-player'],
                'status' => 'published',
                'views' => 3800,
            ],

            [
                'title' => 'Nintendo Switch 2 Resmi Diumumkan: Apa yang Baru?',
                'excerpt' => 'Nintendo akhirnya mengumumkan penerus Switch yang legendaris. Dengan layar lebih besar, performa lebih kencang, dan game eksklusif yang ditunggu-tunggu.',
                'content' => '
<p>Nintendo akhirnya secara resmi mengumumkan Nintendo Switch 2, konsol hybrid generasi berikutnya yang dinanti-nanti oleh jutaan gamer di seluruh dunia. Berikut semua detail yang perlu kamu ketahui.</p>

<h2>Desain dan Layar</h2>
<p>Switch 2 hadir dengan layar LCD 8 inci dengan resolusi 1080p dalam mode handheld dan 4K saat di-dock. Dimensinya sedikit lebih besar dari pendahulunya, namun tetap nyaman digenggam berkat desain ergonomis yang diperbarui.</p>

<p>Joy-Con baru dilengkapi dengan analog hall effect yang anti-drift - masalah yang sudah bertahun-tahun mengganggu pengguna Switch original. Tombol-tombol juga lebih responsif dengan travel distance yang lebih pendek.</p>

<h2>Performa dan Hardware</h2>
<p>Ditenagai oleh prosesor custom Nvidia berbasis arsitektur Lovelace dengan dukungan DLSS 3, Switch 2 mampu menjalankan game-game terbaru dengan kualitas grafis yang mendekati konsol generasi saat ini. RAM 12GB LPDDR5 dan storage internal 256GB menjadi spesifikasi standar.</p>

<h2>Game Peluncuran</h2>
<p>Nintendo mengonfirmasi beberapa game peluncuran yang sangat kuat: The Legend of Zelda: Tears of the Kingdom - Director Cut, Metroid Prime 4, Super Mario Odyssey 2, dan tentu saja Pokemon generasi baru yang dikembangkan khusus untuk Switch 2.</p>

<h2>Harga dan Ketersediaan</h2>
<p>Switch 2 dibanderol dengan harga Rp 6.999.000 untuk paket standar dan Rp 8.499.000 untuk bundle dengan game Zelda. Pre-order sudah dibuka dan unit pertama akan dikirim bulan depan.</p>
                ',
                'category_slug' => 'console',
                'tags' => ['action', 'rpg', 'multiplayer'],
                'status' => 'published',
                'views' => 4900,
            ],

            // ===== MOBILE =====
            [
                'title' => 'Mobile Legends Patch Terbaru: Hero Baru dan Perubahan Meta',
                'excerpt' => 'Moonton merilis update besar Mobile Legends dengan hero baru bernama Lunox, perubahan signifikan pada battle spell, dan rework beberapa hero lama.',
                'content' => '
<p>Mobile Legends: Bang Bang kembali mendapat update besar yang mengubah landscape permainan secara drastis. Patch 1.9.4 menghadirkan hero baru, perubahan mekanik, dan tentunya pergeseran meta yang perlu kamu pahami.</p>

<h2>Hero Baru: Lunox, Twilight Goddess</h2>
<p>Lunox adalah hero mage/support dengan mekanik unik yang bisa berganti antara dua mode: Light Mode untuk damage burst dan Dark Mode untuk crowd control berkelanjutan. Ultimate-nya, Cosmic Fission, mampu membagi medan perang dan memberikan damage area yang masif.</p>

<p>Yang membuat Lunox menarik adalah fleksibilitasnya. Bisa dimainkan sebagai midlaner pure damage atau roamer support, tergantung komposisi tim dan kebutuhan. Pasifnya yang memberikan lifesteal juga membuatnya sustain di lane.</p>

<h2>Perubahan Battle Spell</h2>
<p>Battle spell Flicker dan Purify mendapat cooldown reduction yang signifikan. Sementara Execute kini memiliki damage scaling berdasarkan level, membuatnya lebih efektif di late game. Revitalize juga ditingkatkan healing-nya untuk mendukung strategi sustain comp.</p>

<h2>Rework Hero</h2>
<p>Zilong dan Gord mendapat rework besar. Zilong kini memiliki mobility yang lebih baik dengan skill 2 yang bisa di-cast sambil bergerak. Gord mendapat rework total pada skill-set-nya, menjadikannya zoning mage yang sangat menyakitkan di teamfight.</p>

<h2>Item Baru</h2>
<p>Tiga item baru ditambahkan: Twilight Armor untuk counter burst damage, Ethereal Staff untuk magic pierce tambahan, dan Windtalker upgrade yang memberikan movement speed bonus.</p>
                ',
                'category_slug' => 'mobile',
                'tags' => ['moba', 'multiplayer', 'action'],
                'status' => 'published',
                'views' => 5100,
            ],

            [
                'title' => 'Genshin Impact 5.0: Region Baru dan Karakter Bintang 5',
                'excerpt' => 'Update besar Genshin Impact menghadirkan region Natlan yang terinspirasi dari budaya Amerika Latin, lengkap dengan karakter baru dan mekanik exploration yang segar.',
                'content' => '
<p>Genshin Impact versi 5.0 akhirnya tiba, membawa region Natlan yang telah lama dinanti-nanti oleh para Traveler. Terinspirasi dari budaya Amerika Latin dan Mesoamerika, Natlan menawarkan pengalaman eksplorasi yang benar-benar baru.</p>

<h2>Region Natlan</h2>
<p>Natlan adalah nation of Pyro yang dikuasai oleh Archon Murata. Region ini terdiri dari beberapa area dengan tema yang beragam: hutan hujan tropis, gunung berapi aktif, padang savana, dan kota-kota kuno dengan arsitektur khas suku Aztec dan Maya.</p>

<p>Setiap area di Natlan memiliki mekanisme unik yang terkait dengan elemen Pyro. Kamu bisa menggunakan thermal vents untuk melompat lebih tinggi, memanaskan udara untuk gliding lebih lama, dan memicu reaksi lingkungan untuk membuka jalan baru.</p>

<h2>Karakter Baru</h2>
<p>Dua karakter bintang 5 baru diperkenalkan: Mavuika (Pyro Claymore) yang merupakan Archon Natlan, dan Ixchel (Anemo Bow) seorang pemburu dari suku dataran tinggi. Mavuika memiliki gameplay unik yang memanfaatkan mekanik "Overheat" untuk meningkatkan damage secara signifikan.</p>

<p>Karakter bintang 4 baru termasuk Tecun (Hydro Catalyst) seorang penyembuh dari suku pesisir, dan Zyanya (Electro Polearm) warrior wanita tangguh dari suku pegunungan.</p>

<h2>Fitur Baru</h2>
<p>Update ini juga menghadirkan sistem Artifact farming yang lebih ramah, dengan opsi "Strongbox" untuk mengonversi artifact lama, serta World Level 9 yang memberikan hadiah lebih baik untuk pemain high-level.</p>
                ',
                'category_slug' => 'mobile',
                'tags' => ['rpg', 'open-world', 'single-player'],
                'status' => 'published',
                'views' => 4500,
            ],

            // ===== ESPORTS =====
            [
                'title' => 'EVO 2026: Indonesia Bawa Pulang Juara Street Fighter 6',
                'excerpt' => 'Indonesia mencatat sejarah baru di kancah fighting game internasional. Player Indonesia berhasil menjadi juara Street Fighter 6 di ajang EVO 2026.',
                'content' => '
<p>EVO 2026, turnamen fighting game terbesar di dunia yang digelar di Las Vegas, mencatat sejarah baru. Indonesia untuk pertama kalinya berhasil membawa pulang gelar juara Street Fighter 6 setelah perjuangan yang luar biasa sengit.</p>

<h2>Perjalanan ke Puncak</h2>
<p>Mewakili Indonesia, pemain yang akrab disapa "GarudaFist" harus melewati 256 peserta dari seluruh dunia. Ia memulai perjalanannya dari bracket winner dengan performa yang sangat dominan, mengalahkan pemain-pemain top dunia seperti MenaRD (Dominican Republic), Punk (USA), dan Tokido (Japan).</p>

<p>Grand final menjadi pertandingan paling mendebarkan sepanjang sejarah EVO. GarudaFist bertemu dengan pemain nomor satu ranking dunia asal Korea Selatan, "Wolfgang". Setelah kalah di set pertama, GarudaFist melakukan adaptasi luar biasa dan memenangkan dua set berikutnya dengan skor telak 3-0 dan 3-1.</p>

<h2>Momen Bersejarah</h2>
<p>Momen kemenangan ini disambut histeris oleh ribuan penonton Indonesia yang hadir di Las Vegas dan jutaan lainnya yang menonton dari livestream. Tagar #GarudaFistJuara langsung trending di media sosial Indonesia.</p>

<h2>Dampak untuk Esports Indonesia</h2>
<p>Kemenangan ini diprediksi akan menjadi momentum kebangkitan fighting game Indonesia. Beberapa sponsor besar dikabarkan sudah mulai mendekati para pemain fighting game Indonesia untuk kerja sama. Pemerintah juga diharapkan memberikan perhatian lebih pada ekosistem esports nasional.</p>
                ',
                'category_slug' => 'esports',
                'tags' => ['fighting', 'multiplayer', 'aaa'],
                'status' => 'published',
                'views' => 6200,
            ],

            [
                'title' => 'ONIC Juara MPL Season 14: Perjalanan Drama Menuju Puncak',
                'excerpt' => 'ONIC Esports akhirnya kembali merebut tahta juara MPL Indonesia Season 14 setelah melewati grand final yang menegangkan melawan RRQ.',
                'content' => '
<p>MPL Indonesia Season 14 resmi berakhir dengan ONIC Esports keluar sebagai juara setelah grand final yang menegangkan selama 7 game melawan rival abadi mereka, RRQ. Kemenangan ini menegaskan kembali dominasi ONIC di kancah Mobile Legends Indonesia.</p>

<h2>Babak Grand Final</h2>
<p>Grand final yang digelar di Istora Senayan, Jakarta, disaksikan oleh lebih dari 10.000 penonton langsung yang memadati venue. Pertandingan berlangsung sengit sejak game pertama dengan kedua tim saling bergantian meraih kemenangan.</p>

<p>ONIC sempat unggul 2-0 di awal, namun RRQ berhasil menyamakan kedudukan menjadi 2-2. Di game kelima dan keenam, kedua tim saling berbagi kemenangan sehingga pertandingan berlanjut ke game ketujuh yang menentukan.</p>

<h2>Game Penentu</h2>
<p>Di game ketujuh, ONIC menunjukkan mental juara sejati. Dengan draft pick yang cerdik - memilih hero pop pick Lunox untuk Kairi di mid dan Fanny untuk Ssanji di jungle - mereka berhasil mengontrol permainan sejak awal. RRQ yang bermain dengan hero comfort pick mereka tidak mampu menahan agresivitas ONIC.</p>

<h2>MVP Final</h2>
<p>Kairi dinobatkan sebagai MVP grand final setelah penampilan gemilangnya sepanjang series. Dengan hero Lunox-nya yang mematikan, ia berhasil mencatatkan KDA 25-3-40 dalam 7 game.</p>

<h2>Hadiah dan Sejarah</h2>
<p>Sebagai juara, ONIC membawa pulang hadiah sebesar Rp 500 juta dan tiket menuju M6 World Championship yang akan digelar di Singapura bulan depan.</p>
                ',
                'category_slug' => 'esports',
                'tags' => ['moba', 'multiplayer', 'strategy'],
                'status' => 'published',
                'views' => 5400,
            ],

            // ===== REVIEWS =====
            [
                'title' => 'Elden Ring: Shadow of the Erdtree Review - Masterpiece Lain Dari FromSoftware',
                'excerpt' => 'Ekspansi Elden Ring yang sangat dinanti akhirnya tiba. Shadow of the Erdtree tidak hanya memenuhi ekspektasi, tapi melampauinya dalam hampir setiap aspek.',
                'content' => '
<p>Shadow of the Erdtree, ekspansi besar pertama dan satu-satunya untuk Elden Ring, akhirnya dirilis. Dan kabar baiknya: ini bukan sekadar DLC biasa. Ini adalah konten sebesar game AAA baru yang diletakkan di atas fondasi Elden Ring yang sudah sempurna.</p>

<h2>Dunia Baru yang Mencekam</h2>
<p>Ekspansi ini memperkenalkan Realm of Shadow, area baru yang ukurannya sebanding dengan Limgrave dan Caelid jika digabungkan. Dengan desain level vertikal yang rumit, area ini penuh dengan rahasia, dungeon tersembunyi, dan pemandangan yang memukau sekaligus mengerikan.</p>

<p>Setiap sudut Realm of Shadow menyimpan kejutan. Dari hutan yang diselimuti kabut beracun hingga kastil megah yang hancur, FromSoftware sekali lagi membuktikan diri sebagai master dunia game design.</p>

<h2>Boss Fight Terbaik</h2>
<p>Shadow of the Erdtree menghadirkan lebih dari 40 boss baru, termasuk beberapa yang bisa dibilang merupakan boss fight terbaik yang pernah dibuat FromSoftware. Dua yang paling menonjol adalah Bayle the Dread, naga raksasa dengan fase transformasi yang spektakuler, dan Messmer the Impaler, boss dengan moveset kompleks yang menguji kemampuan pemain secara maksimal.</p>

<h2>Senjata dan Build Baru</h2>
<p>Delapan kategori senjata baru termasuk great katanas, light greatswords, dan martial arts gauntlets memberikan variasi gameplay yang segar. Lebih dari 100 spell, incantation, dan ashes of war baru juga tersedia, membuka kemungkinan build yang sebelumnya tidak pernah terbayangkan.</p>

<h2>Kesimpulan</h2>
<p>Shadow of the Erdtree bukan sekadar DLC, tapi sebuah mahakarya yang berdiri sendiri. Dengan skor 96 di Metacritic, ekspansi ini menjadi DLC dengan rating tertinggi sepanjang sejarah. Untuk penggemar Elden Ring, ini adalah keharusan mutlak.</p>
                ',
                'category_slug' => 'reviews',
                'tags' => ['action', 'rpg', 'open-world', 'single-player', 'aaa'],
                'status' => 'published',
                'views' => 4800,
            ],

            [
                'title' => 'Hollow Knight: Silksong - Akhirnya Tiba, dan Layak Ditunggu',
                'excerpt' => 'Setelah bertahun-tahun penantian, Silksong akhirnya dirilis. Dan kabar baiknya: ini lebih baik dari Hollow Knight original dalam segala hal.',
                'content' => '
<p>Hollow Knight: Silksong, sekuel yang telah dinanti-nanti selama lebih dari 5 tahun, akhirnya dirilis. Team Cherry tidak hanya memenuhi ekspektasi yang sangat tinggi - mereka melampauinya dengan gemilang.</p>

<h2>Hornet Sang Protagonis</h2>
<p>Berbeda dengan Hollow Knight yang menggunakan Knight diam sebagai protagonis, Silksong menghadirkan Hornet sebagai karakter utama yang penuh dialog dan kepribadian. Moveset Hornet jauh lebih dinamis dengan kemampuan akrobatik yang membuat eksplorasi terasa segar dan menyenangkan.</p>

<p>System "Silk" adalah mekanik baru yang memungkinkan Hornet menggunakan benang sutra untuk berbagai keperluan: mengikat musuh, berayun melewati jurang, atau menciptakan platform sementara. Ini menambahkan dimensi vertikal yang lebih dalam pada gameplay.</p>

<h2>Kingdom of Pharloom</h2>
<p>Setting baru, Kingdom of Pharloom, adalah sebuah kerajaan bawah tanah yang megah dan terancam. Dengan desain area yang lebih beragam - mulai dari kota marmer yang elegan hingga gua kristal yang berbahaya - Pharloom menawarkan variasi visual yang lebih kaya dari pendahulunya.</p>

<h2>Soundtrack yang Magis</h2>
<p>Christopher Larkin kembali sebagai komposer dan hasilnya sekali lagi luar biasa. Soundtrack Silksong lebih bervariasi, menggabungkan orkestra, synth, dan vokal dalam komposisi yang emosional dan tak terlupakan.</p>

<h2>Verdict</h2>
<p>Hollow Knight: Silksong adalah sekuel yang sempurna. Skor 92 di OpenCritic membuktikan bahwa penantian panjang ini sangat berharga. Wajib dimainkan oleh semua penggemar metroidvania.</p>
                ',
                'category_slug' => 'reviews',
                'tags' => ['action', 'indie', 'single-player'],
                'status' => 'published',
                'views' => 3600,
            ],

            // ===== GUIDES =====
            [
                'title' => 'Panduan Lengkap Menjadi Pro Player Valorant: Dari Iron ke Radiant',
                'excerpt' => 'Mau naik rank di Valorant? Ikuti panduan komprehensif ini yang mencakup aim training, game sense, agent mastery, dan strategi tim.',
                'content' => '
<p>Valorant adalah game yang membutuhkan kombinasi aim tajam, game sense cerdas, dan komunikasi tim yang baik. Dalam panduan ini, kami akan membahas semua aspek yang perlu kamu kuasai untuk naik dari Iron ke Radiant.</p>

<h2>Dasar-dasar Aim Training</h2>
<p>Aim adalah fondasi utama Valorant. Luangkan waktu 15-30 menit setiap hari untuk aim training menggunakan Aim Lab atau Range bawaan Valorant. Fokus pada crosshair placement yang selalu setinggi kepala musuh, tracking, dan flick shot.</p>

<p>Deathmatch adalah mode terbaik untuk melatih aim dalam situasi realistis. Targetkan minimal 15 kill per match, dan jangan pernah berhenti bergerak. Deadzoning - teknik menembak sambil strafe - adalah skill krusial yang harus kamu kuasai.</p>

<h2>Agent Mastery</h2>
<p>Jangan jadi jack of all trades. Pilih 2-3 agent yang kamu kuasai benar-benar. Pahami setiap utility yang dimiliki, line-up untuk molly dan smoke, serta timing yang tepat untuk menggunakan ultimate.</p>

<p>Untuk pemula, disarankan memulai dengan agent Duelist seperti Phoenix atau Reyna yang lebih forgiving. Setelah itu, pelajari Controller seperti Omen atau Brimstone untuk memahami fundamental map control.</p>

<h2>Game Sense dan Positioning</h2>
<p>Game sense adalah kemampuan membaca permainan. Perhatikan minimap setiap 2-3 detik. Pelajari pattern musuh, ekonomimu, dan timing rotasi. Positioning yang baik berarti selalu berada di posisi yang menguntungkan: dekat cover, punya escape route, dan tidak mudah dipush.</p>

<h2>Komunikasi Tim</h2>
<p>Valorant adalah game tim. Komunikasi yang efektif bisa memenangkan round yang sekilas mustahil. Berikan callout yang jelas dan singkat: jumlah musuh, lokasi, dan damage yang sudah diberikan. Jangan toxic - itu hanya akan merusak fokus tim.</p>

<h2>Kesimpulan</h2>
<p>Naik rank di Valorant butuh waktu dan dedikasi. Jangan frustrasi dengan kekalahan. Analisis replay-mu, pelajari kesalahan, dan terus berlatih. Dengan konsistensi, rank Radiant bukan lagi mimpi.</p>
                ',
                'category_slug' => 'guides',
                'tags' => ['fps', 'multiplayer', 'strategy'],
                'status' => 'published',
                'views' => 3200,
            ],

            [
                'title' => 'Tips dan Trik Free Fire: Cara Cepat ke Rank Heroic',
                'excerpt' => 'Ingin tembus rank Heroic di Free Fire? Ikuti panduan lengkap ini yang mencakup strategi drop, senjata terbaik, dan taktik rotasi yang dipakai pro player.',
                'content' => '
<p>Free Fire mungkin terlihat sederhana, tapi untuk mencapai rank Heroic dibutuhkan strategi yang tepat. Berikut panduan lengkap yang dirangkum dari pengalaman top global player.</p>

<h2>Strategi Drop</h2>
<p>Pilih lokasi drop yang seimbang antara loot bagus dan risiko encounter. Lokasi seperti Mars Electric dan Clock Tower menawarkan loot kelas atas tapi juga ramai pemain. Untuk pendakian rank yang aman, pilih lokasi pinggir map seperti Sentosa atau Bimasakti junction.</p>

<p>Pastikan kamu selalu drop bersama tim dan komunikasikan target lokasi sebelum pesawat take off. Jangan terpisah - dalam ranked, tim yang terpecah adalah sasaran empuk.</p>

<h2>Loadout Senjata Terbaik</h2>
<p>Untuk ranked, kombinasi senjata terbaik adalah assault rifle + SMG. AR seperti M4A1 atau SCAR digunakan untuk medium-long range, sementara SMG seperti MP5 atau Vector untuk close combat. Pelajari recoil pattern masing-masing senjata dan kuasai spray control.</p>

<p>Jangan lupa utility: granat untuk force enemy keluar dari cover, smoke untuk rotasi aman, dan gloo wall untuk pertahanan darurat. Setiap item di inventory harus punya tujuan.</p>

<h2>Taktik Rotasi</h2>
<p>Rotasi yang cerdas adalah kunci top 3. Selalu bergerak mengikuti safe zone, hindari open area, dan gunakan natural cover sebanyak mungkin. Jika memungkinkan, gunakan kendaraan untuk rotasi cepat, tapi waspada karena kendaraan menarik perhatian.</p>

<p>Di late game, jangan terburu-buru push. Biarkan tim lain bertarung dan habiskan sumber daya mereka. Manfaatkan momen ketika dua tim bertempur untuk melakukan third party.</p>

<h2>Mental dan Konsistensi</h2>
<p>Ranked butuh mental baja. Akan ada hari-hari di mana kamu lose streak dan merasa ingin menyerah. Istirahat sejenak, refresh pikiran, dan kembali bermain dengan fokus baru. Konsistensi adalah kunci utama.</p>
                ',
                'category_slug' => 'guides',
                'tags' => ['fps', 'multiplayer', 'battle-royale'],
                'status' => 'published',
                'views' => 5800,
            ],
        ];

        foreach ($articles as $data) {
            $category = Category::where('slug', $data['category_slug'])->first();
            $user = User::inRandomOrder()->first();
            $tags = $data['tags'];
            unset($data['category_slug'], $data['tags']);

            $article = Article::create([
                ...$data,
                'slug' => Str::slug($data['title']).'-'.Str::random(5),
                'category_id' => $category->id,
                'user_id' => $user->id,
                'views' => 0,
                'published_at' => now()->subDays(rand(1, 90)),
            ]);

            $tagIds = \App\Models\Tag::whereIn('slug', $tags)->pluck('id');
            $article->tags()->attach($tagIds);
        }
    }
}

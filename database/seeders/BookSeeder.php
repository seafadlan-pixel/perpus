<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama dengan aman
        Schema::disableForeignKeyConstraints();
        Book::query()->delete();
        Schema::enableForeignKeyConstraints();

        // 1. Data Lokal 20 Buku Indonesia Terpopuler dari Berbagai Genre (dengan Cover Sesuai)
        $fallbackBooks = [
            // === ROMANCE (ROMANSA) ===
            [
                'title' => 'Perahu Kertas',
                'author' => 'Dee Lestari',
                'publisher' => 'Bentang Pustaka',
                'year' => 2009,
                'stock' => 8,
                'language' => 'Indonesian',
                'isbn' => '978-9793062945',
                'category' => 'Romance',
                'synopsis' => 'Kisah cinta dan pencarian jati diri antara Kugy, gadis unik penemu surat perahu kertas, dan Keenan, pelukis berbakat yang dipaksa kuliah ekonomi.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/12648480-L.jpg',
            ],
            [
                'title' => 'Dilan: Dia adalah Dilanku Tahun 1990',
                'author' => 'Pidi Baiq',
                'publisher' => 'Pastel Books',
                'year' => 2014,
                'stock' => 10,
                'language' => 'Indonesian',
                'isbn' => '978-6027870413',
                'category' => 'Romance',
                'synopsis' => 'Kisah cinta SMA tahun 1990 antara Milea dan Dilan, anggota geng motor di Bandung yang memiliki cara unik dalam mendekati wanita.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/12832961-L.jpg',
            ],
            [
                'title' => 'Critical Eleven',
                'author' => 'Ika Natassa',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2015,
                'stock' => 6,
                'language' => 'Indonesian',
                'isbn' => '978-6020318929',
                'category' => 'Romance',
                'synopsis' => 'Kisah manis dan getir hubungan pernikahan Tanya dan Aldebaran yang diuji oleh tragedi besar setelah pertemuan pertama di pesawat.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9786020318929-L.jpg',
            ],

            // === FANTASY & SCI-FI (FANTASI & FIKSI ILMIAH) ===
            [
                'title' => 'Bumi',
                'author' => 'Tere Liye',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2014,
                'stock' => 8,
                'language' => 'Indonesian',
                'isbn' => '978-6020301129',
                'category' => 'Fantasy',
                'synopsis' => 'Petualangan fantasi Raib, seorang gadis remaja yang bisa menghilang, bersama dua temannya Seli dan Ali di klan Bulan.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/13890252-L.jpg',
            ],
            [
                'title' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh',
                'author' => 'Dee Lestari',
                'publisher' => 'Truedee Books',
                'year' => 2001,
                'stock' => 5,
                'language' => 'Indonesian',
                'isbn' => '978-9793062044',
                'category' => 'Science Fiction',
                'synopsis' => 'Novel fiksi sains filosofis yang menggabungkan sains populer, spiritualitas, teori chaos, dan kisah cinta segitiga yang rumit.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/13044984-L.jpg',
            ],
            [
                'title' => 'Aroma Karsa',
                'author' => 'Dee Lestari',
                'publisher' => 'Bentang Pustaka',
                'year' => 2018,
                'stock' => 7,
                'language' => 'Indonesian',
                'isbn' => '978-6022914631',
                'category' => 'Fantasy',
                'synopsis' => 'Pencarian tanaman mistis Puspa Karsa yang melibatkan Jati Wesi si pemilik hidung luar biasa dan Raras Prayagung.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9786022914631-L.jpg',
            ],

            // === HORROR & MYSTERY (HOROR & MISTERI) ===
            [
                'title' => 'Danur',
                'author' => 'Risa Saraswati',
                'publisher' => 'Bukune',
                'year' => 2011,
                'stock' => 5,
                'language' => 'Indonesian',
                'isbn' => '978-9797805173',
                'category' => 'Horror',
                'synopsis' => 'Kisah nyata Risa Saraswati yang berteman dengan lima hantu anak-anak keturunan Belanda di rumah neneknya.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9789797805173-L.jpg',
            ],
            [
                'title' => 'KKN di Desa Penari',
                'author' => 'SimpleMan',
                'publisher' => 'Bukune',
                'year' => 2019,
                'stock' => 6,
                'language' => 'Indonesian',
                'isbn' => '978-6022203377',
                'category' => 'Horror',
                'synopsis' => 'Kisah mencekam sekelompok mahasiswa yang melaksanakan KKN di desa terpencil dan melanggar aturan mistis setempat.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/978-6022203377-L.jpg',
            ],
            [
                'title' => 'Katarsis',
                'author' => 'Anastasia Aemilia',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2013,
                'stock' => 4,
                'language' => 'Indonesian',
                'isbn' => '978-9792295672',
                'category' => 'Thriller',
                'synopsis' => 'Sebuah thriller psikologis gelap tentang gadis muda bernama Tara yang menjadi satu-satunya saksi pembunuhan tragis keluarganya.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9789792295672-L.jpg',
            ],

            // === SELF-HELP (PENGEMBANGAN DIRI) ===
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publisher' => 'Buku Kompas',
                'year' => 2018,
                'stock' => 12,
                'language' => 'Indonesian',
                'isbn' => '978-6024125189',
                'category' => 'Self-Help',
                'synopsis' => 'Panduan praktis filsafat Yunani-Romawi kuno (Stoisisme) untuk mengatasi kekhawatiran dan emosi negatif di kehidupan modern.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9786024125189-L.jpg',
            ],
            [
                'title' => 'Bicara Itu Ada Seninya',
                'author' => 'Oh Su Hyang',
                'publisher' => 'Bhuana Ilmu Populer',
                'year' => 2018,
                'stock' => 9,
                'language' => 'Indonesian',
                'isbn' => '978-6024523930',
                'category' => 'Self-Help',
                'synopsis' => 'Buku terjemahan laris yang membahas metode komunikasi efektif, cara berbicara persuasif, dan seni mencairkan suasana.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9786024523930-L.jpg',
            ],

            // === HISTORICAL FICTION (FIKSI SEJARAH) ===
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'year' => 1980,
                'stock' => 5,
                'language' => 'Indonesian',
                'isbn' => '978-9799731234',
                'category' => 'Historical Fiction',
                'synopsis' => 'Karya sastra klasik yang menyoroti kebangkitan nasionalisme pribumi melalui kisah cinta Minke dan Annelies di akhir era kolonial.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/10574043-L.jpg',
            ],
            [
                'title' => 'Gadis Kretek',
                'author' => 'Ratih Kumala',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2012,
                'stock' => 5,
                'language' => 'Indonesian',
                'isbn' => '978-9792281415',
                'category' => 'Historical Fiction',
                'synopsis' => 'Kisah cinta berlatar belakang perkembangan industri rokok kretek lokal yang sarat budaya Jawa pasca-kemerdekaan.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/13854124-L.jpg',
            ],

            // === INSPIRATIONAL & ADVENTURE (INSPIRATIF & PETUALANGAN) ===
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'stock' => 10,
                'language' => 'Indonesian',
                'isbn' => '978-9793062792',
                'category' => 'Adventure',
                'synopsis' => 'Kisah luar biasa anak-anak Laskar Pelangi di Belitung dalam mewujudkan mimpi sekolah mereka yang sederhana.',
                'cover_image' => 'https://covers.openlibrary.org/b/id/12833077-L.jpg',
            ],
            [
                'title' => '5 cm',
                'author' => 'Donny Dhirgantoro',
                'publisher' => 'Grasindo',
                'year' => 2005,
                'stock' => 7,
                'language' => 'Indonesian',
                'isbn' => '978-9790150249',
                'category' => 'Adventure',
                'synopsis' => 'Kisah lima sahabat karib yang menantang diri mereka mendaki puncak tertinggi di Pulau Jawa, Mahameru, demi persahabatan dan cinta tanah air.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9789790150249-L.jpg',
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2009,
                'stock' => 7,
                'language' => 'Indonesian',
                'isbn' => '978-9792256307',
                'category' => 'Adventure',
                'synopsis' => 'Kisah persahabatan enam santri dari berbagai daerah yang dipersatukan di pesantren dan bermimpi menaklukkan dunia dengan tekad "Man Jadda Wajada".',
                'cover_image' => 'https://covers.openlibrary.org/b/id/12872523-L.jpg',
            ],

            // === DRAMA & FAMILY (DRAMA & KELUARGA) ===
            [
                'title' => 'Sabtu Bersama Bapak',
                'author' => 'Adhitya Mulya',
                'publisher' => 'GagasMedia',
                'year' => 2014,
                'stock' => 6,
                'language' => 'Indonesian',
                'isbn' => '978-9797807214',
                'category' => 'Drama',
                'synopsis' => 'Kisah hangat tentang perjuangan seorang bapak yang meninggalkan rekaman video pesan kehidupan sabtu mingguan untuk membimbing kedua anaknya tumbuh dewasa.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9789797807214-L.jpg',
            ],
            [
                'title' => 'Ronggeng Dukuh Paruk',
                'author' => 'Ahmad Tohari',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 1982,
                'stock' => 4,
                'language' => 'Indonesian',
                'isbn' => '978-9792201963',
                'category' => 'Drama',
                'synopsis' => 'Kisah cinta tragis Srintil, seorang penari ronggeng, dan Rasus, teman masa kecilnya, dengan latar belakang konflik sosial politik tahun 1965.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9789792201963-L.jpg',
            ],

            // === POETRY & SASTRA (PUISI) ===
            [
                'title' => 'Hujan Bulan Juni',
                'author' => 'Sapardi Djoko Damono',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2015,
                'stock' => 5,
                'language' => 'Indonesian',
                'isbn' => '978-6020318431',
                'category' => 'Poetry',
                'synopsis' => 'Kumpulan puisi legendaris karya Sapardi Djoko Damono yang romantis, melankolis, dan penuh perenungan makna kesabaran cinta.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9786020318431-L.jpg',
            ],
            [
                'title' => 'Tidak Ada New York Hari Ini',
                'author' => 'M. Aan Mansyur',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2016,
                'stock' => 5,
                'language' => 'Indonesian',
                'isbn' => '978-6020327129',
                'category' => 'Poetry',
                'synopsis' => 'Kumpulan puisi cinta Aan Mansyur yang menjadi bagian penting dari puisi-puisi Rangga dalam film Ada Apa dengan Cinta? 2.',
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9786020327129-L.jpg',
            ],
        ];

        // 2. Fetch data from Bukuacak API with local fallback
        $seededCount = 0;
        $useFallback = false;
        $booksData = [];

        try {
            // Request 100 books from the Bukuacak API
            $response = Http::timeout(10)->get('https://api.bukuacak.shabsolute.tech/api/v1/book', [
                'limit' => 100,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $booksData = $data['books'] ?? [];
                if (empty($booksData)) {
                    $useFallback = true;
                }
            } else {
                $useFallback = true;
            }
        } catch (\Exception $e) {
            Log::warning('Gagal menghubungi API Bukuacak, menggunakan data lokal: ' . $e->getMessage());
            $useFallback = true;
        }

        if ($useFallback) {
            Log::info('Melakukan seeding menggunakan data fallback lokal.');
            foreach ($fallbackBooks as $localBook) {
                $coverUrl = $localBook['cover_image'];
                
                try {
                    // Cari data di Google Books API untuk mengambil cover yang lebih responsif jika ada
                    $response = Http::timeout(4)->get('https://www.googleapis.com/books/v1/volumes', [
                        'q' => 'isbn:' . str_replace('-', '', $localBook['isbn']),
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $items = $data['items'] ?? [];
                        if (count($items) > 0) {
                            $volumeInfo = $items[0]['volumeInfo'] ?? [];
                            $apiCover = $volumeInfo['imageLinks']['thumbnail'] ?? null;
                            if ($apiCover) {
                                $coverUrl = str_replace('http://', 'https://', $apiCover);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::debug('Menggunakan cover lokal bawaan untuk ' . $localBook['title'] . ': ' . $e->getMessage());
                }

                // Simpan data novel
                Book::create([
                    'title' => $localBook['title'],
                    'author' => $localBook['author'],
                    'publisher' => $localBook['publisher'],
                    'year' => $localBook['year'],
                    'stock' => $localBook['stock'],
                    'language' => $localBook['language'],
                    'isbn' => $localBook['isbn'],
                    'category' => $localBook['category'],
                    'synopsis' => $localBook['synopsis'],
                    'cover_image' => $coverUrl,
                ]);
                $seededCount++;
            }
        } else {
            Log::info('Melakukan seeding menggunakan data dari API Bukuacak.');
            foreach ($booksData as $apiBook) {
                // Parse year from published_date
                $year = 2024;
                $publishedDate = $apiBook['details']['published_date'] ?? '';
                if (preg_match('/\b(19\d\d|20\d\d)\b/', $publishedDate, $matches)) {
                    $year = (int)$matches[1];
                }

                // Extract author name
                $author = $apiBook['author']['name'] ?? 'Unknown Author';

                // Extract category name
                $category = $apiBook['category']['name'] ?? 'Umum';

                // Extract ISBN
                $isbn = $apiBook['details']['isbn'] ?? null;
                if (!$isbn || $isbn === '0' || $isbn === '0.0') {
                    $isbn = '978-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(0, 9);
                }

                Book::create([
                    'title' => $apiBook['title'] ?? 'Untitled Book',
                    'author' => $author,
                    'publisher' => $apiBook['publisher'] ?? 'Gramedia Pustaka Utama',
                    'year' => $year,
                    'stock' => rand(1, 15),
                    'language' => 'Indonesian',
                    'isbn' => $isbn,
                    'category' => $category,
                    'synopsis' => $apiBook['summary'] ?? null,
                    'cover_image' => $apiBook['cover_image'] ?? null,
                ]);
                $seededCount++;
            }
        }

        Log::info("Berhasil melakukan seeding sebanyak {$seededCount} buku.");
    }
}

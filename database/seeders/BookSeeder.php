<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'The Lord of the Rings',
            'author' => 'J.R.R. Tolkien',
            'publisher' => 'George Allen & Unwin',
            'year' => 1954,
            'stock' => 5,
            'language' => 'English',
            'isbn' => '978-0544003415',
            'category' => 'Fantasy',
            'synopsis' => 'An epic high fantasy novel following the quest to destroy the One Ring.',
            'cover_image' => 'https://covers.openlibrary.org/b/id/8259440-L.jpg',
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'publisher' => 'Secker & Warburg',
            'year' => 1949,
            'stock' => 3,
            'language' => 'English',
            'isbn' => '978-0451524935',
            'category' => 'Dystopian',
            'synopsis' => 'A chilling dystopian novel about totalitarianism and mass surveillance.',
            'cover_image' => 'https://covers.openlibrary.org/b/id/15325672-L.jpg',
        ]);

        Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang Pustaka',
            'year' => 2005,
            'stock' => 10,
            'language' => 'Indonesian',
            'isbn' => '978-9793062792',
            'category' => 'Fiction',
            'synopsis' => 'Kisah inspiratif tentang anak-anak di Belitung yang berjuang untuk mendapatkan pendidikan.',
            'cover_image' => 'https://covers.openlibrary.org/b/id/12833077-L.jpg',
        ]);

        Book::create([
            'title' => 'Sapiens: A Brief History of Humankind',
            'author' => 'Yuval Noah Harari',
            'publisher' => 'Harvill Secker',
            'year' => 2011,
            'stock' => 7,
            'language' => 'English',
            'isbn' => '978-0062316097',
            'category' => 'History',
            'synopsis' => 'A broad overview of human history from the Stone Age to the modern era.',
            'cover_image' => 'https://covers.openlibrary.org/b/id/12470940-L.jpg',
        ]);

        Book::create([
            'title' => 'Bumi Manusia',
            'author' => 'Pramoedya Ananta Toer',
            'publisher' => 'Hasta Mitra',
            'year' => 1980,
            'stock' => 4,
            'language' => 'Indonesian',
            'isbn' => '978-9799731234',
            'category' => 'Historical Fiction',
            'synopsis' => 'Kisah cinta dan perjuangan Minke di masa kolonial Hindia Belanda.',
            'cover_image' => 'https://covers.openlibrary.org/b/id/10574043-L.jpg',
        ]);
    }
}

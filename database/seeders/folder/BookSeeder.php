<?php

namespace Database\Seeders\Folder;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            // Horror
            [
                'title' => 'It',
                'author' => 'Stephen King',
                'genre' => 'Horror',
            ],
            [
                'title' => 'The Shining',
                'author' => 'Stephen King',
                'genre' => 'Horror',
            ],
            // Adventure
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'genre' => 'Adventure',
            ],
            [
                'title' => 'Treasure Island',
                'author' => 'Robert Louis Stevenson',
                'genre' => 'Adventure',
            ],
            // Romance
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'genre' => 'Romance',
            ],
            [
                'title' => 'Me Before You',
                'author' => 'Jojo Moyes',
                'genre' => 'Romance',
            ],
            // Fantasy
            [
                'title' => 'Harry Potter',
                'author' => 'J.K. Rowling',
                'genre' => 'Fantasy',
            ],
            [
                'title' => 'A Court of Thorns and Roses',
                'author' => 'Sarah J. Maas',
                'genre' => 'Fantasy',
            ],
            // History
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'genre' => 'History',
            ],
            [
                'title' => 'The Book Thief',
                'author' => 'Markus Zusak',
                'genre' => 'History',
            ],
        ];

        foreach ($books as $book) {
            $author = Author::where('fullname', $book['author'])->first();
            $genre  = Genre::where('name', $book['genre'])->first();

            if ($author && $genre) {
                Book::firstOrCreate([
                    'title'     => $book['title'],
                    'author_id' => $author->id,
                    'genre_id'  => $genre->id,
                    'image' => str_replace(' ', '_', $book['title']) . '.png',
                ]);
            }
        }
    }
}

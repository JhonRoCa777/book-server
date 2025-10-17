<?php

namespace Database\Seeders\Folder;

use App\Models\Book;
use App\Models\BookSerial;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BookSerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();

        foreach ($books as $book) {
            // Crear 3 seriales por cada libro
            for ($i = 0; $i < 3; $i++) {
                BookSerial::create([
                    'book_id' => $book->id,
                    'serial'  => Str::uuid()->toString(),
                ]);
            }
        }
    }
}

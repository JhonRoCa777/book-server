<?php

namespace Database\Seeders\Folder;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            'Stephen King',
            'J.R.R. Tolkien',
            'Robert Louis Stevenson',
            'Jane Austen',
            'Jojo Moyes',
            'J.K. Rowling',
            'Sarah J. Maas',
            'George Orwell',
            'Markus Zusak',
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate(['fullname' => $author]);
        }
    }
}

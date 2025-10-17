<?php

namespace Database\Seeders;

use Database\Seeders\Folder\AuthorSeeder;
use Database\Seeders\Folder\BookSeeder;
use Database\Seeders\Folder\BookSerialSeeder;
use Database\Seeders\Folder\GenreSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(GenreSeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(BookSerialSeeder::class);
    }
}

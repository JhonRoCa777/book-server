<?php

namespace Database\Seeders\Folder;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::join('credentials', 'users.id', '=', 'credentials.id')
                    ->where('credentials.role', '!=', 'admin')
                    ->select('users.*')
                    ->get();

        $bookLoans = [
            [
                //FEBRERO
                [
                    'book' => 'The Hobbit',
                    'created_at' => '01-02-25',
                    'end_date' => '28-02-25',
                    'deleted_at' => '25-02-25'
                ],
                //MARZO
                [
                    'book' => 'The Shining',
                    'created_at' => '01-03-25',
                    'end_date' => '28-03-25',
                    'deleted_at' => '25-03-25'
                ],
                [
                    'book' => '1984',
                    'created_at' => '05-03-25',
                    'end_date' => '28-03-25',
                    'deleted_at' => '25-03-25'
                ],
                //JULIO
                [
                    'book' => 'The Shining',
                    'created_at' => '01-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                [
                    'book' => '1984',
                    'created_at' => '05-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                //AGOSTO
                [
                    'book' => 'It',
                    'created_at' => '01-08-25',
                    'end_date' => '28-08-25',
                    'deleted_at' => '25-08-25'
                ],
                //OCTUBRE
                [
                    'book' => 'It',
                    'created_at' => '01-10-25',
                    'end_date' => '15-10-25',
                    'deleted_at' => null
                ],
                [
                    'book' => 'The Hobbit',
                    'created_at' => '05-10-25',
                    'end_date' => '28-10-25',
                    'deleted_at' => null
                ],
            ],
            [
                //FEBRERO
                [
                    'book' => 'A Court of Thorns and Roses',
                    'created_at' => '01-02-25',
                    'end_date' => '28-02-25',
                    'deleted_at' => '25-02-25'
                ],
                [
                    'book' => 'Me Before You',
                    'created_at' => '01-02-25',
                    'end_date' => '28-02-25',
                    'deleted_at' => '25-02-25'
                ],
                [
                    'book' => 'Pride and Prejudice',
                    'created_at' => '01-02-25',
                    'end_date' => '28-02-25',
                    'deleted_at' => '25-02-25'
                ],
                //MARZO
                [
                    'book' => 'The Hobbit',
                    'created_at' => '01-03-25',
                    'end_date' => '28-03-25',
                    'deleted_at' => '25-03-25'
                ],
                //JULIO
                [
                    'book' => 'Harry Potter',
                    'created_at' => '01-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                [
                    'book' => 'Me Before You',
                    'created_at' => '01-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                [
                    'book' => 'Pride and Prejudice',
                    'created_at' => '01-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                //AGOSTO
                [
                    'book' => 'Me Before You',
                    'created_at' => '01-08-25',
                    'end_date' => '28-08-25',
                    'deleted_at' => '25-08-25'
                ],
                [
                    'book' => 'Pride and Prejudice',
                    'created_at' => '01-08-25',
                    'end_date' => '28-08-25',
                    'deleted_at' => '25-08-25'
                ],
                //OCTUBRE
                [
                    'book' => 'Harry Potter',
                    'created_at' => '01-10-25',
                    'end_date' => '28-10-25',
                    'deleted_at' => null
                ],
                [
                    'book' => 'The Hobbit',
                    'created_at' => '05-10-25',
                    'end_date' => '28-10-25',
                    'deleted_at' => null
                ],
            ],
            [
                //FEBRERO
                [
                    'book' => 'The Book Thief',
                    'created_at' => '01-02-25',
                    'end_date' => '28-02-25',
                    'deleted_at' => '25-02-25'
                ],
                //MARZO
                [
                    'book' => 'The Hobbit',
                    'created_at' => '01-03-25',
                    'end_date' => '28-03-25',
                    'deleted_at' => '25-03-25'
                ],
                //JULIO
                [
                    'book' => 'The Book Thief',
                    'created_at' => '01-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                [
                    'book' => 'The Hobbit',
                    'created_at' => '01-07-25',
                    'end_date' => '28-07-25',
                    'deleted_at' => '25-07-25'
                ],
                //AGOSTO
                [
                    'book' => 'The Hobbit',
                    'created_at' => '01-08-25',
                    'end_date' => '28-08-25',
                    'deleted_at' => '25-08-25'
                ],
                //OCTUBRE
                [
                    'book' => 'The Book Thief',
                    'created_at' => '01-10-25',
                    'end_date' => '28-10-25',
                    'deleted_at' => null
                ],
                [
                    'book' => 'The Hobbit',
                    'created_at' => '05-10-25',
                    'end_date' => '28-10-25',
                    'deleted_at' => null
                ],
            ]
        ];

        foreach ($users as $idx => $user) {
            foreach ($bookLoans[$idx] as $loan) {
                $book = Book::where('title', $loan['book'])->first();

                if (!$book) continue;

                $serial = $book->serials()
                    ->whereDoesntHave('loans', function ($q) {
                        $q->whereNull('deleted_at');
                    })->first();

                if (!$serial) continue;

                BookLoan::firstOrCreate([
                    'user_id'        => $user->id,
                    'book_serial_id' => $serial->id,
                ], [
                    'created_at'     => $loan['created_at'],
                    'end_date'       => $loan['end_date'],
                    'deleted_at'     => $loan['deleted_at'],
                ]);
            }
        }
    }
}

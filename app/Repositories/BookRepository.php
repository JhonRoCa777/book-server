<?php

namespace App\Repositories;

use App\Interfaces\IBookRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookRepository implements IBookRepository
{
    public function all(): array
    {
        $rows = DB::select("
            SELECT
                b.id AS book_id,
                b.title,
                b.image,
                a.fullname AS author,
                g.name AS genre,
                bs.id AS serial_id,
                bs.serial,
                bl.id AS loan_id,
                bl.user_id,
                bl.created_at,
                bl.end_date,
                bl.deleted_at,
                u.document,
                u.names,
                u.last_names
            FROM books b
            JOIN authors a ON a.id = b.author_id
            JOIN genres g ON g.id = b.genre_id
            JOIN book_serials bs ON bs.book_id = b.id
            LEFT JOIN book_loans bl
                ON bl.book_serial_id = bs.id
                AND bl.id = (
                    SELECT MAX(bl2.id)
                    FROM book_loans bl2
                    WHERE bl2.book_serial_id = bs.id
                )
            LEFT JOIN users u ON u.id = bl.user_id
            ORDER BY b.id, bs.id
        ");

        $books = [];

        foreach ($rows as $row) {
            if (!isset($books[$row->book_id])) {
                $books[$row->book_id] = [
                    'book_id' => $row->book_id,
                    'title' => $row->title,
                    'image' => $row->image,
                    'author' => $row->author,
                    'genre' => $row->genre,
                    'serials' => [],
                ];
            }

            $status = 'DISPONIBLE';
            $loan = null;

            if ($row->deleted_at === null && $row->end_date !== null) {
                $endDate = Carbon::parse($row->end_date);

                if ($endDate->isPast()) {
                    $status = 'MORA';
                } elseif ($endDate->isFuture()) {
                    $status = 'PRESTADO';
                }

                $loan = [
                    'id' => $row->loan_id,
                    'user' => [
                        'document' => $row->document,
                        'names' => $row->names,
                        'last_names' => $row->last_names,
                    ],
                    'created_at' => $row->created_at,
                    'end_date' => $row->end_date,
                ];
            }

            $books[$row->book_id]['serials'][] = [
                'serial_id' => $row->serial_id,
                'serial' => $row->serial,
                'status' => $status,
                'loan' => $loan,
            ];
        }

        return array_values($books);
    }

    public function allByUser(int $userId): array
    {
        $rows = DB::select("
            SELECT
                b.id AS book_id,
                b.title,
                b.image,
                a.fullname AS author,
                g.name AS genre,
                bs.id AS serial_id,
                bs.serial,
                bl.id AS loan_id,
                bl.user_id,
                bl.created_at,
                bl.end_date,
                bl.deleted_at,
                u.document,
                u.names,
                u.last_names
            FROM books b
            JOIN authors a ON a.id = b.author_id
            JOIN genres g ON g.id = b.genre_id
            JOIN book_serials bs ON bs.book_id = b.id
            JOIN book_loans bl ON bl.book_serial_id = bs.id
            JOIN users u ON u.id = bl.user_id
            WHERE bl.user_id = ?
            ORDER BY b.id, bs.id
        ", [$userId]);

        $books = [];

        foreach ($rows as $row) {
            // Filtrar solo MORA o PRESTADO
            if ($row->deleted_at !== null || $row->end_date === null) {
                continue;
            }

            $endDate = Carbon::parse($row->end_date);
            if (!$endDate->isPast() && !$endDate->isFuture()) continue;

            $status = $endDate->isPast() ? 'MORA' : 'PRESTADO';

            if (!isset($books[$row->book_id])) {
                $books[$row->book_id] = [
                    'book_id' => $row->book_id,
                    'title' => $row->title,
                    'image' => $row->image,
                    'author' => $row->author,
                    'genre' => $row->genre,
                    'serials' => [],
                ];
            }

            $books[$row->book_id]['serials'][] = [
                'serial_id' => $row->serial_id,
                'serial' => $row->serial,
                'status' => $status,
                'loan' => [
                    'id' => $row->loan_id,
                    'user' => [
                        'document' => $row->document,
                        'names' => $row->names,
                        'last_names' => $row->last_names,
                    ],
                    'created_at' => $row->created_at,
                    'end_date' => $row->end_date,
                ],
            ];
        }

        return array_values($books);
    }
}

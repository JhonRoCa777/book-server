<?php

namespace App\Interfaces;

interface IBookRepository
{
    public function all(): array;
    public function allByUser(int $user_id): array;
}

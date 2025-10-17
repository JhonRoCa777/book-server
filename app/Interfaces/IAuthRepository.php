<?php

namespace App\Interfaces;

interface IAuthRepository
{
    public function login(array $credentials): bool;
    public function logout(): bool;
    public function me(): bool;
}

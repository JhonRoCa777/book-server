<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\IBookRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(
        private IBookRepository $bookRepository
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->bookRepository->all());
    }

    public function show(Request $request): JsonResponse
    {
        $id = $request->attributes->get('auth_user_id');
        return response()->json($this->bookRepository->allByUser($id));
    }
}

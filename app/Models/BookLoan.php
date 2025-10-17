<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookLoan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'end_date',
        'user_id',
        'book_serial_id',
    ];

    protected $dates = ['end_date'];
}

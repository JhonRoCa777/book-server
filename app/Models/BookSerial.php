<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSerial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'book_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'book_loans');
    }
}

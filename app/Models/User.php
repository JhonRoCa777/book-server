<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document',
        'names',
        'last_names',
        'credential_id',
    ];

    public function credential()
    {
        return $this->belongsTo(Credential::class);
    }

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'book_serial_id');
    }

    public function bookSerials()
    {
        return $this->belongsToMany(BookSerial::class, 'book_loans');
    }
}

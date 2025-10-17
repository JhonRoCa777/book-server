<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credential extends Model
{
    use SoftDeletes;

    protected $fillable = ['username', 'password'];

    protected $casts = [
        'role' => Role::class,
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}

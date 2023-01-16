<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];
    protected $hidden = [
        'id',
        'password',
        'created_at',
        'updated_at',
    ];
}
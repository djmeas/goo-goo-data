<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caretaker extends Model
{
    protected $fillable = [
        'user_id',
        'child_id',
        'role',
        'is_admin',
        'is_parent',
        'full_access',
        'created_at',
        'updated_at'
    ];
}

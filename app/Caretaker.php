<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caretaker extends Model
{
    protected $fillable = [
        'user_id',
        'child_id'
    ];
}

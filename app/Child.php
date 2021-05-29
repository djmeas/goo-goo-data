<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $table = 'children';

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'hash'
    ];
}

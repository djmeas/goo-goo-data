<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $table = 'users';

    protected $hidden = [
        'password', 'remember_token',
    ];
}

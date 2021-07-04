<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This class represents the logged in user entity.
 */
class AppUser extends Model
{
    protected $table = 'users';

    protected $hidden = [
        'password', 'remember_token',
    ];
}

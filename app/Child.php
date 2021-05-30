<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Child extends Model
{
    protected $table = 'children';

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'hash',
        'image_path'
    ];

    protected $with = ['Caretaker'];

    public function Caretaker() {
        return $this->hasMany('App\Caretaker');
    }
}

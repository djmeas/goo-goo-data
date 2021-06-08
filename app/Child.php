<?php

namespace App;

use Illuminate\Support\Arr;

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

    // Relationships

    protected $with = ['Caretaker'];

    public function Caretaker() {
        return $this->hasMany('App\Caretaker');
    }

    // Static Functions

    public static function accessibleChildren() {
        return Arr::pluck(Caretaker::where('user_id', Auth::id())->get(), 'child_id');
    }

    public static function getAllCaretakerUsers($child_id) {
        $caretaker_users = Arr::pluck(Caretaker::where('child_id', $child_id)
            ->get(), 'user_id');
        
        if ($caretaker_users) {
            return AppUser::whereIn('id', $caretaker_users)->get();
        }
    }
}

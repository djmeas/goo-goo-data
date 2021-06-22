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
        'image_path',
        'full_access',
        'is_admin'
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
            $users = AppUser::whereIn('id', $caretaker_users)->get()->toArray();
            
            foreach ($users as &$user) {
                $caretaker = Caretaker::where('child_id', $child_id)
                    ->where('user_id', $user['id'])
                    ->first();

                $user['is_parent'] = $caretaker->is_parent;
                $user['role'] = $caretaker->role;
                $user['is_admin'] = $caretaker->is_admin;
                $user['full_access'] = $caretaker->full_access;
                
            }

            return $users;
        }
    }

    public static function getChildByHash($hash) {
        return Child::where('hash', $hash)
            ->whereIn('id', Child::accessibleChildren())
            ->first();
    }
}

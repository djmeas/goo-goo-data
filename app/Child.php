<?php

namespace App;

use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * This class represents the child or children entity.
 */
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

    /**
     * Relates a caretaker to a child.
     * 
     * @return  Illuminate\Database\Eloquent\Relations
     */
    public function Caretaker() {
        return $this->hasMany('App\Caretaker');
    }

    // Static Functions

    /**
     * Returns an array of the logged in user's list of children.
     * 
     * @return  Array
     */
    public static function accessibleChildren() {
        return Arr::pluck(Caretaker::where('user_id', Auth::id())->get(), 'child_id');
    }

    /**
     * Returns caretakers and user data nested conveniently together.
     * 
     * @return  Array
     */
    public static function getAllCaretakerUsers($child_id) {
        $caretaker_users = Arr::pluck(Caretaker::where('child_id', $child_id)
            ->get(), 'user_id');
        
        if ($caretaker_users) {
            $users = AppUser::whereIn('id', $caretaker_users)->get()->toArray();
            
            foreach ($users as &$user) {
                $caretaker = Caretaker::where('child_id', $child_id)
                    ->where('user_id', $user['id'])
                    ->first();

                $user['caretaker_id'] = $caretaker->id;
                $user['user_id'] = $user['id'];
                $user['is_parent'] = $caretaker->is_parent;
                $user['role'] = $caretaker->role;
                $user['is_admin'] = $caretaker->is_admin;
                $user['full_access'] = $caretaker->full_access;
                
            }

            return $users;
        }
    }

    /**
     * Finds a particular child (if they're accessbile to the logged in user).
     * 
     * @param  String  $hash
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public static function getChildByHash($hash) {
        return Child::where('hash', $hash)
            ->whereIn('id', Child::accessibleChildren())
            ->first();
    }
}

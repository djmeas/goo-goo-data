<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaretakerInvite extends Model
{
    protected $fillable = [
        'child_id',
        'email',
        'has_accepted',
        'accepted_datetime',
        'role',
        'is_admin',
        'full_access'
    ]; 

    protected $with = [
        'Child'
    ];

    public function Child() {
        return $this->belongsTo(Child::class);
    }
}

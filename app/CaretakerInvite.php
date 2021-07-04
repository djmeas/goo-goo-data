<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This class represents the caretaker invitation entity.
 */
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

    // Relationships

    /**
     * Relates a child to a caretaker invitation.
     * 
     * @return  Illuminate\Database\Eloquent\Relations
     */
    public function Child() {
        return $this->belongsTo(Child::class);
    }
}

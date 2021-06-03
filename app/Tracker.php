<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable = [
        'child_id',
        'category_id',
        'value',
        'notes',
        'entry_datetime'
    ];

    // Relationships

    protected $with = [
        'child',
        'category'
    ];

    public function child() {
        return $this->belongsTo(Child::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}

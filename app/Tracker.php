<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This class represents the tracker entry entity.
 */
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

    /**
     * Relates a child to a tracker entry.
     * 
     * @return  Illuminate\Database\Eloquent\Relations
     */
    public function child() {
        return $this->belongsTo(Child::class);
    }

    /**
     * Relates a category/subcategory to a tracker entry.
     * 
     * @return  Illuminate\Database\Eloquent\Relations
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
}

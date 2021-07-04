<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This class represents the category and subcategory entities.
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
        'prefix',
        'suffix'
    ];

    // Relationships

    /**
     * Relates tracker entries to categories/subcategories.
     * 
     * @return  Illuminate\Database\Eloquent\Relations
     */
    public function TrackerEntries() {
        return $this->hasMany(Tracker::class);
    }

    // Static Functions

    /**
     * Groups categories and nests options into an array.
     * 
     * @return Array
     */
    public static function getAll() {
        $categories = \App\Category::get()->toArray();

        $category_groups = [];

        foreach ($categories as $category) {
            $category_groups[$category['group']][] = $category;
        }

        return $category_groups;
    }
}

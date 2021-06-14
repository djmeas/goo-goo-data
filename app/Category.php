<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
        'prefix',
        'suffix'
    ];

    public function TrackerEntries() {
        return $this->hasMany(Tracker::class);
    }

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

/**
 * This class handles all interactions pertaining to categories and subcategories.
 */
class CategoryController extends Controller
{
    // API

    /**
     * Fetches all the category groups and nested options.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request) {
        return Category::getAll();
    }
}

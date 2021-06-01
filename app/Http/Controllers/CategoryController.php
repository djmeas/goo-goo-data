<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class CategoryController extends Controller
{
    /* API */

    /**
     * Fetches all the category groups and nested options.
     * 
     * @param Request $request 
     * @return Array
     */
    public function get(Request $request) {
        return Category::getAll();
    }
}

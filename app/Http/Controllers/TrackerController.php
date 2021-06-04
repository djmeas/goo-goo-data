<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Tracker;

class TrackerController extends Controller
{
    public function index() {
        return view('tracker.index');
    }

    /* API */

    public function get(Request $request, $hash = null, $tracker_id = null) {
        $tracker = Tracker::query();

        $tracker->join('children', 'children.id', '=', 'trackers.child_id');
        $tracker->join('categories', 'categories.id', '=', 'trackers.category_id');

        $tracker->select(
            'trackers.*', 
            'children.first_name as first_name',
            'children.last_name as last_name',
            'categories.name as category_name'
        );

        $tracker->whereIn('child_id', \App\Child::accessibleChildren());

        $tracker->orderBy(
            $request->get('sort') ?: 'entry_datetime',
            $request->get('dir') ?: 'ASC'
        );

        return $tracker->paginate(5);

        // return Tracker::whereIn('child_id', \App\Child::accessibleChildren())
        //     // ->orderBy('entry_datetime', 'ASC')
        //     ->paginate(5);
    }

    public function save(Request $request) {
        $form_data = $request->all();
        $entry_formatted = Carbon::parse($request->entry_datetime)->toDateTimeString();
        $form_data['entry_datetime'] = $entry_formatted;

        try {
            return Tracker::create($form_data);
        } catch (\Exception $e) {
            return response('Whoops! The entry could not be save.', 400);
        }
    }
}

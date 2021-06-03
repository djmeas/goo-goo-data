<?php

namespace App\Http\Controllers;

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
        return Tracker::whereIn('child_id', \App\Child::accessibleChildren())
            // ->orderBy('entry_datetime', 'ASC')
            ->paginate(5);
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

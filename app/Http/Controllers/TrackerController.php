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

        return $tracker->paginate(10);
    }

    public function save(Request $request) {
        $form_data = $request->all();
        $entry_formatted = Carbon::parse($request->entry_datetime)->toDateTimeString();
        $form_data['entry_datetime'] = $entry_formatted;

        try {
            if ($request->id) {
                Tracker::find($request->id)->update($form_data);
            } else {
                Tracker::create($form_data);
            }
            
            return response('Entry successfully saved.', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
            return response('Whoops! The entry could not be save.', 400);
        }
    }

    /**
     * Deletes the tracker entry data from the database.
     * @param Request $request The request collection.
     * @param String $id The entry's id.
     */
    public function delete(Request $request, $id = null) {
        try {
            if ($id) {
                $entry = Tracker::where('id', $id)
                    ->whereIn('child_id', \App\Child::accessibleChildren())
                    ->first();

                if (!$entry) {
                    return response('Entry does not exist or not associated with this user', 403);
                }

                $entry->delete();

                return response('Entry successfully deleted.', 200);
            }
        } catch (\Exception $e) {
            return response('Whoops! The entry could not be deleted.', 400);
        }
    }
}

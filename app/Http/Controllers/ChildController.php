<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Auth;
use App\Child;
use App\Caretaker;

class ChildController extends Controller
{
    /**
     * Loads the Children page.
     */
    public function index() {
        return view('children.index');
    }

    // API Routes

    /**
     * Fetches the child data from the database.
     * @param Request $request The request collection.
     * @param String $hash The child's unique hash.
     */
    public function get(Request $request, $hash = null) {
        if ($hash) {
            return Child::where('hash', $hash)
                ->with(['Caretaker' => function ($q) {
                    $q->where('user_id', Auth::id());
                }])
                ->whereHas('Caretaker', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                ->first();
        }

        return Child::with(['Caretaker' => function($q) {
                $q->where('user_id', Auth::id());
            }])
            ->whereHas('Caretaker', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->get();
    }

    /**
     * Deletes the child data from the database.
     * @param Request $request The request collection.
     * @param String $hash The child's unique hash.
     */
    public function delete(Request $request, $hash = null) {
        try {
            if ($hash) {
                $child = Child::where('hash', $hash)
                    ->with(['Caretaker' => function ($q) {
                        $q->where('user_id', Auth::id());
                    }])
                    ->whereHas('Caretaker', function ($q) {
                        $q->where('user_id', Auth::id());
                    })
                    ->first();

                if (!$child) {
                    return response('Child does not exist or not associated with this user', 403);
                }

                $child->delete();

                return response('Child successfully deleted.', 200);
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    /**
     * Saves the child data to the database.
     * @param Request $request The request collection.
     */
    public function save(Request $request) {
        $form_file_upload = null;

        $form_data = json_decode($request->form_data, true);

        if ($request->has('uploaded_file')) {
            $form_file_upload = $request->file('uploaded_file');
            $image_path = Storage::disk('local')->put('avatar' . time(), $request->file('uploaded_file'));
        }

        dd($form_data, $form_file_upload, $image_path);

        $birthday = Carbon::create($form_data['birthday']);

        $childData = array_merge(
            $request->all(), 
            [
                'birthday' => $birthday->toDateString($form_data['birthday']),
                'hash' => md5(implode('', $form_data) . time())
            ]
        );

        try {
            DB::beginTransaction();

            $child = Child::create($childData);

            $caretaker = Caretaker::create([
                'user_id' => Auth::id(),
                'child_id' => $child->id
            ]);

            DB::commit();

            return Child::find($child->id);
        } catch (\Exception $e) {
            DB::rollBack();

            return response($e->getMessage(), 400);
        }
        
    }
}

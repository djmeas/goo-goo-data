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

    public function view(Request $request, $hash) {
        return view('children.view', [
            'hash' => $hash
        ]);
    }

    // API Routes

    /**
     * Fetches the child data from the database.
     * @param Request $request The request collection.
     * @param String $hash The child's unique hash.
     */
    public function get(Request $request, $hash = null) {
        if ($hash) {
            $child = Child::where('hash', $hash)
                ->with(['Caretaker' => function ($q) {
                    $q->where('user_id', Auth::id());
                }])
                ->whereHas('Caretaker', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                ->join('caretakers', 'caretakers.child_id', '=', 'children.id')
                ->select('children.*', 'caretakers.is_parent', 'caretakers.full_access', 'caretakers.is_admin')
                ->where('caretakers.user_id', Auth::id())
                ->first();

            $child['caretaker_users'] = Child::getAllCaretakerUsers($child->id);

            return $child;
        }

        return Child::with(['Caretaker' => function($q) {
                $q->where('user_id', Auth::id());
            }])
            ->whereHas('Caretaker', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->join('caretakers', 'caretakers.child_id', '=', 'children.id')
            ->select('children.*', 'caretakers.is_parent', 'caretakers.full_access', 'caretakers.is_admin')
            ->where('caretakers.user_id', Auth::id())
            ->orderBy('is_parent', 'desc')
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

        $hash = md5(implode('', $form_data) . time());

        $existing_image = null;

        if ($form_data['id']) {
            $child = Child::where('id', $form_data['id'])->first();
            $hash = $child->hash;

            if ($form_data['remove_image'] === false) {
                $existing_image = $child->image_path;
            }
        }

        if ($request->has('uploaded_file') && $request->file('uploaded_file')) {
            $form_file_upload = $request->file('uploaded_file');

            if ($form_file_upload->getSize() > 1000000) {
                return response('The uploaded image is too large.', 400);
            }

            $image_path = Storage::disk('s3')
                ->putFileAs(
                    '/avatars', 
                    $request->file('uploaded_file'),
                    $hash . '.' . $form_file_upload->extension(),
                    'public'
                );
        }

        $birthday = Carbon::create($form_data['birthday']);

        $childData = array_merge(
            $form_data, 
            [
                'birthday' => $birthday->toDateString($form_data['birthday']),
                'hash' => $hash,
                'image_path' => $request->file('uploaded_file') ? $hash . '.' . $form_file_upload->extension() : $existing_image
            ]
        );

        // dd($childData);

        try {
            DB::beginTransaction();

            if ($childData['id']) {
                $child->update($childData);
            } else {
                $child = Child::create($childData);

                $caretaker = Caretaker::create([
                    'user_id' => Auth::id(),
                    'child_id' => $child->id,
                    'full_access' => 1,
                    'is_admin' => 1
                ]);
            }
            
            DB::commit();

            return Child::find($child->id);
        } catch (\Exception $e) {
            DB::rollBack();

            return response($e->getMessage(), 400);
        }
        
    }
}

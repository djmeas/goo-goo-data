<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Child;

class CaretakerController extends Controller
{
    public function get(Request $request, $hash = null) {
        try {
            if ($hash) {
                $child = Child::where('hash', $hash)
                    ->whereIn('id', Child::accessibleChildren())
                    ->first();

                if (!$child) {
                    return response('The child data does not exist.', 404);
                }
    
                return Child::getAllCaretakerUsers($child->id);
            }
        } catch (\Exception $e) {
            return response('Whoops! Could not fetch the caretaker data.', 400);
        }
        
    }

    public function get_pending_invites(Request $request, $hash) {
        try {
            if ($hash) {
                $child = Child::where('hash', $hash)
                    ->whereIn('id', Child::accessibleChildren())
                    ->first();

                if (!$child) {
                    return response('The child data does not exist.', 404);
                }
    
                return \App\CaretakerInvite::where('child_id', $child->id)->get();
            }
        } catch (\Exception $e) {
            return response('Whoops! Could not fetch the caretaker data.', 400);
        }
        
    }

    public function save_invite(Request $request) {
        try {
            // DB::beginTranscation();

            $child = Child::where('hash', $request->child_hash)
                ->whereIn('id', Child::accessibleChildren())
                ->first();

            if (!$child) {
                return response('The child data does not exist.', 404);
            }

            \App\CaretakerInvite::create([
                'child_id' => $child->id,
                'email' => $request->email,
                'role' => $request->role,
                'is_admin' => (int) $request->is_admin,
                'full_access' => (int) !$request->read_only,
            ]);

            // DB::commit();
            
        } catch (\Exception $e) {
            // DB::rollback();
            return response($e->getMessage(), 400);
        }
        
    }
}

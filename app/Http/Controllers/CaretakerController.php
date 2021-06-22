<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use App\Child;
use App\Caretaker;
use App\CaretakerInvite;

class CaretakerController extends Controller
{
    public function view_invites() {
        return view('caretaker.view_invite');
    }

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
    
                return \App\CaretakerInvite::where('child_id', $child->id)
                    ->where('has_accepted', 0)
                    ->get();
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
        
    }

    public function get_my_invites() {
        try {
            $email = \App\AppUser::where('id', \Auth::id())->first()->email;
            return \App\CaretakerInvite::where('email', $email)->get();
        } catch (\Exception $e) {
            return response('Whoops! Could not fetch the caretaker invites.', 400);
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
            return response('The invite could not be saved.', 400);
        }
        
    }

    public function delete_invite(Request $request, $invite_id) {
        try {
            DB::beginTransaction();

            $invite = CaretakerInvite::where('id', $invite_id)
                ->whereIn('child_id', Child::accessibleChildren())
                ->first();
 
            $target_user = \App\AppUser::where('email', $invite->email)->first();

            Caretaker::where('user_id', $target_user->id)
                ->where('child_id', $invite->child_id)
                ->delete();

            $invite->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response($e->getMessage(), 400);
        }
        
    }

    public function delete_caretaker(Request $request, $child_hash, $user_id) {
        try {
            // dd($child_hash, $user_id);
            $child = Child::where('hash', $child_hash)
                ->whereIn('id', Child::accessibleChildren())
                ->first();

            if (!$child) {
                return response('The child data does not exist.', 404);
            }

            return Caretaker::where('user_id', (int) $user_id)
                ->where('child_id', $child->id)
                ->delete();

        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
        
    }

    public function respond_to_invite(Request $request) {
        try {
            DB::beginTransaction();

            $invite = \App\CaretakerInvite::where('id', $request->id)->first();

            if ($request->option === 'accepted') {
                $invite->has_accepted = 1;

                \App\Caretaker::create([
                        'user_id' => Auth::id(),
                        'child_id' => $invite->child_id,
                        'role' => $invite->role,
                        'is_admin' => $invite->is_admin,
                        'full_access' => $invite->full_access
                ]);

                $invite->save();

            } else if ($request->option === 'dismissed') {
                $invite->delete();
            }

            DB::commit();

            return response('The invitation has been responded to.', 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response('Whoops! Could not respond to invitation.', 400);
        }
        
    }

    public function mark_parent_child(Request $request) {
        try {
            $child = Child::where('id', $request->child_id)
                ->whereIn('id', Child::accessibleChildren())
                ->first();

            if (!$child) {
                return response('The child data does not exist.', 404);
            }

            Caretaker::where('child_id', $request->child_id)
                ->where('user_id', $request->user_id)
                ->update(['is_parent' => $request->is_parent]);

            return response('The parent/child relationship has been saved.', 200);

        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    public function is_parent_of_child(Request $request, $child_hash, $user_id) {
        try {
            $child = Child::where('hash', $child_hash)
                ->whereIn('id', Child::accessibleChildren())
                ->first();

            if (!$child) {
                return response('The child data does not exist.', 404);
            }

            return Caretaker::where('child_id', $child->id)
                ->where('user_id', $user_id)
                ->first()->is_parent;

        } catch (\Exception $e) {
            return response('The parent/child relationship could not be saved.', 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use App\Child;
use App\Caretaker;
use App\CaretakerInvite;

/**
 * This class handles all interactions pertaining to caretakers,
 * their children, and their invitations.
 * 
 * @author  Harry Meas
 */
class CaretakerController extends Controller
{
    // Views

    /**
     * Displays the view invitations page.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view_invites() {
        return view('caretaker.view_invite');
    }

    // API

    /**
     * Fetches the caretaker data. If a child hash is pass in,
     * only return caretakers related to that child.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $hash
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Creates a new caretaker or updates an existing one.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) {
        try {
            $child = Child::where('hash', $request->child_hash)
                ->whereIn('id', Child::accessibleChildren())
                ->first();

            if (!$child) {
                return response('The child data does not exist.', 404);
            }

            if ($request->has('id') && $request->id !== null) {
                $caretaker = \App\Caretaker::where('id', $request->id)->update([
                    'is_admin' => (int) $request->is_admin,
                    'full_access' => (int) $request->read_only,
                    'role' => $request->role
                ]);

                return $caretaker;
            }

        } catch (\Exception $e) {
            return response('The invite could not be saved.', 400);
        }
        
    }

    /**
     * Fetches all the pending invites related to a particular child hash.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $hash
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Fetches the current logged in user's invitations.
     * 
     * @return \Illuminate\Http\Response
     */
    public function get_my_invites() {
        try {
            $email = \App\AppUser::where('id', \Auth::id())->first()->email;
            return \App\CaretakerInvite::where('email', $email)->get();
        } catch (\Exception $e) {
            return response('Whoops! Could not fetch the caretaker invites.', 400);
        }
        
    }

    /**
     * Creates a new invitation record in the database.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_invite(Request $request) {
        try {
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
                'full_access' => (int) $request->read_only,
            ]);
            
        } catch (\Exception $e) {
            return response('The invite could not be saved.', 400);
        }
        
    }

    /**
     * Deletes the specified invitation by its ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_invite(Request $request, $invite_id) {
        try {
            DB::beginTransaction();

            $invite = CaretakerInvite::where('id', $invite_id)
                ->whereIn('child_id', Child::accessibleChildren())
                ->first();
 
            $target_user = \App\AppUser::where('email', $invite->email)->first();

            if ($target_user) {
                Caretaker::where('user_id', $target_user->id)
                ->where('child_id', $invite->child_id)
                ->delete();
            }

            $invite->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response($e->getMessage(), 400);
        }
        
    }

    /**
     * Deletes the specified caretaker by its child hash and user ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $child_hash 
     * @param  Integer  $user_id
     * @return \Illuminate\Http\Response
     */
    public function delete_caretaker(Request $request, $child_hash, $user_id) {
        try {
            DB::beginTransaction();

            $child = Child::where('hash', $child_hash)
                ->whereIn('id', Child::accessibleChildren())
                ->first();

            if (!$child) {
                return response('The child data does not exist.', 404);
            }

            $user = \App\AppUser::where('id', (int) $user_id)->first();

            Caretaker::where('user_id', $user->id)
                ->where('child_id', $child->id)
                ->delete();

            CaretakerInvite::where('child_id', $child->id)
                ->where('email', $user->email)
                ->delete();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response($e->getMessage(), 400);
        }
        
    }

    /**
     * Responds to an invitation and creates the caretaker/child relationship.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Marks the currently logged in user as the parent of a particular child.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Checks if a caretaker is a parent of a particular child.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $child_hash
     * @param  Integer  $user_id
     * @return \Illuminate\Http\Response
     */
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

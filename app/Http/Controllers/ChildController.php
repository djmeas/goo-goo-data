<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Auth;
use App\Child;
use App\Caretaker;

class ChildController extends Controller
{
    public function index() {
        return view('children.index');
    }

    // API Routes

    public function save(Request $request) {
        $birthday = Carbon::create($request->birthday);

        $childData = array_merge(
            $request->all(), 
            [
                'birthday' => $birthday->toDateString($request->birthday),
                'hash' => md5(implode('', $request->all()) . time())
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

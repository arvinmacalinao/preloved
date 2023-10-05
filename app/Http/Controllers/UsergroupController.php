<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserGroupValidation;

class UsergroupController extends Controller
{   
    public function __construct() 
    {
		$data = [ 'page' => 'Usergroup' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {  
            if(!Auth::user()) {
                abort(404);
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();
            
            return $next($request);
        });
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');

        $rows       = UserGroup::paginate(20);
       
        return view('adminsettings.usergroups.index', compact('rows', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');

        $id      =      0;
        $ug      =      new UserGroup;
        return view('adminsettings.usergroups.form', compact('ug', 'id', 'msg'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserGroupValidation $request, $id)
    {
        $input      = $request->validated();
        if($id == 0) {
            $request->request->add(['created_at' => Carbon::now()]);
            $ug   = UserGroup::create($request->all());
        } else {
            $ug   = UserGroup::where('ug_id', $id)->first();
            if(!$ug) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('usergroups.list'));
            } else {
                $request->request->add(['updated_at' => Carbon::now()]);
                
                $checkboxFields = ['ug_is_admin'];

                foreach ($checkboxFields as $field) {
                    $value = $request->has($field) ? 1 : 0;
                    $ug->$field = $value;
                }
       
                $ug->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record updated.');
        return redirect(route('usergroups.list'));
    }

    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        
        $ug       = UserGroup::where('ug_id', $id)->first();
        if(!$ug) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('usergroups.list'));
        }
        return view('adminsettings.usergroups.form', compact('msg', 'id', 'ug'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $ug = UserGroup::where('ug_id', $id)->first();
        if(!$ug) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('usergroups.list'));
        } else {
            $ug->delete();
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('usergroups.list'));
        } 
    }
}

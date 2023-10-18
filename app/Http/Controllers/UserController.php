<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserValidation;

class UserController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Users' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {  
            if(!Auth::user()) {
                abort(404);
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();
            
            return $next($request);
        });
	}
    
    public function index(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');

        $rows       = User::paginate(20);
       
        return view('adminsettings.users.index', compact('rows', 'msg'));
    }

    public function create(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');

        $ugroups    = UserGroup::orderBy('ug_name', 'asc')->get();

        $id      =      0;
        $user    =      new user;
        return view('adminsettings.users.form', compact('id', 'user', 'msg', 'ugroups'));
    }

    public function store(UserValidation $request, $id)
    {
        $input      = $request->validated();
        if($id == 0) {
            
            $request->request->add(['created_at' => Carbon::now()]);
            $user   = User::create($request->all());

        } else {
            $user   = User::where('id', $id)->first();
            if(!$user) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('user.lists'));
            } else {
                $request->request->add(['updated_at' => Carbon::now()]);
                
                if ($request->filled('password')) {
                    $user->password = $request->input('password');
                }
                
                $checkboxFields = ['u_enabled', 'u_is_superadmin', 'u_is_admin', 'u_is_cashier'];

                foreach ($checkboxFields as $field) {
                    $value = $request->has($field) ? 1 : 0;
                    $user->$field = $value;
                }

                $request->request->remove('password');                
                $user->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record updated.');
        return redirect(route('user.lists'));
    }

    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $ugroups    = UserGroup::orderBy('ug_name', 'asc')->get();
        
        $user       = User::where('id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        }
        return view('adminsettings.users.form', compact('msg', 'id', 'user', 'ugroups',));
    }

    public function delete(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        } else {
            $user->delete();
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('user.lists'));
        }        
    }

    public function disable(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        } else {
            $user->update(['u_enabled' => '0']);
            $request->session()->put('session_msg', 'Account Disabled!');
            return redirect(route('user.lists'));
        }      
    }

    public function enable(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        } else {
            $user->update(['u_enabled' => '1']);
            $request->session()->put('session_msg', 'Account Enabled!');
            return redirect(route('user.lists'));
        }      
    }
}

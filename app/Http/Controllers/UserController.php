<?php

namespace App\Http\Controllers;

use App\Models\User;
use View;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

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
    
    public function index()
    {
        $rows = User::paginate(20);

        return view('adminsettings.users.index', compact('rows'));
    }

    public function create(Request $request)
    {
        // $ugroups    = UserGroup::get();

        $id         = 0;
        $user       = new User;

        return view('adminsettings.users.form', compact('user'));
    }

    
}

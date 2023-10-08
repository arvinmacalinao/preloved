<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Sales' ];
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
        $msg        =   $request->session()->pull('session_msg', '');
        $search     =   $request->get('search') == NULL ? '' : $request->get('search');

        // Get the logged-in user's ID
        $user_id = Auth::id();

        // Check if the logged-in user is an owner
        $user = User::where('id', $user_id)->where('u_is_owner', 1)->first();

        if ($user) {
            // If the user is an owner, retrieve OrderDetail records where the product belongs to them
            $rows = OrderDetail::whereHas('product', function ($query) use ($user_id) {
                $query->whereHas('owner', function ($innerQuery) use ($user_id) {
                    $innerQuery->where('u_id', $user_id);
                });
            })->search($search)->paginate(20);
        } else {
            $rows       =   OrderDetail::search($search)->paginate(20);
        }
       
        return view('sales.index', compact('rows', 'search', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

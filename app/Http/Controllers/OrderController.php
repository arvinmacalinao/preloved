<?php

namespace App\Http\Controllers;

use View;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Orders' ];
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
        $search     = $request->get('search') == NULL ? '' : $request->get('search');

        $products       = Product::search($search)->get();
        $owners         = ProductOwner::search($search)->get();
        $rows           = Order::all();
       
        return view('orders.index', compact('rows', 'search', 'msg', 'products', 'owners'));
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
        $o       =      new Order;

        $product   =     ProductType::all();

        return view('orders.form', compact('o', 'id', 'msg', 'product'));
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

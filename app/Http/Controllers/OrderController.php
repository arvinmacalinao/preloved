<?php

namespace App\Http\Controllers;

use View;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
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

        $id = 0;

        $products       = Product::search($search)->get();
        $owners         = ProductOwner::search($search)->get();
        $rows           = Order::all();
       
        return view('orders.index', compact('rows', 'search', 'msg', 'products', 'owners', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // return $request->all();


        DB::transaction(function () use ($request){

            //Order Modal
            $orders = new Order;
            $orders->order_customer_name = $request->order_customer_name;
            $orders->order_customer_phone = $request->order_customer_phone;
            $orders->save();

            //get order id
            $order_id = $orders->order_id;

            // 'order_id', 'prod_id', 'price', 'order_quantity', 'order_amount_total', 'order_discount'
            //Order Details Modal
            $totalAmount = 0;

            foreach ($request->prod_id as $i => $prodId) {
                $order_detail = new OrderDetail;
                $order_detail->order_id = $order_id;
                $order_detail->prod_id = $prodId;
                $order_detail->price = $request->price[$i];
                $order_detail->order_quantity = $request->order_quantity[$i];
                $order_detail->order_amount_total = $request->order_amount_total[$i];
                $order_detail->order_discount = $request->order_discount[$i];
                $order_detail->save(); // Save each order detail
    
                // Calculate total amount for this order detail
                $totalAmount += $order_detail->order_amount_total;
    
                // Update product quantity
                $product = Product::find($prodId);
                $newQuantity = $product->prod_quantity - $request->order_quantity[$i];
    
                // Check if the new quantity is valid
                if ($newQuantity < 0) {
                    // Handle the error, maybe by rolling back the transaction
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Insufficient stock for product ' . $product->prod_description);
                }
    
                $product->prod_quantity = $newQuantity;
                $product->save();
            }
            // 'order_id', 'ot_payment', 'ot_change', 'ot_total_amount', 'payment_mode_id', 'ot_transace_date', 'created_by'
            //Transaction Modal
            $order_transaction                     = new OrderTransaction;
            $order_transaction->order_id           = $order_id;
            $order_transaction->created_by         = Auth::id();
            $order_transaction->ot_payment         = $request->ot_payment;
            $order_transaction->ot_change          = $request->ot_change;
            $order_transaction->ot_total_amount    = $totalAmount;
            $order_transaction->ot_transact_date   = date('Y-m-d');
            $order_transaction->payment_mode_id    = $request->payment_mode_id;
            $order_transaction->save(); // Save each order detail

             // Last Order History
            $products = Product::all();
            $order_details = OrderDetail::where('order_id', $order_id)->get();
            $orderedby     = Order::where('order_id', $order_id)->get();

            $request->session()->put('session_msg', 'Order successfuly saved.');
        });
       
        return redirect(route('order.lists'));
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
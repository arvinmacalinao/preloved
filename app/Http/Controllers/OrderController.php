<?php

namespace App\Http\Controllers;

use View;
use Exception;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\PaymentMode;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $payment_modes   = PaymentMode::get();
        $rows           = Order::all();
       
        return view('orders.index', compact('rows', 'search', 'msg', 'products', 'owners', 'id', 'payment_modes'));
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
        //  return $request->all();
            
            DB::transaction(function () use ($request){
    
            // Order Modal
            $orders = new Order;
            $orders->order_customer_name = $request->order_customer_name;
            $orders->order_customer_phone = $request->order_customer_phone;
            $orders->save();
    
            // Get order id
            $order_id = $orders->order_id;
    
            // Order Details Modal
            $totalAmount = 0;
            
            if ($request->has('prod_id') && is_array($request->input('prod_id'))) {
                foreach ($request->input('prod_id') as $i => $prodId) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order_id;
                    $orderDetail->prod_id = $prodId;
                    $orderDetail->price = $request->input('prod_price')[$i];
                    $orderDetail->order_quantity = $request->input('order_quantity')[$i];
                    $orderDetail->order_amount_total = $request->input('order_amount_total')[$i];
                    $orderDetail->order_discount = $request->input('order_discount')[$i];
                    $orderDetail->save();
            
                    // Update product quantity
                    $product = Product::find($prodId);
                    $newQuantity = $product->prod_quantity - $orderDetail->order_quantity;
                    $prod_id = $product->prod_id;
            
                    // Calculate total amount for this order detail
                    $totalAmount += $orderDetail->order_amount_total;
            
                    if ($newQuantity < 0) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Insufficient stock for product ' . $product->prod_description);
                    }
            
                    $product->prod_quantity = $newQuantity;
                    $product->save();
                }
            } else {
                // Handle the case where the input data is missing or not an array.
                // You can log an error, return an error response, or handle it as needed.
            }
            
            

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

    // public function store(Request $request, $id)
    // {
    //     return $request->all();


    //     DB::transaction(function () use ($request){

    //         //Order Modal
    //         $orders = new Order;
    //         $orders->order_customer_name = $request->order_customer_name;
    //         $orders->order_customer_phone = $request->order_customer_phone;
    //         $orders->save();

    //         //get order id
    //         $order_id = $orders->order_id;

    //         // 'order_id', 'prod_id', 'price', 'order_quantity', 'order_amount_total', 'order_discount'
    //         //Order Details Modal
    //         $totalAmount = 0;

    //         foreach ($request->prod_id as $i => $prodId) {
    //             $order_detail = new OrderDetail;
    //             $order_detail->order_id = $order_id;
    //             $order_detail->prod_id = $prodId;
    //             $order_detail->price = $request->price[$i];
    //             $order_detail->order_quantity = $request->order_quantity[$i];
    //             $order_detail->order_amount_total = $request->order_amount_total[$i];
    //             $order_detail->order_discount = $request->order_discount[$i];
    //             $order_detail->save(); // Save each order detail
    
    //             // Calculate total amount for this order detail
    //             $totalAmount += $order_detail->order_amount_total;
    
    //             // Update product quantity
    //             $product = Product::find($prodId);
    //             $newQuantity = $product->prod_quantity - $request->order_quantity[$i];
    
    //             // Check if the new quantity is valid
    //             if ($newQuantity < 0) {
    //                 // Handle the error, maybe by rolling back the transaction
    //                 DB::rollBack();
    //                 return redirect()->back()->with('error', 'Insufficient stock for product ' . $product->prod_description);
    //             }
    
    //             $product->prod_quantity = $newQuantity;
    //             $product->save();
    //         }
    //         // 'order_id', 'ot_payment', 'ot_change', 'ot_total_amount', 'payment_mode_id', 'ot_transace_date', 'created_by'
    //         //Transaction Modal
    //         $order_transaction                     = new OrderTransaction;
    //         $order_transaction->order_id           = $order_id;
    //         $order_transaction->created_by         = Auth::id();
    //         $order_transaction->ot_payment         = $request->ot_payment;
    //         $order_transaction->ot_change          = $request->ot_change;
    //         $order_transaction->ot_total_amount    = $totalAmount;
    //         $order_transaction->ot_transact_date   = date('Y-m-d');
    //         $order_transaction->payment_mode_id    = $request->payment_mode_id;
    //         $order_transaction->save(); // Save each order detail

    //          // Last Order History
    //         $products = Product::all();
    //         $order_details = OrderDetail::where('order_id', $order_id)->get();
    //         $orderedby     = Order::where('order_id', $order_id)->get();

    //         $request->session()->put('session_msg', 'Order successfuly saved.');
    //     });
       
    //     return redirect(route('order.lists'));
    // }

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

    public function getProductDetailsByBarcode(Request $request) {
        try {
            $barcode = $request->input('barcode');
            
            // Query the Product model to retrieve product details by barcode
            $product = Product::where('prod_barcode', $barcode)->first();
            
            if ($product && $product->prod_quantity > 0) {
                return response()->json(['success' => true, 'product' => $product]);
            } else {
                return response()->json(['success' => false, 'error' => 'Product not found or out of stock']);
            }
        
        } catch (Exception $e) {
            Log::error('Error in getProductDetailsByBarcode: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'An error occurred.']);
        }
    }

    public function getProductSuggestions(Request $request)
    {
        $query = $request->input('barcode'); // Get the user's input query
    
        // Use the query to fetch product suggestions (e.g., from your database)
        $suggestions = Product::where('prod_barcode', 'like', $query . '%')
            ->orWhere('prod_description', 'like', '%' . $query . '%')
            ->limit(10) // Limit the number of suggestions
            ->get();
        
        if ($suggestions) {
            return response()->json(['success' => true, 'suggestions' => $suggestions]);
        } else {
            return response()->json(['success' => false, 'error' => 'Product not found or out of stock']);
        } 
    }

    public function autocomplete(Request $request)
    {
        try {
            $query = $request->input('prodBarcode');
    
            $datas = Product::select('prod_barcode', 'prod_description')
                ->where('prod_barcode', 'like', $query . '%')
                ->orWhere('prod_description', 'like', '%' . $query . '%')
                ->limit(10)
                ->get();
    
            return response()->json($datas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}

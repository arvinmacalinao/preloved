<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all(); // Fetch your products data (adjust the query as needed)
        $sales    = OrderDetail::all();

        return view('pages.dashboard', [ 'products' => $products, 'sales' => $sales ]);
    }
}

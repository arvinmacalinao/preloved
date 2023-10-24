<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnsoldProductReportController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Unsold Products Report' ];
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
        $msg            = $request->session()->pull('session_msg', '');
        $search         = $request->get('search') == NULL ? '' : $request->get('search');
        $startDate      = $request->get('date_start') == NULL ? '' : $request->get('date_start');
        $endDate        = $request->get('date_end') == NULL ? '' : $request->get('date_end');
        $qtype          = $request->get('prod_type_id') == NULL ? '' : $request->get('prod_type_id');
        $qowner          = $request->get('prod_owner_id') == NULL ? '' : $request->get('prod_owner_id');
        
        
        // ProductType
        $types          =   ProductType::get();
        $owners         =   ProductOwner::get();

        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // $extract = Product::whereDoesntHave('orderdetails')->search($search)->ProdType($qtype)->ProdOwner($qowner)->dateRange($startDate, $endDate)->get();
        
        // $rows = Product::whereDoesntHave('orderdetails')->search($search)->ProdType($qtype)->ProdOwner($qowner)->dateRange($startDate, $endDate)->get();
        $extract = Product::whereHas('orderdetails', function ($query) use ($thirtyDaysAgo) {
            $query->where('created_at', '<', $thirtyDaysAgo);
        })->orWhereDoesntHave('orderdetails')->get();

        $rows = Product::whereHas('orderdetails', function ($query) use ($thirtyDaysAgo) {
            $query->where('created_at', '<', $thirtyDaysAgo);
        })->orWhereDoesntHave('orderdetails')->get();

        session(['pdf_data' => compact('extract', 'rows')]);
       
        return view('reports.unsoldproducts_report.index', compact('rows', 'search', 'msg', 'extract', 'startDate', 'endDate', 'types', 'qtype', 'owners', 'qowner'));
    }
}

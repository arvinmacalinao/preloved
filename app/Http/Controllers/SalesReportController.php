<?php

namespace App\Http\Controllers;

use View;
use App\Models\OrderDetail;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Sales Report' ];
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

        $types          =   ProductType::get();
   
        $extract = OrderDetail::search($search)->prodType($qtype)->dateRange($startDate, $endDate)->get();
        $rows    = OrderDetail::search($search)->prodType($qtype)->dateRange($startDate, $endDate)->orderBy('created_at', 'asc')->get();

        return view('reports.sale_report.index', compact('msg', 'rows', 'extract', 'qtype', 'types', 'startDate', 'endDate', 'search'));
    }
}

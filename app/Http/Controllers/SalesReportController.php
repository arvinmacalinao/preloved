<?php

namespace App\Http\Controllers;

use View;
use Barryvdh\DomPDF\PDF;
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

        session(['pdf_data' => compact('extract', 'rows')]);

        return view('reports.sale_report.index', compact('msg', 'rows', 'extract', 'qtype', 'types', 'startDate', 'endDate', 'search'));
    }

    public function generatePDF()
    {   
        $date = now();
        // Retrieve data from the session
        $pdfData = session('pdf_data');
        
        $pdf = app()->make('dompdf.wrapper');

        if (!$pdfData) {
            // Handle the case where data is not found in the session
            abort(404);
        }
    
        $extract = $pdfData['extract'];
        $rows = $pdfData['rows'];
    
        // Generate the PDF
        $pdf->loadView('pdf.sales_report', ['extract' => $extract, 'rows' => $rows]);
    
        return $pdf->stream();
    }
}

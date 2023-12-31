<?php

namespace App\Http\Controllers;

use View;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsReportController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Products Report' ];
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

        $extract        = Product::search($search)->ProdType($qtype)->ProdOwner($qowner)->dateRange($startDate, $endDate)->get();
        $rows           = Product::search($search)->ProdType($qtype)->ProdOwner($qowner)->dateRange($startDate, $endDate)->get();

        session(['pdf_data' => compact('extract', 'rows')]);
       
        return view('reports.products_report.index', compact('rows', 'search', 'msg', 'extract', 'startDate', 'endDate', 'types', 'qtype', 'owners', 'qowner'));
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
        $pdf->loadView('pdf.products_report', ['extract' => $extract, 'rows' => $rows]);
    
        return $pdf->stream();
    }
}

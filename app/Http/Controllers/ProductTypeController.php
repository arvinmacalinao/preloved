<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductTypeValidation;

class ProductTypeController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Product Type' ];
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
        $msg        = $request->session()->pull('session_msg', '');
        $search = $request->get('search') == NULL ? '' : $request->get('search');

        $rows = ProductType::search($search)->paginate(20);
       
        return view('adminsettings.product_type.index', compact('rows', 'search', 'msg'));
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
        $pt      =      new ProductType;
        return view('adminsettings.product_type.form', compact('pt', 'id', 'msg'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductTypeValidation $request, $id)
    {
        $input      = $request->validated();

        if($id == 0) {
            $request->request->add(['created_by' => Auth::id()]);
            $pt     = ProductType::create($request->all());

            $request->session()->put('session_msg', 'Record successfully added.');
        } else {
            $pt     = ProductType::where('prod_type_id', $id)->first();
            if(!$pt ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('product.type.lists'));
            }
            
            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);
            $pt->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('product.type.lists'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        $msg            = $request->session()->pull('session_msg', '');
        $pt             = ProductType::where('prod_type_id', $id)->first();
        if(!$pt) {
            $request->session()->put('session_msg', 'Record not found.');
            return redirect(route('product.type.lists'));
        }
        
        return view('adminsettings.product_type.view', compact('id', 'msg', 'pt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $pt         = ProductType::where('prod_type_id', $id)->first();
        if(!$pt) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('product.type.lists'));
        }
        return view('adminsettings.product_type.form', compact('pt', 'id', 'msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pt = ProductType::where('prod_type_id', $id)->first();
        if(!$pt) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('product.type.lists'));
        } else {
            $pt->deleted_by = Auth::id();
            $pt->deleted_at = Carbon::now();
            $pt->update();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('product.type.lists'));
        }        
    }
}

<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductOwnerValidation;

class ProductOwnerController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Product Owner' ];
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
        $search     = $request->get('search') == NULL ? '' : $request->get('search');

        $rows       = ProductOwner::search($search)->paginate(20);
       
        return view('adminsettings.product_owner.index', compact('rows', 'search', 'msg'));
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
        $po      =      new ProductOwner;
        return view('adminsettings.product_owner.form', compact('po', 'id', 'msg'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductOwnerValidation $request, $id)
    {
        $input      = $request->validated();

        if($id == 0) {
            $request->request->add(['created_by' => Auth::id()]);
            $po     = ProductOwner::create($request->all());

            $lastid = $po->id;

            $emailToCheck = $request->request->get('prod_owner_email');
            $existingProductOwner = User::where('prod_owner_email', $emailToCheck)->first();

            if (!$existingProductOwner) {
                // The email doesn't exist, so you can proceed to create a new user
            }

            $request->session()->put('session_msg', 'Record successfully added.');
        } else {
            $po     = ProductOwner::where('prod_owner_id', $id)->first();
            if(!$po ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('product.owner.lists'));
            }
            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);
            $po->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('product.owner.lists'));
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
        $po             = ProductOwner::where('prod_owner_id', $id)->first();
        if(!$po) {
            $request->session()->put('session_msg', 'Record not found.');
            return redirect(route('product.owner.lists'));
        }

        $rows           = Product::where('prod_owner_id', $id)->paginate(20);
        
        return view('adminsettings.product_owner.view', compact('id', 'msg', 'po', 'rows'));
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
        $po         = ProductOwner::where('prod_owner_id', $id)->first();
        if(!$po) {
            $request->session()->put('session_msg', 'Record not found!
            ');
            return redirect(route('product.owner.lists'));
        }
        return view('adminsettings.product_owner.form', compact('po', 'id', 'msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $po = ProductOwner::where('prod_owner_id', $id)->first();
        if(!$po) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('product.owner.lists'));
        } else {
            $po->deleted_by = Auth::id();
            $po->deleted_at = Carbon::now();
            $po->update();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('product.owner.lists'));
        }        
    }
}

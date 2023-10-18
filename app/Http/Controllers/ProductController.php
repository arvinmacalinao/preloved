<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Milon\Barcode\DNS1D;
use App\Models\ProductType;
use Illuminate\Support\Str;
use App\Models\ProductOwner;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductValidation;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Products' ];
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
        $msg            = $request->session()->pull('session_msg', '');
        $search         = $request->get('search') == NULL ? '' : $request->get('search');
        $startDate      = $request->get('date_start') == NULL ? '' : $request->get('date_start');
        $endDate        = $request->get('date_end') == NULL ? '' : $request->get('date_end');
        $qtype          = $request->get('prod_type_id') == NULL ? '' : $request->get('prod_type_id');
        
        
        // ProductType
        $types          =   ProductType::get();

        $extract        = Product::search($search)->ProdType($qtype)->dateRange($startDate, $endDate)->get();
        $rows           = Product::search($search)->ProdType($qtype)->dateRange($startDate, $endDate)->paginate(20);
       
        return view('products.index', compact('rows', 'search', 'msg', 'extract', 'startDate', 'endDate', 'types', 'qtype'));
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
        $p       =      new Product;
        $types   =     ProductType::orderBy('prod_type_id', 'asc')->get();
        $owners   =     ProductOwner::orderBy('prod_owner_id', 'asc')->get();

        return view('products.form', compact('p', 'id', 'msg', 'types', 'owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // ProductValidation
        // $input      = $request->validated();

        if($id == 0) {
            $min = 1000000000;
            $max = 9999999999; // Adjust the maximum value as needed
                              
            // Generate a random number within the specified range
            $barcode = mt_rand($min, $max);
            
            $price = $request->input('prod_price');
            $description = $request->input('prod_description');

            // Generate the barcode image using milon/barcode
            $barcodeGenerator = new DNS1D();
            $barcodeGenerator->setStorPath(public_path('storage/generate/images')); // Set the storage path
        
            // Generate the barcode image
            $barcodeImage = $barcodeGenerator->getBarcodePNGPath($barcode, 'C128',2,60, array(0,0,0), true);
            
            $imagePath = public_path('storage/generate/images/' . $barcode . "c128.png");

            // Load the generated barcode image using Intervention Image
            $barcodeImage = Image::make($imagePath);
                
            // Get the dimensions of the barcode image
            $barcodeWidth = 280;
            $barcodeHeight = 100;
                
            // Create a new canvas with a white background
            $image = Image::canvas($barcodeWidth, $barcodeHeight, '#FFFFFF');
                    
            // Insert the barcode image at the custom position (bottom with margin)
            $image->insert($barcodeImage, 'bottom', 0, 5);
            
            // Sample custom text lines
            $line2 = 'Price: Php' . number_format($price, 2);
            $line1 = 'Product: ' . $description;

            // Define custom text settings
            $customText = $line1 . "\n" . $line2; // Format the price with 2 decimal places
            $fontPath = public_path('generate/font/ProximaNovaA-Thin.ttf');
            $fontSize = 5;
            $fontColor = '#000000'; // Black color

            // Define the position to place the custom text
            $xPosition = 10; // Adjust as needed
            $yPosition = 15; // Adjust as needed
            $yPosition2 = 25; // Adjust as needed

            // Add custom text to the image with explicit line breaks
            $image->text($line1, $xPosition, $yPosition, function($font) use ( $fontSize, $fontColor) {
       
                $font->size($fontSize);
                $font->color($fontColor);
            });

            // Adjust the Y-coordinate for the second line
            // Add some vertical spacing between lines (adjust as needed)

            $image->text($line2, $xPosition, $yPosition2, function($font) use ( $fontSize, $fontColor) {
          
                $font->size($fontSize);
                $font->color($fontColor);
            });
        
            // Save the modified image
            $generatedFilename = $barcode . '.png'; // Use the barcode value as the filename
            $image->save(public_path('storage/generate/barcode/' . $generatedFilename));
        
            // Store the barcode value and filename in your database
            $request['barcode_image'] = $generatedFilename;
            $request['prod_barcode'] = $barcode;

            $request->request->add(['created_by' => Auth::id()]);
            
            $get_prod_owner_name = $request->get('prod_owner_name');
            
            $productOwner = ProductOwner::where('prod_owner_name', $get_prod_owner_name)->first();

            if(!$productOwner){
                $newProductOwner = ProductOwner::create([
                    'prod_owner_name' => $request->request->get('prod_owner_name'),
                    'created_by' => Auth::id(),
                ]);
                $request->merge(['prod_owner_id' => $newProductOwner->prod_owner_id]);
            }else{
                $request->merge(['prod_owner_id' => $productOwner->prod_owner_id]);
            }
            $p = Product::create($request->all());
            
        } else {
            $p          = Product::where('prod_id', $id)->first();
            $barcode    = $p->prod_barcode;

            $price = $request->input('prod_price');
            $description = $request->input('prod_description');
             
            if(!$p ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('product.lists'));
            }

            $previousImagePath = public_path('storage/generate/images/' . $barcode . "c128.png");

            $oldImageFilename = $p->barcode_image;

            // Rename the existing image file by appending a timestamp (or some unique identifier)
            $timestamp = now()->timestamp;
            $renamedImageFilename = $timestamp . '_' . $oldImageFilename;
            
            // Get the path to the previous image
            $previousBarcodePath = public_path('storage/generate/barcode/' . $oldImageFilename);
            
            // Rename the existing image file
            if (file_exists($previousBarcodePath)) {
                rename($previousBarcodePath, public_path('storage/generate/barcode/' . $renamedImageFilename));
            }
        
            // ... (Your code for generating and saving the new image)
            // Load the generated barcode image using Intervention Image
            $barcodeImage = Image::make($previousImagePath);
                
            // Get the dimensions of the barcode image
            $barcodeWidth = 280;
            $barcodeHeight = 100;
                
            // Create a new canvas with a white background
            $image = Image::canvas($barcodeWidth, $barcodeHeight, '#FFFFFF');
                    
            // Insert the barcode image at the custom position (bottom with margin)
            $image->insert($barcodeImage, 'bottom', 0, 5);
            
            // Sample custom text lines
            $line2 = 'Price: Php' . number_format($price, 2);
            $line1 = 'Product: ' . $description;

            // Define custom text settings
            $customText = $line1 . "\n" . $line2; // Format the price with 2 decimal places
            $fontPath = public_path('generate/font/ProximaNovaA-Thin.ttf');
            $fontSize = 5;
            $fontColor = '#000000'; // Black color

            // Define the position to place the custom text
            $xPosition = 10; // Adjust as needed
            $yPosition = 15; // Adjust as needed
            $yPosition2 = 25; // Adjust as needed

            // Add custom text to the image with explicit line breaks
            $image->text($line1, $xPosition, $yPosition, function($font) use ( $fontSize, $fontColor) {
       
                $font->size($fontSize);
                $font->color($fontColor);
            });

            // Adjust the Y-coordinate for the second line
            // Add some vertical spacing between lines (adjust as needed)

            $image->text($line2, $xPosition, $yPosition2, function($font) use ( $fontSize, $fontColor) {
          
                $font->size($fontSize);
                $font->color($fontColor);
            });
        
            // Save the modified image
            $generatedFilename = $barcode . '.png'; // Use the barcode value as the filename
            $image->save(public_path('storage/generate/barcode/' . $generatedFilename));
        
            // Store the barcode value and filename in your database
            $request['barcode_image'] = $generatedFilename;
            $request['prod_barcode'] = $barcode;

            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);

            $get_prod_owner_name = $request->get('prod_owner_name');
            
            $productOwner = ProductOwner::where('prod_owner_name', $get_prod_owner_name)->first();

            if(!$productOwner){
                $newProductOwner = ProductOwner::create([
                    'prod_owner_name' => $request->request->get('prod_owner_name'),
                    'created_by' => Auth::id(),
                ]);
                $request->merge(['prod_owner_id' => $newProductOwner->prod_owner_id]);
            }else{
                $request->merge(['prod_owner_id' => $productOwner->prod_owner_id]);
            }
            
            $p->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('product.lists'));
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
        $p              = Product::where('prod_id', $id)->first();
        if(!$p) {
            $request->session()->put('session_msg', 'Record not found.');
            return redirect(route('product.lists'));
        }

        $rows           = Product::where('prod_id', $id)->paginate(20);
        
        return view('products.view', compact('id', 'msg', 'p', 'rows'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $types      =     ProductType::orderBy('prod_type_id', 'asc')->get();
        $owners     =     ProductOwner::orderBy('prod_owner_id', 'asc')->get();

        $msg        = $request->session()->pull('session_msg', '');
        
        $p          = Product::where('prod_id', $id)->first();
        if(!$p) {
            $request->session()->put('session_msg', 'Record not found!
            ');
            return redirect(route('product.lists'));
        }
        return view('products.form', compact('p', 'id', 'msg', 'owners', 'types'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $p   = Product::where('prod_id', $id)->first();
        if(!$p) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('product.lists'));
        } else {
            $p->deleted_by = Auth::id();
            $p->deleted_at = Carbon::now();
            $p->update();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('product.lists'));
        }        
    }

    public function download($filename)
    {
        $filePath = 'generate/barcode/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(storage_path('app/public/' . $filePath));
        }
    }

    public function export(Excel $excel, Request $request)
    {
        $now      = Carbon::now()->format('m-d-y');
        $filename = "products-".$now.".xlsx";

        $extract = $request->session()->get('extract');
        
        return $excel->download(new ProductsExport($extract), $filename);
    }

    public function autocompleteOwner(Request $request)
    {
        try {
            $query = $request->input('prod_owner_id');
        
            $owners = ProductOwner::select('prod_owner_id', 'prod_owner_name')
                ->where('prod_owner_name', 'like', $query . '%')
                ->limit(10)
                ->get();
        
            return response()->json($owners);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}

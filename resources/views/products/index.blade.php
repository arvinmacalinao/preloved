@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'product'
])
@section('content')
<div class="content">
    <!-- This will display any message upon submission. -->
		@if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ $msg }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- End -->
    <div style="" class="row">
        <div class="col-md-2 mr-5">
            <div class="card bg-light mb-3" style="width: 18rem;">
                <div class="card-header bg-info text-light text-center">
                    <h4>Total Products</h4>
                </div>
                <div class="card-body">
                    @php
                    $SoldQuantity = 0; // Initialize the total quantity to 0
                    $TotalQuantity = 0;
                    $UnsoldQuantity = $extract->sum('prod_quantity');
                    foreach ($rows as $row) {
                        $SoldQuantity += $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity');
                    }
                    $TotalQuantity = $SoldQuantity + $UnsoldQuantity;
                    @endphp
                  <h4 class="card-title text-left">{{ $TotalQuantity ?? 0 }}</h4>
                  <i class="fa fa-shopping-bag fa-4x text-gray pull-right"></i>
                  <p>&nbsp;</p>
                </div>
                <div class="card-footer bg-info text-light text-center">
                    <a href="{{ route('products.report') }}" class="text-light">View <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mr-5">
            <div class="card bg-light mb-3" style="width: 18rem;">
                <div class="card-header bg-success text-light text-center">
                    <h4>Total Sold Product</h4>
                </div>
                <div class="card-body">
                  <h4 class="card-title text-left" style="overflow: visible">{{ $SoldQuantity ?? 0 }}</h4><i class="fa fa-shopping-cart fa-4x text-gray pull-right" ></i>
                  <p>&nbsp;</p>
                </div>
                <div class="card-footer bg-success text-light text-center">
                    <a href="{{ route('products.report') }}" class="text-light">View <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mr-5">
            <div class="card bg-light mb-3" style="width: 18rem;">
                <div class="card-header bg-warning text-light text-center">
                    <h4>Total Unsold Product</h4>
                </div>
                <div class="card-body">
                  <h4 class="card-title text-left" style="overflow: visible">{{ $UnsoldQuantity ?? 0 }}</h4><i class="fa fa-gift fa-4x text-gray pull-right" ></i>
                  <p>&nbsp;</p>
                </div>
                <div class="card-footer bg-warning text-light text-center">
                    <a href="{{ route('products.report') }}" class="text-light">View <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-2 mr-5">
            <div class="card bg-light mb-3" style="width: 18rem;">
                <div class="card-header bg-primary text-light text-center">
                    <h4>Total Amount</h4>
                </div>
                <div class="card-body">
                    @php
                    $totalPrice = 0; // Initialize the total price to 0
                        foreach ($extract as $extracts) {
                            $quantity = $extracts->prod_quantity;
                            $price = $extracts->prod_price;
                            $totalPrice += $quantity * $price; // Calculate and accumulate the total price
                        }
                    @endphp
                  <h4 class="card-title text-left" style="overflow: visible">&#8369;{{ number_format($totalPrice, 2) }}</h4><i class="fa fa-money fa-4x text-gray pull-right" ></i>
                  <p>&nbsp;</p>
                </div>
                <div class="card-footer bg-primary text-light text-center">
                    <a href="{{ route('sales.report') }}" class="text-light">View <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>  
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header border-0 text-light" style="background-color:rgb(124, 124, 124);">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $data['page'] }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            {{-- <a class="btn btn-success btn-sm" id="" href="{{ route('download.product.template') }}" name="download-list-btn" class="print-download-btn pr" title="Download Template"><span class="fa fa-floppy-o"></span> Download Template</a> --}}
                            <a class="btn btn-success btn-sm" id="" href="{{ route('products.download.excel') }}" name="download-list-btn" class="print-download-btn pr" title="Download List"><span class="fa fa-floppy-o"></span> Download</a>
                            <a href="{{ route('product.create') }}" title="Add {{ $data['page'] }}" class="btn btn-sm btn-primary">Add {{ $data['page'] }}</a>
                        </div>
                    </div>
                    
                    <!-- Search engine section -->
                    <div class="mb-1 position-relative">
                        <form class="row row-cols-lg-auto g-2 align-items-center" method="POST" action="{{ url()->current() }}">
                        @csrf
                            <div class="col-md-2">
                                <label class="text-light mr-2" for="date_start">Start Date:</label>
                                <div class="input-group">
                                    <input class="form-control date_start" placeholder="(from)" autocomplete="off" name="date_start" id="date_start" maxlength=""  type="text" value="{{ old('date_start', $startDate) }}">
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-white">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="text-light mr-2" for="date_end">End Date:</label>
                                <div class="input-group">
                                    <input class="form-control date_end" placeholder="(To)" autocomplete="off" name="date_end" id="date_end" maxlength=""  type="text" value="{{ old('date_end', $endDate) }}">
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-white">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2 dd">
                                    <label class="form-label fw-bold text-light" for="prod_type_id">Product Type</label>
                                    <select class="form-control @error('prod_type_id') is-invalid @enderror" name="prod_type_id" id="prod_type_id">
                                        <option value="">All</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->prod_type_id }}" {{ old('prod_type_id') == $type->prod_type_id ? 'selected' : '' }}>{{ $type->prod_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">@error('prod_type_id') {{ $errors->first('prod_type_id') }} @enderror</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2 dd">
                                    <label class="form-label fw-bold text-light" for="prod_owner_id">Product Owner</label>
                                    <select class="form-control @error('prod_owner_id') is-invalid @enderror" name="prod_owner_id" id="prod_owner_id">
                                        <option value="">All</option>
                                        @foreach($owners as $owner)
                                            <option value="{{ $owner->prod_owner_id }}" {{ old('prod_owner_id') == $owner->prod_owner_id ? 'selected' : '' }}>{{ $owner->prod_owner_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">@error('prod_owner_id') {{ $errors->first('prod_owner_id') }} @enderror</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <label class="text-light mr-2" for="date_end">Search</label>
                                <div class="input-group">
                                <input class="form-control" type="text" placeholder="Search" name="search" id="search" maxlength="255" value="{{ old('search', $search) }}">
                                </div>
                            </div>
                            <div class="col-auto">
                                <label class="text-light mr-2" for="date_end"></label>
                                <div class="input-group">
                                    <input class="btn btn-primary btn-sm" type="submit" name="search-btn" id="search-btn" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End of search engine section -->
                </div>
                <div class="card-body ">
                    
                    <!-- Pagination section -->
                        <div class="text-end">
                            @include('subviews.pagination', ['rows' => $rows])
                        </div>
                    <!-- End of pagination section -->
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" width="20%">Description</th>
                                    <th class="text-right" scope="col" width="15%">Price</th>
                                    <th class="text-center" scope="col" width="20%">Barcode/Serial No.</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Owner</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <?php
                                $ctr = $rows->firstItem();
                             ?>
                            <tbody>
                            @foreach ($rows as $row)
                            {{--  style="background-color: {{ $row->prod_quantity == 0 ? '#fab1b1' : 'white' }}" --}}
                            <tr>
                                <td> {{ $ctr++ }} </td>
                                <td>{{ $row->prod_description }}</td>
                                <td class="text-right">&#8369; {{ number_format($row->prod_price, 2) }}</td>
                                <td class="text-center">
                                    @if($row->barcode_image_url)
                                    <a href="{{ $row->barcode_image_url }}" target="_blank" title="View">
                                    <img id="barcodeImage" src="{{ $row->barcode_image_url }}" style="display: none;">
                                        <img src="{{ asset('storage/generate/images/' . $row->prod_barcode . 'c128.png') }}" width="200px">
                                    </a>
                                    @else
                                        Image not found.
                                    @endif
                                </td>
                                @if($row->prod_quantity)
                                    <td>{{ $row->prod_quantity }}<br>
                                        <small style="color: rgb(0, 0, 0)" @readonly(true)>Product sold: <span class="text-success">{{ $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity') ?? 0 }}</span></small>
                                    </td>
                                @else
                                     <td style="color:rgb(144, 0, 0)">Out of Stock<br>
                                    <small style="color: rgb(0, 0, 0)" @readonly(true)>Product sold: <span class="text-success">{{ $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity') ?? 0 }}</span></small>
                                    </td>
                                @endif
                                
                                <td>{{ $row->type->prod_type_name }}</td>
                                <td>
                                    <a href="{{ route('product.owner.view', ['id' => $row->prod_owner_id]) }}" title="View">
                                        {{ $row->owner->prod_owner_name }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                    <a class="btn btn-success btn-sm row-print-btn" data-image="{{ $row->barcode_image_url }}" title="Print">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a class="btn btn-primary btn-sm row-open-btn" href="{{ route('product.view', [ 'id' => $row->prod_id]) }}" title="View"><i class="fa fa-folder-open"></i></a>
                                    <a class="btn btn-success btn-sm row-edit-btn" href="{{ route('product.edit', ['id' => $row->prod_id]) }}" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-info btn-sm row-edit-btn" href="{{ route('download.product.barcode', ['filename' => $row->barcode_image]) }}" title="Download"><i class="fa fa-download"></i></a>
                                    <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('product.delete', ['id' => $row->prod_id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if ($rows->isEmpty())
			            <h3 class="bg-light text-center p-4">No Items Found</h3>
		                @endif
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 <script>
    document.addEventListener("DOMContentLoaded", function() {
        const printButtons = document.querySelectorAll('.row-print-btn');

        printButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const imageUrl = button.getAttribute('data-image');
                const image = new Image();
                image.src = imageUrl;

                // Wait for the image to load
                image.onload = function() {
                    // Create a new temporary window
                    const printWindow = window.open('', '_blank');
                    printWindow.document.open();
                    printWindow.document.write(
                        `<html><body><img src="${image.src}"></body></html>`
                    );
                    printWindow.document.close();

                    // Trigger the print dialog in the temporary window
                    printWindow.onload = function() {
                        printWindow.print();
                        printWindow.close(); // Close the temporary window after printing
                    }
                };
            });
        });
    });
    
    $(document).ready(function(){
            $('.date_start').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });

            $('.date_end').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });
        });

        
 </script>
@endpush
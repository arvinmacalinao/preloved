@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'products'
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
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header border-0 text-light" style="background-color:salmon;">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $data['page'] }}</h3>
                            </div>
                            <div class="col-4 text-right">
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
                                        <a class="btn btn-primary btn-sm row-open-btn" href="{{ route('product.view', ['id' => $row->prod_id]) }}" title="View"><i class="fa fa-folder-open"></i></a>
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
                        <div style="" class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light mb-3" style="max-width: 18rem;">
                                    <div class="card-header bg-info text-light text-center">
                                        Total Products
                                    </div>
                                    <div class="card-body">
                                      <h5 class="card-title text-right">{{ $extract->sum('prod_quantity') }}</h5>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light mb-3" style="max-width: 18rem;">
                                    <div class="card-header bg-primary text-light text-center">
                                        Total Amount
                                    </div>
                                    <div class="card-body">
                                      <h5 class="card-title text-right">&#8369;{{ number_format($extract->sum('prod_price'), 2) }}</h5>
                                     
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
 <script>
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
@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'product-owner'
])

@section('content')
<div class="content">   
    <!-- This will display any message upon submission. -->
		@if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close pull-right" data-bs-dismiss="alert" aria-label="Close">x</button>
            {{ $msg }}
        </div>
    @endif
    <!-- End -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="m-0">
                        <strong>Product Owner: </strong><span class="project-title">{{ $po->prod_owner_name }}</span><br>
                        <strong>Email: </strong><span class="project-title">{{ $po->prod_owner_email  }}</span><br>
                    </h4>
                    <div class="row align-items-center">
                        <div class="col-12 text-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('product.owner.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Products Owned') }}</h3>                
                                <!-- Pagination section -->
                                    <div class="text-end">
                                        @include('subviews.pagination', ['rows' => $rows])
                                    </div>
                                <!-- End of pagination section -->
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table text-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col" width="20%">Description</th>
                                                    <th scope="col" width="20%">Price</th>
                                                    <th scope="col" width="20%">Barcode/Serial No.</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $ctr = $rows->firstItem();
                                             ?>
                                            <tbody>
                                            @foreach ($rows as $row)
                                            <tr>
                                                <td> {{ $ctr++ }} </td>
                                                <td>{{ $row->prod_description }}</td>
                                                <td>{{ $row->prod_price }}</td>
                                                @php 
						                        $path1 = base_path('public/storage/generate/barcode/'.$row->barcode_image); 
					                            @endphp
                                                <td>
                                                    @if(file_exists($path1))
                                                    <a href="{{ Storage::url('generate/barcode/'.$row->barcode_image) }}" target="_blank" title="View">
                                                        <img src="{{ Storage::url('generate/images/'.$row->prod_barcode."c128.png") }}" width="200px">
                                                    </a>
                                                    @else
						                            	Image not found.
						                            @endif
                                                </td>
                                                <td>{{ $row->prod_quantity }}</td>
                                                <td>{{ $row->type->prod_type_name }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                    <a class="btn btn-primary btn-sm row-open-btn" href="{{ route('product.view', ['id' => $row->prod_owner_id]) }}" title="View"><i class="fa fa-folder-open"></i></a>
                                                    <a class="btn btn-success btn-sm row-edit-btn" href="{{ route('product.edit', ['id' => $row->prod_owner_id]) }}" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-info btn-sm row-edit-btn" href="{{ route('download.product.barcode', ['filename' => $row->barcode_image]) }}" title="Download"><i class="fa fa-download"></i></a>
                                                    <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('product.delete', ['id' => $row->prod_owner_id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete"><i class="fa fa-trash-o"></i></a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'products'
])
<style>
    .demo {
        color: rgb(0, 146, 175);
    }
    small{
        color: black;
    }
</style>
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
                <div class="card-header">
                    <h4 class="demo m-0">
                        <small>Product: </small>{{ $p->prod_description }}<br>
                        <small>Quantity: </small>
                            @if($p->prod_quantity>0)
                                {{$p->prod_quantity}}
                                <br>
                            @else
                                Out of Stock
                            @endif
                        <small>Product Owner: </small> {{ $p->owner->prod_owner_name }} <br>
                        <small>Price: </small>Php {{ $p->prod_price }} <br>
                        <small>Serial/Barcode: </small> {{ $p->prod_barcode }}  <br>
                        @php 
                        $path1 = base_path('public/storage/generate/barcode/'.$p->barcode_image); 
                        @endphp
                        @if(file_exists($path1))
                            <a href="{{ Storage::url('generate/barcode/'.$p->barcode_image) }}" target="_blank" title="View">
                                <img src="{{ Storage::url('generate/images/'.$p->prod_barcode."c128.png") }}" width="200px">
                            </a>
                        @else
						    Image not found.
						@endif          
                    </h4>
                    <div class="row align-items-center">
                        <div class="col-12 text-right">
                            <a class="btn btn-success btn-sm" href="{{ route('product.edit', ['id' => $p->prod_id]) }}" title="Back"><span class="fa fa-caret-left"></span> Edit Details</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('product.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'product-type'
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
            <div class="card ">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $data['page'] }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('product.type.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                        <div class="border-bottom mt-0 mb-2"></div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <br>
                        <form method="POST" action="{{ route('product.type.store', ['id' => $id]) }}">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="prod_type_name">Product Name<span class="text-danger">*</span></label>
                                <input placeholder="Product Name" class="form-control @error('prod_type_name') is-invalid @enderror" type="text" maxlength="255" name="prod_type_name" id="prod_type_name" value="{{ old('prod_type_name', $pt->prod_type_name) }}" required>
                                <div class="invalid-feedback">@error('prod_type_name') {{ $errors->first('prod_type_name') }} @enderror</div>
                            </div>
                            <br>
                            @if(Str::contains(Request::url(), 'create') || Str::contains(Request::url(), 'edit'))
                            <div class="mb-2 text-end">
                                <input class="btn btn-primary" type="submit" name="form-submit" id="form-submit" value="Save">
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


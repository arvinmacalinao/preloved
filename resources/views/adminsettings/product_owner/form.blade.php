@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'product-owner'
])

@section('content')
<div class="content">   
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
                            <a class="btn btn-primary btn-sm" href="{{ route('product.owner.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                        <div class="border-bottom mt-0 mb-2"></div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <form method="POST" action="{{ route('product.owner.store', ['id' => $id]) }}">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="prod_owner_name">Owner Name<span class="text-danger">*</span></label>
                                <input placeholder="Product Name" class="form-control @error('prod_owner_name') is-invalid @enderror" type="text" maxlength="255" name="prod_owner_name" id="prod_owner_name" value="{{ old('prod_owner_name', $po->prod_owner_name) }}" required>
                                <div class="invalid-feedback">@error('prod_owner_name') {{ $errors->first('prod_owner_name') }} @enderror</div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="prod_owner_email">Owner Email</label>
                                <input placeholder="Owner Email" class="form-control @error('prod_owner_email') is-invalid @enderror" type="text" maxlength="255" name="prod_owner_email" id="prod_owner_email" value="{{ old('prod_owner_email', $po->prod_owner_email) }}">
                                <div class="invalid-feedback">@error('prod_owner_email') {{ $errors->first('prod_owner_email') }} @enderror</div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="prod_owner_phone">Owner Phone No.</label>
                                <input placeholder="Owner Phone No." class="form-control @error('prod_owner_phone') is-invalid @enderror" type="text" maxlength="255" name="prod_owner_phone" id="prod_owner_phone" value="{{ old('prod_owner_phone', $po->prod_owner_phone) }}">
                                <div class="invalid-feedback">@error('prod_owner_phone') {{ $errors->first('prod_owner_phone') }} @enderror</div>
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


@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'product'
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
                            <a class="btn btn-primary btn-sm" href="{{ route('product.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                        <div class="border-bottom mt-0 mb-2"></div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <form method="POST" action="{{ route('product.store', ['id' => $id]) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="prod_description">Product Description<span class="text-danger">*</span></label>
                                        <input placeholder="Product Description" class="form-control @error('prod_description') is-invalid @enderror" type="text" maxlength="255" name="prod_description" id="prod_description" value="{{ old('prod_description', $p->prod_description) }}" required>
                                        <div class="invalid-feedback">@error('prod_description') {{ $errors->first('prod_description') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="prod_price">Product Price<span class="text-danger">*</span></label>
                                        <input placeholder="Product Price" class="form-control @error('prod_price') is-invalid @enderror" type="number" maxlength="255" min="1" name="prod_price" id="prod_price" value="{{ old('prod_price', $p->prod_price) ?? 0 }}" required>
                                        <div class="invalid-feedback">@error('prod_price') {{ $errors->first('prod_price') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="prod_quantity">Product Quantity<span class="text-danger">*</span></label>
                                        <input placeholder="Product Quantity" class="form-control @error('prod_quantity') is-invalid @enderror" type="number" maxlength="255" min="1" name="prod_quantity" id="prod_quantity" value="{{ old('prod_quantity', $p->prod_quantity) ?? 0 }}" required>
                                        <div class="invalid-feedback">@error('prod_quantity') {{ $errors->first('prod_quantity') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="prod_type_id">Product Type</label>
                                        <select class="form-control @error('prod_type_id') is-invalid @enderror" name="prod_type_id" id="prod_type_id">                                
                                            @foreach($types as $type)
                                                <option value="{{ $type->prod_type_id }}" {{ old('prod_type_id', $p->prod_type_id) == $type->prod_type_id ? 'selected' : '' }}>{{ $type->prod_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@error('prod_type_id') {{ $errors->first('prod_type_id') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="prod_owner_name">Product Owner</label>
                                        <input autocomplete="off" type="text" class="form-control prodOwner" name="prod_owner_name" id="prod_owner_name" value="{{ old('prod_owner_name', $p->owner->prod_owner_name) }}">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="mb-2 text-end">
                                <input class="btn btn-primary" type="submit" name="form-submit" id="form-submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
    var path = "{{ route('autocompleteOwner') }}";
    let data = [];

    $('input.prodOwner').typeahead({
        source: function(query, process) {
            if (query.length) {
                return $.get(path, { query: query }, function(retrievedData) {
                    data = retrievedData;
                    const transformedData = data.map(item => `${item.prod_owner_name}`);
                    return process(transformedData);
                });
            } else {
                process([]);
            }
        },
    });
});
</script>    
@endpush

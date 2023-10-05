@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'user-group'
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
                            <a class="btn btn-primary btn-sm" href="{{ route('usergroups.list') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                        <div class="border-bottom mt-0 mb-2"></div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <br>
                        <form method="POST" action="{{ route('usergroup.store', ['id' => $id]) }}">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="ug_name">Usergroup Name<span class="text-danger">*</span></label>
                                <input placeholder="Usergroup Name" class="form-control @error('ug_name') is-invalid @enderror" type="text" maxlength="255" name="ug_name" id="ug_name" value="{{ old('ug_name', $ug->ug_name) }}" required>
                                <div class="invalid-feedback">@error('ug_name') {{ $errors->first('ug_name') }} @enderror</div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold" for="ug_display_name">Dispay Name<span class="text-danger">*</span></label>
                                <input placeholder="Display Name" class="form-control @error('ug_display_name') is-invalid @enderror" type="text" maxlength="255" name="ug_display_name" id="ug_display_name" value="{{ old('ug_display_name', $ug->ug_display_name) }}" required>
                                <div class="invalid-feedback">@error('ug_display_name') {{ $errors->first('ug_display_name') }} @enderror</div>
                            </div>
                            <div class="mb-2">
                                <div class="form-group ml-2">
                                  <div class="checkbox">
                                    <input class="mr-3 mt-1 text-center" type="checkbox" value="1" name="ug_is_admin" id="ug_is_admin"{{ (old('ug_is_admin', optional($ug)->ug_is_admin) == 1) ? ' checked="checked"' : ''}}>
                                    <label class="form-check-label fw-bold" for="ug_is_admin">Is Admin</label>
                                  </div>
                                </div>
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


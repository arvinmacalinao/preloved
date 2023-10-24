@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'users'
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
                            <h3 class="mb-0">Add {{ $data['page'] }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('user.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                        <div class="border-bottom mt-0 mb-2"></div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <form method="POST" action="{{ route('store.user', ['id' => $id]) }}">
                            @csrf
                            <h4>Personal Details</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="u_fname">First Name<span class="text-danger">*</span></label>
                                        <input placeholder="First Name" class="form-control @error('u_fname') is-invalid @enderror" type="text" maxlength="255" name="u_fname" id="u_fname" value="{{ old('u_fname', $user->u_fname) }}" required="required">
                                        <div class="invalid-feedback">@error('u_fname') {{ $errors->first('u_fname') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="u_mname">Middle Name<span class="text-danger">*</span></label>
                                        <input placeholder="Middle Name" class="form-control @error('u_mname') is-invalid @enderror" type="text" maxlength="255" name="u_mname" id="u_mname" value="{{ old('u_mname', $user->u_mname) }}" required="required">
                                        <div class="invalid-feedback">@error('u_mname') {{ $errors->first('u_mname') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="u_lname">Last Name<span class="text-danger">*</span></label>
                                        <input placeholder="Last Name" class="form-control @error('u_lname') is-invalid @enderror" type="text" maxlength="255" name="u_lname" id="u_lname" value="{{ old('u_lname', $user->u_lname) }}" required="required">
                                        <div class="invalid-feedback">@error('u_lname') {{ $errors->first('u_lname') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                    <label class="form-label fw-bold" for="u_email">E-mail Address<span class="text-danger">*</span></label>
                                    <input placeholder="E-mail Address" class="form-control @error('u_email') is-invalid @enderror" type="text" maxlength="255" name="u_email" id="u_email" value="{{ old('u_email', $user->u_email) }}" required="required">
                                    <div class="invalid-feedback">@error('u_email') {{ $errors->first('u_email') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                    <label class="form-label fw-bold" for="u_mobile">Mobile Number<span class="text-danger">*</span></label>
                                    <input placeholder="Mobile Number" class="form-control @error('u_mobile') is-invalid @enderror" type="text" maxlength="255" name="u_mobile" id="u_mobile" value="{{ old('u_mobile', $user->u_mobile) }}" required="required">
                                    <div class="invalid-feedback">@error('u_mobile') {{ $errors->first('u_mobile') }} @enderror</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>Account Details</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="u_fname">Username<span class="text-danger">*</span></label>
                                        <input placeholder="Username" class="form-control @error('u_username') is-invalid @enderror" type="text" maxlength="255" name="u_username" id="u_username" value="{{ old('u_username', $user->u_username) }}" required="required">
                                        <div class="invalid-feedback">@error('u_username') {{ $errors->first('u_username') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                    <label class="form-label fw-bold" for="password">Password<span class="text-danger">*</span></label>
                                    <input placeholder="Password" class="form-control @error('password') is-invalid @enderror" type="password" maxlength="255" name="password" id="password" value="">
                                    <div class="invalid-feedback">@error('password') {{ $errors->first('password') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="password_confirmation">Password Confirmation<span class="text-danger">*</span></label>
                                        <input placeholder="Password Confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" maxlength="255" name="password_confirmation" id="password_confirmation" value="">
                                        <div class="invalid-feedback">@error('password_confirmation') {{ $errors->first('password_confirmation') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 dd">
                                        <label class="form-label fw-bold" for="ug_id">User Group<span class="text-danger">*</span></label>
                                        <select class="form-control @error('ug_id') is-invalid @enderror" name="ug_id" id="ug_id">
                                            @foreach($ugroups as $ugroup)
                                                <option value="{{ $ugroup->ug_id }}" {{ old('ug_id', $user->ug_id) == $ugroup->ug_id ? 'selected' : '' }}>{{ $ugroup->ug_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@error('ug_id') {{ $errors->first('ug_id') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ml-2">
                                      <div class="checkbox">
                                        <input class="mr-3 mt-1 text-center" type="checkbox" value="1" name="u_is_admin" id="u_is_admin"{{ (old('u_is_admin', optional($user)->u_is_admin) == 1) ? ' checked="checked"' : ''}}>
						                <label class="form-check-label fw-bold" for="u_is_admin">Store Admin</label>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ml-2">
                                      <div class="checkbox">
                                        <input class="mr-3 mt-1 text-center" type="checkbox" value="1" name="u_is_cashier" id="u_is_cashier"{{ (old('u_is_cashier', optional($user)->u_is_cashier) == 1) ? ' checked="checked"' : ''}}>
						                <label class="form-check-label fw-bold" for="u_is_cashier">Store Cashier</label>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ml-2">
                                      <div class="checkbox">
                                        <input class="mr-3 mt-1 text-center" type="checkbox" value="1" checked name="u_enabled" id="u_enabled" {{ (old('u_enabled', optional($user)->u_enabled) == 1) ? ' checked="checked"' : ''}}>
						                <label class="form-check-label fw-bold" for="u_enabled">Enabled</label>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                        @if(auth()->user()->u_is_superadmin == 1)
                                            <div class="form-group ml-2">
                                                <div class="checkbox">
                                                    <input class="mr-3 mt-1 text-center" type="checkbox" value="1" name="u_is_superadmin" id="u_is_superadmin"{{ (old('u_is_superadmin', optional($user)->u_is_superadmin) == 1) ? ' checked="checked"' : '' }}>
                                                    <label class="form-check-label fw-bold" for="u_is_superadmin">Is Superadmin</label>
                                                </div>
                                            </div>
                                        @endif
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

@push('scripts')

@endpush

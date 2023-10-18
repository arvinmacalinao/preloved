@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'sales'
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
                <div class="card">
                    <div class="card-header border-0" style="background-color:rgb(124, 124, 124);">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 text-light">{{ $data['page'] }}</h3>
                            </div>
                            <div class="col-4">
                                <div class="pull-right">
                                    <a class="btn btn-info btn-sm" id="" href="" name="download-list-btn" class="print-download-btn pr" title="Download List"><span class="fa fa-floppy-o"></span> Print</a>
                                </div>
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
                                            <option value="{{ $type->prod_type_id }}" >{{ $type->prod_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">@error('prod_type_id') {{ $errors->first('prod_type_id') }} @enderror</div>
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
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" width="10%">Date of Sale</th>
                                        <th scope="col" width="10%">Customer</th>
                                        <th scope="col" width="20%">Product Sold</th>
                                        <th class="text-right" width="10%" scope="col">Product Type</th>
                                        <th class="text-right" scope="col">Payment Method</th>
                                        <th class="text-right" scope="col">Quantity Sold</th>
                                        <th class="text-right" scope="col">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($rows as $row)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ date('m-d-y', strtotime($row->transaction->ot_transact_date)) }}</td>
                                    <td>{{ $row->order->order_customer_name }}</td>
                                    <td>{{ $row->product->prod_description }}</td>
                                    <td>{{ $row->product->type->prod_type_name }}</td>
                                    <td class="text-right">{{ $row->transaction->mode->payment_mode_name }}</td>
                                    <td class="text-right">{{ $row->order_quantity }}</td>
                                    <td class="text-right"> &#8369; {{ number_format($row->order_amount_total, 2) }} </td>
                                </tr>
                                @endforeach
                                <tr style="border-">
                                    <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                    <td class="text-right"><strong>{{ $extract->sum('order_quantity') }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format($extract->sum('order_amount_total'), 2) }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                            <hr>
                            @if ($rows->isEmpty())
				                <h3 class="bg-light text-center p-4">No Items Found</h3>
			                @endif
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
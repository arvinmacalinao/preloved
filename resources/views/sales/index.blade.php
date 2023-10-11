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
                <div class="card ">
                    <div class="card-header border-0 text-light" style="background-color:salmon;">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $data['page'] }}</h3>
                            </div>
                        </div>
                        <!-- Search engine section -->
                        <div class="mb-1 position-relative">
                            <form class="row row-cols-lg-auto g-2 align-items-center" method="POST" action="{{ url()->current() }}">
                                <div class="col-md-2">
                                    <div class="input-group-prepend">
                                    <label class="text-light mr-2" for="range_start">From:</label>
                                    <input class="form-control datetime_range_start" placeholder="(From)" name="range_start" id="range_start" maxlength=""  type="text" value=""></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group-prepend">
                                    <label class="text-light mr-2" for="range_end">To:</label>
                                    <input class="form-control datetime_range_end" placeholder="(To)" name="range_end" id="range_end" maxlength=""  type="text" value=""></div>
                                </div>
                                @csrf
                                <div class="col-auto">
                                    <input class="form-control" type="text" placeholder="Search" name="search" id="search" maxlength="255" value="{{ old('search', $search) }}">
                                </div>
                                <div class="col-auto">
                                    <input class="btn btn-primary btn-sm" type="submit" name="search-btn" id="search-btn" value="Search">
                                </div>
                            </form>
                        </div>
                        <!-- End of search engine section -->
                    </div>
                    <div class="card-footer ">
                        
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
                                        <th scope="col" width="10%">Date of Sale</th>
                                        <th scope="col" width="10%">Customer</th>
                                        <th scope="col" width="20%">Product Sold</th>
                                        <th scope="col">Quantity Sold</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Payment Method</th>
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
                                    <td>{{ date('m-d-y', strtotime($row->transaction->ot_transact_date)) }}</td>
                                    <td>{{ $row->order->order_customer_name }}</td>
                                    <td>{{ $row->product->prod_description }}</td>
                                    <td>{{ $row->order_quantity }}</td>
                                    <td>{{ $row->order_amount_total }}</td>
                                    <td>{{ $row->transaction->mode->payment_mode_name }}</td>
                                    <td></td>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
                var startDate = new Date(); // Set your desired start date
                var endDate = new Date();   // Set your desired end date
                    
                // Initialize datepicker for the start date
                $('.datetime_range_start').datepicker({
                    format: 'yyyy-mm-dd', // Set the desired date format
                    autoclose: true,
                });
            
                // Initialize datepicker for the end date
                $('.datetime_range_end').datepicker({
                    format: 'yyyy-mm-dd', // Set the desired date format
                    autoclose: true,
                });
        });
    </script>
@endpush
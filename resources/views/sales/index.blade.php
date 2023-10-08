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
                            {{-- <div class="col-4 text-right">
                                <a href="{{ route('product.create') }}" title="Add {{ $data['page'] }}" class="btn btn-sm btn-primary">Add {{ $data['page'] }}</a>
                            </div> --}}
                        </div>
                        
                        <!-- Search engine section -->
                        <div class="mb-1 position-relative">
                            <form class="row row-cols-lg-auto g-2 align-items-center" method="POST" action="{{ url()->current() }}">
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
        
    </script>
@endpush
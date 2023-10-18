@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">   
                        <!-- Pagination section -->
                            <div class="text-right">
                                @include('subviews.pagination', ['rows' => $rows])
                            </div>
                        <!-- End of pagination section -->
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
                                    <td>{{ $row->product->type->prod_type_name }}</td>
                                    <td class="text-right">{{ $row->transaction->mode->payment_mode_name }}</td>
                                    <td class="text-right">{{ $row->order_quantity }}</td>
                                    <td class="text-right"> &#8369; {{ number_format($row->order_amount_total, 2) }} </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            @if ($rows->isEmpty())
				                <h3 class="bg-light text-center p-4">No Items Found</h3>
			                @endif
                        </div>
                        <!-- Pagination section -->
                        <div class="text-right">
                            @include('subviews.pagination', ['rows' => $rows])
                        </div>
                        <!-- End of pagination section -->
                    </div>
                    <div class="card-footer">
                        <div style="" class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light mb-3" style="max-width: 18rem;">
                                    <div class="card-header bg-info text-light text-center">
                                        Total Products Sold
                                    </div>
                                    <div class="card-body">
                                      <h5 class="card-title text-right">{{ $extract->sum('order_quantity') }}</h5>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light mb-3" style="max-width: 18rem;">
                                    <div class="card-header bg-primary text-light text-center">
                                        Total Amount Sold
                                    </div>
                                    <div class="card-body">
                                      <h5 class="card-title text-right">&#8369;{{ number_format($extract->sum('order_amount_total'), 2) }}</h5>
                                     
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
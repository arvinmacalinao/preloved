@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'dashboard'
])

@section('content')
    <div class="content">
        @if(strlen($msg) > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ $msg }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-cart-simple text-danger"></i>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="numbers">
                                    <p class="card-category">Products</p>
                                    <p class="card-title">{{ $products->sum('prod_quantity') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> Updated
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->u_is_superadmin == 1 | Auth::user()->u_is_owner == 1)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-bullet-list-67 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="numbers">
                                    <p class="card-category">No. of Products Sold</p>
                                    <p class="card-title">{{ $sales->sum('order_quantity') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            @if ($sales->isNotEmpty())
                                @php
                                    $latestSale = $sales->max('created_at');
                                @endphp
                            <i class="fa fa-clock-o"></i>The latest sale was on  {{ $latestSale->format('F j, Y') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="numbers">
                                    <p class="card-category">Monthly Sales (Current Month)</p>
                                    <p class="card-title">&#8369;{{ number_format($monthlysales->sum('order_amount_total'), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::createFromFormat('m', $month)->format('F') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="numbers">
                                    <p class="card-category">Overall Sales</p>
                                    <p class="card-title">&#8369;{{ number_format($sales->sum('order_amount_total'), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> Updated
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
       
    </script>
@endpush
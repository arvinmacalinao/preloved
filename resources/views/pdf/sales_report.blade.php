<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
</head>
<body>
    <img src="{{ public_path('img/luxeford_logo.png') }}" width="570" height="150">
    <div class="container">
        <h1>Sales Report</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">   
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="text-align: left" scope="col" width="5%">#</th>
                                        <th style="text-align: left" scope="col" width="10%">Date of Sale</th>
                                        <th style="text-align: left" scope="col" width="15%">Customer</th>
                                        <th style="text-align: left" scope="col" width="20%">Product Sold</th>
                                        <th style="text-align: center" width="10%" scope="col">Product Type</th>
                                        <th style="text-align: center" scope="col">Payment Method</th>
                                        <th style="text-align: center" scope="col">Quantity Sold</th>
                                        <th style="text-align: center" scope="col">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($rows as $row)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ date('m-d-y', strtotime($row->transaction->ot_transact_date)) }}</td>
                                    <td style="text-align: left">{{ $row->order->order_customer_name }}</td>
                                    <td style="text-align: left">{{ $row->product->prod_description }}</td>
                                    <td style="text-align: center">{{ $row->product->type->prod_type_name }}</td>
                                    <td style="text-align: center">{{ $row->transaction->mode->payment_mode_name }}</td>
                                    <td style="text-align: center">{{ $row->order_quantity }}</td>
                                    <td style="text-align: left"> P {{ number_format($row->order_amount_total, 2) }} </td>
                                </tr>
                                @endforeach
                                <tr style="border">
                                    <td colspan="5" class="text-right"><strong></strong></td>
                                    <td ><strong>Total:</strong></td>
                                    <td style="text-align: center"><strong>{{ $extract->sum('order_quantity') }}</strong></td>
                                    <td class="text-right"><strong>P {{ number_format($extract->sum('order_amount_total'), 2) }}</strong></td>
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
</body>
</html>
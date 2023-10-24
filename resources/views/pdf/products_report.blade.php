<!DOCTYPE html>
<meta charset="UTF-8">
<html>
<head>
    <title>Sales Report</title>
</head>
<body>
    <img src="{{ public_path('img/luxeford_logo.png') }}" width="570" height="150">
    <div class="container">
        <h1>Products Report</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">   
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" width="20%">Description</th>
                                        <th class="text-center" scope="col" width="20%">Barcode/Serial No.</th>
                                        <th style="text-align: left;" scope="col" width="8%">Type</th>
                                        <th style="text-align: left;" scope="col">Owner</th>
                                        <th class="text-right" scope="col">Quantity Remaining</th>
                                        <th class="text-right" scope="col">Quantity Sold</th>
                                        <th scope="col" width="15%">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($rows as $row)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $row->prod_description }}</td>
                                    <td style="text-align: center;">
                                        @if ($row->barcode_image_url)
                                            <img src="{{ public_path('storage/generate/images/' . $row->prod_barcode . 'c128.png') }}" width="300px">
                                        @else
                                            Image not found.
                                        @endif
                                    </td>
                                    <td>{{ $row->type->prod_type_name }}</td>
                                    <td>
                                        <a href="{{ route('product.owner.view', ['id' => $row->prod_owner_id]) }}" title="View">
                                            {{ $row->owner->prod_owner_name }}
                                        </a>
                                    </td>
                                    <td style="text-align: center;">{{ $row->prod_quantity }}</td>
                                    <td style="text-align: center;" >{{ $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity') ?? 0 }}</td>
                                    <td style="text-align: right;"> {{ number_format($row->prod_price, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr style="border">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="" class="text-right"><strong>Total:</strong></td>
                                    <td style="text-align: center;"><strong>{{ $extract->sum('prod_quantity') }}</strong></td>
                                    @php
                                       $totalQuantity = 0; // Initialize the total quantity to 0
                                        foreach ($rows as $row) {
                                            $totalQuantity += $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity');
                                        }
                                    @endphp
                                    <td style="text-align: center;"><strong>{{ $totalQuantity ?? 0 }}</strong></td>
                                    @php
                                    $totalPrice = 0; // Initialize the total price to 0
                                            foreach ($rows as $row) {
                                                $quantity = $row->prod_quantity;
                                                $price = $row->prod_price;
                                                $totalPrice += $quantity * $price; // Calculate and accumulate the total price
                                            }
                                    @endphp
                                    <td style="text-align: right;"><strong>P {{ number_format($totalPrice, 2) }}</strong></td>
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
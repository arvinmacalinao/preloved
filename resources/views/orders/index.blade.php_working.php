@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'products'
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
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-header border-0 text-light" style="background-color:salmon;">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $data['page'] }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                {{-- {{ route('product.create') }} --}}
                                <a href="" title="Add {{ $data['page'] }}" class="btn btn-sm btn-primary">Add {{ $data['page'] }}</a>
                            </div>
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
                    <form action="{{ route('order.store', ['id' => $id]) }}" method="POST">
                        @csrf
                    <div class="card-footer ">
                    <!-- End of pagination section -->
                        <hr>
                        <div class="table-responsive">
                            <table class="table text-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" width="35%">Product</th>
                                        <th scope="col" width="10%">Qty</th>
                                        <th scope="col" width="20%">Price</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Total</th>
                                        <th><a href="#" class="btn btn-sm btn-success add_more"><i class="fa fa-plus-circle"></i></a></th>
                                    </tr>
                                </thead>
                                <tbody class="addMoreProduct">
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <select name="prod_id[]" id="prod_id" class="form-control prod_id">
                                                <option value="">--Select Product--</option>
                                                @foreach ($products as $product)
                                                <option data-price="{{ $product->prod_price }}" data-max-quantity="{{ $product->prod_quantity }}" value="{{ $product->prod_id }}">{{ $product->prod_description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" value="1" min="1" name="order_quantity[]" id="order_quantity" 
                                            class="form-control order_quantity">
                                        </td>
                                        <td>
                                            <input type="number" name="price[]" id="price"  
                                            class="form-control price">
                                        </td>
                                        <td>
                                            <input type="number" value="0" min="0" name="order_discount[]" id="order_discount"  
                                            class="form-control order_discount">
                                        </td>
                                        <td>
                                            <input type="number" name="order_amount_total[]" id="order_amount_total" 
                                            class="form-control order_amount_total">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-danger delete">x</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-header border-0 text-light" style="background-color:salmon;">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h5 class="card-title">Total: <span class="total">0.00</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="order_customer_name">Customer Name<span class="text-danger">*</span></label>
                                        <input placeholder="Customer Name" class="form-control @error('order_customer_name') is-invalid @enderror" type="text" maxlength="255" name="order_customer_name" id="order_customer_name" value="" required>
                                        <div class="invalid-feedback">@error('order_customer_name') {{ $errors->first('order_customer_name') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="order_customer_phone">Customer Number<span class="text-danger">*</span></label>
                                        <input placeholder="Customer Number" class="form-control @error('order_customer_phone') is-invalid @enderror" type="text" maxlength="255" name="order_customer_phone" id="order_customer_phone" value="">
                                        <div class="invalid-feedback">@error('order_customer_phone') {{ $errors->first('order_customer_phone') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="order_customer_name">Payment Mode<span class="text-danger">*</span></label><br>
                                        <div class="form-check-inline ml-1">
                                            <label class="form-check-label mr-2">
                                            <input type="radio" class="form-check-input" name="payment_mode_id" id="payment_mode_id" value="1">
                                            Cash
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label mr-2">
                                            <input type="radio" class="form-check-input" name="payment_mode_id" id="payment_mode_id" value="2">
                                            Bank Transfer
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label mr-2">
                                            <input type="radio" class="form-check-input" name="payment_mode_id" id="payment_mode_id" value="3">
                                            E-Mobile 
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label mr-2">
                                            <input type="radio" class="form-check-input" name="payment_mode_id" id="payment_mode_id" value="4">
                                            Credit Card
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="ot_payment">Payment<span class="text-danger">*</span></label>
                                        <input placeholder="Payment" class="form-control @error('ot_payment') is-invalid @enderror" type="text" maxlength="255" name="ot_payment" id="ot_payment" value="" required>
                                        <div class="invalid-feedback">@error('ot_payment') {{ $errors->first('ot_payment') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold" for="ot_change">Change<span class="text-danger"></span></label>
                                        <input readonly class="form-control @error('ot_change') is-invalid @enderror" type="text" maxlength="255" name="ot_change" id="ot_change" value="">
                                        <div class="invalid-feedback">@error('ot_change') {{ $errors->first('ot_change') }} @enderror</div>
                                    </div>
                                    <div class="mb-2 text-end">
                                        <input class="btn btn-primary btn-block" type="submit" name="form-submit" id="form-submit" value="Save">
                                    </div>
                                </div>
                            </div>
                        </form>
                    <hr>
                    </div>
                    <div class="card-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    $(document).ready(function () {

        $(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });

        $('.add_more').on('click', function() {
        var product = $('.prod_id').html();
        var numberofrow = $('.addMoreProduct tr').length + 1; // Adjust the index

        var tr = '<tr>' +
            '<td class="no">' + numberofrow + '</td>' +
            '<td><select class="form-control prod_id" name="prod_id[]">' + 
                product + 
            '</select></td>' +
            '<td><input type="number" value="1" min="1" name="order_quantity[]" class="form-control order_quantity"></td>' +
            '<td><input type="number" name="price[]" class="form-control price"></td>' +
            '<td><input type="number" value="0" min="0" name="order_discount[]" class="form-control order_discount"></td>' +
            '<td><input type="number" name="order_amount_total[]" class="form-control order_amount_total"></td>' +
            '<td><a href="#" class="btn btn-sm btn-danger delete">x</a></td>' +
            '</tr>';

            $('.addMoreProduct').append(tr);
            calculateTotal();
        });

        $('.addMoreProduct').delegate('.delete', 'click', function(){
            $(this).parent().parent().remove();
            calculateTotal();
        });

        function calculateTotal() {
            var total = 0;

            // Loop through each row in the table
            $('.addMoreProduct tr').each(function () {
                var quantity = parseFloat($(this).find('.order_quantity').val()) || 0;
                var price = parseFloat($(this).find('.price').val()) || 0;
                var discount = parseFloat($(this).find('.order_discount').val()) || 0;

                var subtotal = (quantity * price) - ((quantity * price * discount) / 100);
                total += subtotal;
            });

            // Display the total with two decimal places
            $('.total').text(total.toFixed(2));
        }

        // Attach an event listener to input fields to recalculate total on input
        $('.addMoreProduct').on('input', 'input', calculateTotal);

        // Calculate the initial total when the page loads
        calculateTotal();

        // Bind the calculation logic to the 'change' event of relevant input fields
        $('.addMoreProduct').delegate('.prod_id, .order_quantity, .order_discount', 'change', function(){
            var tr = $(this).closest('tr'); // Find the closest row
            var selectedOption = tr.find('.prod_id option:selected');

            // Get the product price from the selected option's data attribute
            var price = parseFloat(selectedOption.attr('data-price'));

            // Set the product price in the 'price' input field
            tr.find('.price').val(price);

            // Get the quantity and discount values
            var qty = parseFloat(tr.find('.order_quantity').val());
            var disc = parseFloat(tr.find('.order_discount').val());

            // Get the maximum quantity allowed from the selected option's data attribute
            var maxQuantity = parseInt(selectedOption.attr('data-max-quantity'));

            // Set the maximum quantity as the 'max' attribute of the 'order_quantity' input field
            tr.find('.order_quantity').attr('max', maxQuantity);

            // Calculate the total amount
            var total_amount = (qty * price) - ((qty * price * disc) / 100);

            // Set the calculated total amount in the 'order_amount_total' input field
            tr.find('.order_amount_total').val(total_amount);

            calculateTotal();
        });

        $('#ot_payment').keyup(function(){
            var total = $('.total').html();
            var payment = $(this).val();
            var tot     = payment - total;
            $('#ot_change').val(tot);
        });
    });
    </script>
@endpush
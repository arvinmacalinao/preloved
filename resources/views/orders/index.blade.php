@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'products'
])
@section('content')
<style>
/* Add a custom CSS class to hide the sidebar */
#prodBarcode {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 25px; /* Adjust the padding to make space for the arrow icon */
    width: 100%;
}

/* Style for the select arrow icon */
#prodBarcode::-ms-expand {
    display: none;
}
        .sidebar {
            display: none;
        }

        /* Adjust the main-panel and content styles when the sidebar is hidden */
        .main-panel {
            width: 100%; /* Fill the entire width when sidebar is hidden */
        }

        .main-panel .content {
            margin-left: 0; /* Remove margin when sidebar is hidden */
        }
</style>
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
        <div class="row">
            <div class="col-md-9">
                <div class="card ">
                    <div class="card-header border-0 text-light" style="background-color:salmon;">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $data['page'] }}</h3>
                            </div>
                        </div>
                        
                        <!-- Search engine section -->
                        <div class="mb-1 position-relative">
                            <form id="productForm" class="row row-cols-lg-auto g-2 align-items-center" method="POST" action="{{ route('order.store', ['id' => $id]) }}">
                                @csrf
                                <div class="col-md-12">
                                    <input class="form-control" type="text" placeholder="Enter barcode here" name="prodBarcode" id="prodBarcode" maxlength="255" value="">
                                    <a href="#" id="addProductBtn" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus-circle mr-2"></i> Add {{ $data['page'] }}</a>
                                </div>
                            </form>
                        </div>
                        <!-- End of search engine section -->
                    </div>
                    <form id="productForm" action="{{ route('order.store', ['id' => $id]) }}" method="POST">
                        @csrf
                    <div class="card-footer ">
                    <!-- End of pagination section -->
                        <hr>
                        <div class="table-responsive">
                            <table class="table text-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" width="30%">Product</th>
                                        <th scope="col" width="10%">Qty</th>
                                        <th scope="col" width="14%">Price</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="productList">
                                    <tr>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card ">
                    <div class="card-header border-0 text-light" style="background-color:salmon;">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h5 class="card-title">Total: <span class="total">0.00</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                                    <input class="ot_total_amount" type="hidden" name="ot_total_amount" id="ot_total_amount">
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
        var addedRowsData = [];
        var addedProductIds = [];

        $(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });

        $('#productList').on('input', '.order_quantity, .order_discount', function () {
        // Calculate amount_total for the current row
        var row = $(this).closest('tr');
        calculateAmountTotal(row);
        });

        // Calculate amount_total for each row on page load
        $('table tbody tr').each(function () {
            calculateAmountTotal($(this));
        });

        var productCount = 0;

        let buttonClicked = false; // Flag to track whether the button has been clicked

        $('#productForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission behavior
            // Handle the form submission logic here
        });

        $('#prodBarcode').on('keyup', function(event) {
            if (event.keyCode === 13) { // Check if Enter key is pressed (key code 13)
                event.preventDefault(); // Prevent the default form submission
                $('#addProductBtn').click(); // Trigger the button click event
                // Clear the input box
                $('#prodBarcode').val('');
            } else {
                var barcode = $(this).val();
                fetchProductSuggestions(barcode);
            }
        });
        
        var addedRowsData = []; // Array to store data for added rows

        $('#addProductBtn').click(function() {
            var barcode = $('#prodBarcode').val();

            getProductDetailsByBarcode(barcode, function(productDetails) {

                var productId = productDetails.prod_id;

                // Check if the product has already been added
                if (addedProductIds.includes(productId)) {
                    var index = addedProductIds.indexOf(productId);
                    addedProductIds.splice(index, 1);

                    alert('This product already in the cart.');
                } else {
                    
                // Add the product to the cart
                addedProductIds.push(productId);

                if (productDetails) {
                productCount++;
                var newRow = `
                <tr>
                    <td>${productCount}</td>
                    <td><input type="text" class="form-control prod_description" name="prod_description[]" value="${productDetails.prod_description}"></td>
                    <td><input type="number" class="form-control order_quantity" name="order_quantity[]" value="1" min="1" data-max-quantity="${productDetails.prod_quantity}"></td>
                    <td><input type="number" class="form-control prod_price" name="prod_price[]" value="${productDetails.prod_price}" readonly></td>
                    <td><input type="number" class="form-control order_discount" name="order_discount[]" value="0" min="0" max="100"></td>
                    <td><input type="number" class="total_amount form-control" name="order_amount_total[]" value="0.00" readonly></td>
                    <td><button class="btn btn-danger removeProduct">Remove</button></td>
                    <input type="hidden" class="prod_id" name="prod_id[]" value="${productDetails.prod_id}">
                </tr>
                `;

                $('#productList').append(newRow);

                // Bind calculation logic to input fields (except the newly added row)
                $(document).on('input', '.order_quantity, .order_discount', calculateTotal);

                // Remove product row
                $('.removeProduct').click(function() {
                    $(this).closest('tr').remove();
                    calculateTotal();
                });

                // Clear input field
                $('#prodBarcode').val('');
                calculateTotal();
                }
                }
            });
        });

        // Function to calculate total
        function calculateTotal() {
            var total = 0;

            $('.order_quantity').each(function() {
                var quantity = parseFloat($(this).val()) || 0;
                var price = parseFloat($(this).closest('tr').find('.prod_price').val()) || 0;
                var discount = parseFloat($(this).closest('tr').find('.order_discount').val()) || 0;

                // Get the maximum quantity allowed from the data attribute
                var maxQuantity = parseFloat($(this).data('max-quantity')) || 0;

                // Check if the quantity exceeds the maximum, and adjust it if necessary
                if (quantity > maxQuantity) {
                    quantity = maxQuantity;
                    $(this).val(quantity); // Update the input field with the corrected value
                }

                var subtotal = quantity * price * (1 - discount / 100);
                total += subtotal;

                // Update the total_amount in the same row
                var row = $(this).closest('tr');
                var totalAmountInput = row.find('.total_amount');
                totalAmountInput.val(subtotal.toFixed(2));
            });

            $('.total').text(total.toFixed(2));
            $('.ot_total_amount').text(total.toFixed(2));
        }

        // Function to calculate total
        function calculateAmountTotal(row) {
            var quantity = parseFloat(row.find('.order_quantity').val()) || 0;
            var price = parseFloat(row.find('.prod_price').val()) || 0;
            var discount = parseFloat(row.find('.order_discount').val()) || 0;
                
            var amountTotal = (quantity * price) - ((quantity * price * discount) / 100);
                
            // Update the total_amount <td> with the calculated value
            row.find('.total_amount').text(amountTotal.toFixed(2));
        }

        $('#ot_payment').keyup(function(){
            var total = $('.total').html();
            var payment = $(this).val();
            var tot     = payment - total;
            $('#ot_change').val(tot);
        });
 
        // Function to retrieve product details by barcode (Replace this with your logic)
        function getProductDetailsByBarcode(barcode, callback) {
        // Make an AJAX request to fetch product details by barcode
            $.ajax({
                url: '/get-product-details-by-barcode', // Replace with your actual route URL
                method: 'GET',
                data: { barcode: barcode },
                success: function(response) {
                    if (response.success) {
                        // Product details were successfully retrieved
                        var productDetails = response.product;
      

                        // Call the callback function and pass the product details
                        if (typeof callback === 'function') {
                            callback(productDetails);
                        }
                    } else {
                        alert('Product not found');
                        $('#prodBarcode').val('');
                    }
                },
                error: function() {
                    // Handle AJAX error here
                    console.log('Error fetching product details');
                }
            });
        }
        
        function fetchProductSuggestions(barcode) {
            $.ajax({
                url: '/get-product-suggestions', // Replace with your route URL
                method: 'GET',
                data: { barcode: barcode },
                success: function(response) {
                 console.log(response)
                    
                },
                error: function() {
                    // Handle AJAX error here
                    console.log('Error fetching product suggestions');
                }
            });
        }

        $( "#prodBarcode" ).autocomplete({
          source: function(request, response) {
              $.ajax({
              url: siteUrl + '/' +"get-product-suggestions",
              data: {
                      term : request.term
               },
              dataType: "json",
              success: function(data){
                console.log(data)
                 var resp = $.map(data,function(obj){
                      return obj.name;
                 }); 
             
                 response(resp);
              }
          });
        },
        minLength: 2
        });
});

// $(document).on('click', function(event) {
//     var target = $(event.target);
    
//     if (!target.is('#prodBarcode') && !target.is('#productSuggestions')) {
//         $('#productSuggestions').remove();
//     }
// });
    </script>
@endpush
<html><table class="table table-striped table-bordered mt-3" style="width: 100%" id="mydatatable">
    <thead>
        <tr><th colspan="15"><h4><strong>Sales</strong></h4></th></tr>
        <tr><th colspan="15"></tr>
        <tr><th colspan="15">{{ date('Y-m-d') }}</th></tr>
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
    <tbody> 
        @foreach ($collection as $row)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td>{{ date('m-d-y', strtotime($row->transaction->ot_transact_date)) }}</td>
                <td>{{ $row->order->order_customer_name }}</td>
                <td>{{ $row->product->prod_description }}</td>
                <td>{{ $row->order_quantity }}</td>
                <td>{{ $row->order_amount_total }}</td>
                <td>{{ $row->transaction->mode->payment_mode_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</html>
<script>
    
</script>
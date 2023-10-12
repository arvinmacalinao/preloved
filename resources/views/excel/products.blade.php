<html><table class="table table-striped table-bordered mt-3" style="width: 100%" id="mydatatable">
    <thead>
        <tr><th colspan="15"><h4><strong>Sales</strong></h4></th></tr>
        <tr><th colspan="15"></tr>
        <tr><th colspan="15">{{ date('Y-m-d') }}</th></tr>
        <tr>
            <th scope="col">#</th>
            <th scope="col" width="20%">Description</th>
            <th class="text-right" scope="col" width="15%">Price</th>
            <th class="text-center" scope="col" width="20%">Barcode/Serial No.</th>
            <th scope="col">Quantity</th>
            <th scope="col">Product Sold</th>
            <th scope="col">Type</th>
            <th scope="col">Owner</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody> 
        @foreach ($collection as $row)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td>{{ $row->prod_description }}</td>
                <td class="text-right">&#8369; {{ number_format($row->prod_price, 2) }}</td>
                <td class="text-center">{{ $row->prod_barcode }}</td>
                @if($row->prod_quantity)
                    <td>{{ $row->prod_quantity }}</td>
                    <td>{{ $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity') ?? '-' }}</td>
                @else
                     <td style="color:rgb(144, 0, 0)">Out of Stock</td>
                     <td>{{ $row->orderdetails->where('prod_id', $row->prod_id)->sum('order_quantity') ?? '-' }}</td>
                @endif
                
                <td>{{ $row->type->prod_type_name }}</td>
                <td>
                    <a href="{{ route('product.owner.view', ['id' => $row->prod_owner_id]) }}" title="View">
                        {{ $row->owner->prod_owner_name }}
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</html>
<script>
    
</script>
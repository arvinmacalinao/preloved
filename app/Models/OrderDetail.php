<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use SoftDeletes;
    
    protected $table        = 'order_details';
    protected $primaryKey   = 'od_id';
    protected $fillable     = [ 'order_id', 'prod_id', 'price', 'order_quantity', 'order_amount_total', 'order_discount', 'created_at', 'updated_at', 'deleted_at' ];
    protected $timestamp    = [ 'created_at', 'updated_at', 'deleted_at' ];

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
			$query->where('order_amount_total', 'LIKE', "%$search%")
            ->orwhere('price', 'LIKE', "%$search%")
            ->orWhereHas('order', function($order) use($search) {
                $order->where('order_customer_name', 'like', "%$search%");
                })
                ->orWhereHas('product', function($product) use($search) {
                $product->where('prod_description', 'like', "%$search%");
                });
		});
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id');
    }

    public function transaction()
    {
        return $this->belongsTo(OrderTransaction::class, 'order_id', 'order_id');
    }
}

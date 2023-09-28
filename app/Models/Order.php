<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use SoftDeletes;
    
    protected $table        = 'orders';
    protected $primaryKey   = 'order_id';
    protected $fillable     = [ 'order_date', 'product_id', 'order_quantity', 'order_amount_total', 'order_customer_name', 'order_payment_mode', 'order_customer_phone', 'order_discount', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by' ];
    protected $timestamp    = [ 'created_at', 'updated_at', 'deleted_at' ];

}

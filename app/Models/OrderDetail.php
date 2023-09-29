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
}

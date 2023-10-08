<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTransaction extends Model
{
    use SoftDeletes;
    
    protected $table        = 'order_transactions';
    protected $primaryKey   = 'ot_id';
    protected $fillable     = [ 'order_id', 'ot_payment', 'ot_change', 'ot_total_amount', 'payment_mode_id', 'ot_transace_date', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at' ];
    protected $timestamp    = [ 'created_at', 'updated_at', 'deleted_at' ];

    public function mode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id', 'payment_mode_id');
    }
}

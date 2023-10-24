<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{ 
    protected $table        = 'notifications';
    protected $primaryKey   = 'not_id';
    protected $fillable     = [ 'not_id', 'not_message', 'not_type_id', 'prod_id', 'admin_id', 'read_at', 'created_at', 'created_at' ];
    protected $timestamp    = [ 'read_at', 'created_at', 'created_at' ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id');
    }

    public function type()
    {
        return $this->belongsTo(NotificationType::class, 'not_type_id');
    }
    
    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
			$query->where('not_message', 'LIKE', "%$search%")
            ->orWhereHas('product', function($product) use($search) {
                $product->where('prod_description', 'like', "%$search%");
                });
		});
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
    
        if ($endDate) {
            $query->whereDate('created_at', '>=', $endDate);
        }
    
        return $query;
    }
}

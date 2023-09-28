<?php

namespace App\Models;

use App\Models\ProductOwner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table        = 'products';
    protected $primaryKey   = 'prod_id';
    protected $fillable     = [ 'prod_barcode', 'prod_description', 'prod_type_id', 'prod_price', 'prod_quantity', 'prod_owner_id', 'barcode_image', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by' ];
    protected $timestamp    = [ 'created_at', 'updated_at', 'deleted_at' ];

    public function encoder() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function owner(){
        return $this->belongsTo(ProductOwner::class, 'prod_owner_id');
    }

    public function type(){
        return $this->belongsTo(ProductType::class, 'prod_type_id');
    }

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
			$query->where('prod_description', 'LIKE', "%$search%")
            ->orwhere('prod_price', 'LIKE', "%$search%")
            ->orWhereHas('owner', function($owner) use($search) {
                $owner->where('prod_owner_name', 'like', "%$search%");
                });
		});
    }

    public function barcode()
    {
        if(\Storage::disk('generate')->exists('barcode/'.$this->barcode_image)) {
            return asset('generate/barcode/'.$this->barcode_image);
        }
    }
}

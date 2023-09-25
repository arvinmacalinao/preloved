<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductType extends Model
{
    use SoftDeletes;
    
    protected $table        = 'product_types';
    protected $primaryKey   = 'prod_type_id';
    protected $fillable     = [ 'prod_type_name', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates        = ['created_at', 'updated_at', 'deleted_at'];

    public function encoder() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
			$query->where('prod_type_name', 'LIKE', "%$search%");
		});
    }
}

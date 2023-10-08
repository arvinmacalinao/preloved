<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOwner extends Model
{
    use Notifiable;
    use SoftDeletes;
    
    protected $table        = 'product_owners';
    protected $primaryKey   = 'prod_owner_id';
    protected $fillable     = [ 'prod_owner_name', 'prod_owner_email', 'prod_owner_phone', 'created_by', 'updated_by'];
    protected $timestamp    = ['created_at', 'updated_at'];

    public function encoder() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
			$query->where('prod_owner_name', 'LIKE', "%$search%");
		});
    }

    public function routeNotificationForMail()
    {
        return $this->prod_owner_email;
    }
}

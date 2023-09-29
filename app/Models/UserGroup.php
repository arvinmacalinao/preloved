<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use SoftDeletes;
    
    protected $table        = 'product_types';
    protected $primaryKey   = 'prod_type_id';
    protected $fillable     = [ 'prod_type_name', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates        = ['created_at', 'updated_at', 'deleted_at'];
}

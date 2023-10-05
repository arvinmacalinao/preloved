<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGroup extends Model
{
    use SoftDeletes;
    
    protected $table        = 'usergroups';
    protected $primaryKey   = 'ug_id';
    protected $fillable     = [ 'ug_name', 'ug_is_admin', 'ug_display_name', 'created_at', 'updated_at', 'deleted_at' ];
    protected $dates        = ['created_at', 'updated_at', 'deleted_at'];
}

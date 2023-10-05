<?php

namespace App\Models;

use App\Models\UserGroup;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table        = 'users';
    protected $primaryKey   = 'id';
    protected $fillable     = [ 'u_fname', 'u_mname', 'u_lname', 'u_username', 'u_email', 'u_mobile', 'password', 'ug_id', 'u_enabled', 'u_is_superadmin', 'u_is_owner', 'u_is_store_manager', 'u_is_admin', 'synched', 'sync_date', 'deleted_at', 'remember_token', 'created_at', 'updated_at' ];
    protected $dates        = [ 'sync_date', 'created_at', 'updated_at' ];    

    public function getAuthIdentifier(){
		return $this->getKey();
	}

    function getAuthPassword() {
         return $this->attributes['password'];
    }

    function getPasswordAttribute() {
        return $this->attributes['password'];
    }

    function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

	// public function setUpasswordAttribute($value) {
	// 	$this->attributes['u_password'] = Hash::make($value);
	// }

	public function setFnameAttribute($value) {
		$this->attributes['u_fname'] 	= ucwords($value);
	}

	public function setMnameAttribute($value) {
		$this->attributes['u_mname'] 	= ucwords($value);
	}

	public function setLnameAttribute($value) {
		$this->attributes['u_lname'] 	= ucwords($value);
	}

	public function getFullNameAttribute($value) {		
		return ucfirst($this->u_fname).' '.ucfirst(substr($this->u_mname, 0, 1)).'. '.ucfirst($this->u_lname);
	}

	public function usergroup() {
        return $this->belongsTo(UserGroup::class, 'ug_id', 'ug_id');
    }
}

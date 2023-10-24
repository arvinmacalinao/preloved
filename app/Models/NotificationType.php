<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $table        = 'notification_types';
    protected $primaryKey   = 'not_type_id';
    protected $fillable     = [ 'not_type_id', 'not_type_name', 'created_at', 'updated_at' ];
    protected $timestamp    = [ 'created_at', 'updated_at' ];
}

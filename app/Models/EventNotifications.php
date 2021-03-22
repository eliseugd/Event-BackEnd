<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventNotifications extends Model
{
    use HasFactory;

	public $table = "event_notifications";

    protected $fillable = [
        'id',
		'id_user',
		'id_event',
		'title',
		'description',
		'viewer'
    ];
}

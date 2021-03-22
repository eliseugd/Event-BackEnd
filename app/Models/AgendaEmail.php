<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaEmail extends Model
{
    use HasFactory;
    
    public $table = "agenda_email";

    protected $fillable = [
        'id',
		'id_event',
		'assunto',
		'message',
    ];
}

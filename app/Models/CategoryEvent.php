<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEvent extends Model
{
    use HasFactory;

    public $table = "category_event";

    protected $fillable = [
        'id',
		'description',
    ];
}

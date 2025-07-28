<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagLog extends Model
{
    use HasFactory;
    public $timestamps = false;
    //protected $dates = ['data'];
    protected $casts = [
    'data' => 'date',
    ];
}

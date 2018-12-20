<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BolsaMatricula extends Model
{
	use SoftDeletes;
    protected $table  = 'bolsa_matriculas';
}

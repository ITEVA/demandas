<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChamadaUser extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'chamadas_users';
}

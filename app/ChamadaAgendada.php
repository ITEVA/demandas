<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChamadaAgendada extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'chamadas_agendadas';

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}

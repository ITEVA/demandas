<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'chamadas';

    public static function getEmpty(){
        return (object)[
            'data_inicio' => '',
            'data_fim' => '',
            'nome_requeridor' => '',
            'descricao' => '',
            'pessoas' => '',
        ];
    }

    public function categoria()
    {
        return $this->belongsTo('App\Categoria', 'id_categoria');
    }

    public function usuariosChamados()
    {
        return $this->hasMany('App\ChamadaUser', 'id_chamada');
    }
}

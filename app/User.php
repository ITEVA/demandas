<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'foto', 'nome', 'apelido', 'email', 'status', 'password', 'id_permissao', 'id_empregador'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getEmpty(){
        return (object)[
            'nome' => '',
            'apelido' => '',
            'email' => '',
            'password' => '',
            'foto' => 'default.jpg',
            'id_permissao' => '',
            'status' => '1'
        ];
    }

    public function permissao()
    {
        return $this->belongsTo('App\Permissao', 'id_permissao' );
    }
}

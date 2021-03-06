<?php

namespace App\Http\Controllers;

use App\Chamada;
use App\ChamadaAgendada;
use App\User;
use App\Permissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioController extends AbstractCrudController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $usuarios = User::where($this->getFilter())->get();
        $permissoes = Permissao::where($this->getFilter())->get();
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        return view('adm.inicio.paginaInicial')
            ->with('permissoes', $permissoes)
            ->with('usuarios', $usuarios)
            ->with('itensPermitidos', $itensPermitidos)
            ->with('chamadas', $chamadas)
            ->with('chamadasAgendadas', $chamadasAgendadas);
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}

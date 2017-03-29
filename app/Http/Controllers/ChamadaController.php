<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\ChamadaUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ChamadaRequest;
use App\Chamada;
use App\PermissaoClasse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ChamadaController extends AbstractCrudController
{
    private $filtro = [];

    public function __construct()
    {
        parent::__construct('auth');
    }

    public function novo()
    {
        $categorias = Categoria::where($this->getFilter())->get();
        $users = User::where(['id_empregador' => Auth::user()->id_empregador])->get();
        $idLogado = Auth::user()->id;

        return parent::novo()
            ->with('categorias', $categorias)
            ->with('users', $users)
            ->with('idLogado', $idLogado);
    }

    public function editar($id)
    {
        $categorias = Categoria::where($this->getFilter())->get();
        $users = User::where(['id_empregador' => Auth::user()->id_empregador])->get();
        $idLogado = Auth::user()->id;
        $usersChamados = ChamadaUser::where(['id_chamada'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();

        return parent::editar($id)
            ->with('categorias', $categorias)
            ->with('users', $users)
            ->with('idLogado', $idLogado)
            ->with('usersChamados', $usersChamados);
    }

    public function salvar(ChamadaRequest $request){

        $request['id_empregador'] = Auth::user()->id_empregador;

        $users = $request->usuarios;

        $request->offsetUnset('usuarios');
        $request->offsetUnset('salvar');

        try {
            $chamada = Chamada::create($this->formatOutput($request->except('_token')));
            $this->salvarUsariosChamados($users, $chamada->id);

            return redirect()
                ->action('ChamadaController@listar');

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array("Erro ao salvar chamada, tente novamente mais tarde"));
        }
    }

    public function atualizar(ChamadaRequest $request, $id){
        $request['id_empregador'] = Auth::user()->id_empregador;

        $users = $request->usuarios;

        $request->offsetUnset('usuarios');

        try {
            $this->removerUsuariosChamados($id);
            $dados = $this->salvarUsariosChamados($users, $id);

            return parent::atualizarDados($request, $id);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array($e->getMessage()));
        }
    }

    public function salvarUsariosChamados($users, $idChamada){
        foreach ($users as $user) {
            $dados = array(
                "id_usuario" => $user,
                "id_chamada" => $idChamada,
                "id_empregador" => Auth::user()->id_empregador
            );
            ChamadaUser::create($dados);
        }
    }

    public function removerUsuariosChamados($id){
        $users = ChamadaUser::where(['id_chamada'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();
        foreach ($users as $user) {
            $user->delete();
        }
    }

    protected function formatOutput($request)
    {
        $request['data_inicio'] = $this->formatarDataEn($request['data_inicio']);
        $request['data_fim'] = $this->formatarDataEn($request['data_fim']);

        return parent::formatOutput($request);
    }

    protected function formatInput($request)
    {
        $request->data_inicio = $this->formatarDataBr($request->data_inicio);
        $request->data_fim = $this->formatarDataBr($request->data_fim);

        return $request;
    }
}

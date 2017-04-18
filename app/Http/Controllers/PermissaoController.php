<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissaoRequest;
use App\Permissao;
use App\Chamada;
use App\ChamadaAgendada;
use App\PermissaoClasse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PermissaoController extends AbstractCrudController
{
    private $filtro = [];

    public function __construct()
    {
        parent::__construct('auth');
    }

    public function listar()
    {
        $permissoes = Permissao::where($this->getFilter())->get();
        $permissoesClasses = $this->buscarClasses($permissoes);
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        return parent::listar()
            ->with('permissoesClasses', $permissoesClasses)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('chamadas', $chamadas);
    }

    public function editar($id)
    {
        $permissoes = PermissaoClasse::where(['id_permissao'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        $permissoesAtuais = array();

        foreach ($permissoes as $permissao) {
            $permissoesAtuais[$permissao->classe] = 1;
        }

        return parent::editar($id)
            ->with('permissoesAtuais', $permissoesAtuais)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('chamadas', $chamadas);
    }

    public function salvar(PermissaoRequest $request)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        $dadosClasses['inicio'] = $request['inicio'];
        $dadosClasses['user'] = $request['user'];
        $dadosClasses['permissao'] = $request['permissao'];
        $dadosClasses['chamada'] = $request['chamada'];
        $dadosClasses['relatorio'] = $request['relatorio'];

        unset($request['inicio']);
        unset($request['user']);
        unset($request['permissao']);
        unset($request['chamada']);
        unset($request['relatorio']);

        if(isset($request['salvar'])) unset($request['salvar']);

        try {
            $dados = $this->formatOutput($request->except('_token'));
            $permicao = Permissao::create($dados);

            $this->salvarClassesPermissoes($dadosClasses, $permicao->id);

            return redirect()
                ->action('PermissaoController@listar');

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array('Erro ao salvar permissão. Tente mais tarde.'));
        }
    }

    public function atualizar(PermissaoRequest $request, $id)
    {
        $request['id_empregador'] = Auth::user()->id_empregador;

        try {
            $this->removerClassesPermissoes($id);
            $dados = $this->salvarClassesPermissoes($request, $id);

            return parent::atualizarDados($dados, $id);

        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(array($e->getMessage()));
        }
    }

    public function salvarClassesPermissoes($object, $id)
    {
        if($object['inicio']) {
            $permissao = array(
                'classe' => 'inicio',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['user']) {
            $user = array(
                'classe' => 'user',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($user);
        }

        if($object['permissao']) {
            $permissao = array(
                'classe' => 'permissao',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        if($object['chamada']) {
            $chamada = array(
                'classe' => 'chamada',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($chamada);
        }


        if($object['relatorio']) {
            $permissao = array(
                'classe' => 'relatorio',
                'id_permissao' => $id,
                'id_empregador' => Auth::user()->id_empregador
            );
            PermissaoClasse::create($permissao);
        }

        unset($object['inicio']);
        unset($object['user']);
        unset($object['permissao']);
        unset($object['chamada']);
        unset($object['relatorio']);

        return $object;
    }

    public function removerClassesPermissoes($id)
    {
        $permissoes = PermissaoClasse::where(['id_permissao'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();
        foreach ($permissoes as $permissao) {
            $permissao->delete();
        }
    }

    public function buscarClasses($permissoes)
    {
        foreach ($permissoes as $permissao) {
            $classes = $permissao->classesPermissao;
            foreach ($classes as $classe) {
                $nomeClasse = ucfirst (parent::pluralize(2, $classe->classe));
                $classe->classe = $this->verificaNomeClasse($nomeClasse);
            }
            $permissao['classes'] = $classes;
        }
        return $permissoes;
    }

    public function verificaNomeClasse($nome)
    {
        if($nome == "Inicios")
            return "Início";

        else if ($nome == "Users")
            return "Usuários";

        else if ($nome == "Permissoes")
            return "Permissões";

        else if ($nome == "Chamada")
            return "Chamada";

        else if ($nome == "Relatorios")
            return "Relatórios";

        else
            return $nome;
    }

    protected function formatOutput($request)
    {
        return parent::formatOutput($request);
    }

    protected function formatInput($request)
    {
        return parent::formatInput($request);
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\PermissaoClasse;
use App\Chamada;
use App\User;
use App\ChamadaAgendada;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

abstract class AbstractCrudController extends Controller
{
    /** @var string */
    protected $model;

    /** @var string */
    protected $view;

    /** @var  string */
    protected $class;

    /** @var  string */
    protected $requestType;

    public function __construct($auth = null)
    {
        if($auth === 'auth') $this->middleware('auth');
        
        $this->model = 'App\\' . $this->getName();
        $this->view = strtolower($this->pluralize(2, $this->getName()));
        $this->class = strtolower($this->getName());
        $this->requestType = $this->getName() . 'Request';
    }

    public function listar()
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();
        $usuarios = User::where($this->getFilter())->get();
        $chamadas = Chamada::where($this->getFilter())->get();

        $entity = $this->model;

        $entities = (count($this->getFilter()) ? $entity::where($this->getFilter())->get() : $entity::all());

        return view('adm.'.$this->view . '.listagem')
            ->with($this->view, $entities)
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('chamadas', $chamadas)
            ->with('chamadasAgendadas', $chamadasAgendadas);
    }

    public function novo()
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();
        $usuarios = User::where($this->getFilter())->get();
        $chamadas = Chamada::where($this->getFilter())->get();

        $entity = $this->model;
        $object = $entity::getEmpty();

        return view('adm.'.$this->view . '.formulario')
            ->with($this->class, $this->formatInput($object))
            ->with('action', $this->view . '/salvar')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('chamadas', $chamadas)
            ->with('usuarios', $usuarios);
    }

    public function editar($id)
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();
        $usuarios = User::where($this->getFilter())->get();
        $chamadas = Chamada::where($this->getFilter())->get();

        eval('$object=' . $this->model . '::find($id);');
        return view('adm.'.$this->view . '.formulario')
            ->with($this->class, $this->formatInput($object))
            ->with('action', $this->view . '/atualizar/' . $id)
            ->with('itensPermitidos', $itensPermitidos)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('chamadas', $chamadas)
            ->with('usuarios', $usuarios);
    }

    protected function salvarDados($request)
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');

        if(isset($request['salvar'])) unset($request['salvar']);
        $dados = $this->formatOutput($request->except('_token'));
        eval($this->model . '::create($dados);');

        return redirect()
            ->action($this->getName() . 'Controller@listar');
    }

    protected function atualizarDados($request, $id)
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');

        if(isset($request['salvar'])) unset($request['salvar']);
        eval('$object=' . $this->model . '::find($id);');
        $dados = $this->formatOutput($request->except('_token'));
        $object->fill($dados);
        $object->save();

        return redirect()
            ->action($this->getName() . 'Controller@listar');
    }

    public function editarLote(Request $request)
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $entity = $this->model;
        $object = $entity::getEmpty();

        $form = $request->all();

        return view('adm.'.$this->view . '.formulario')
            ->with($this->class, $this->formatInput($object))
            ->with('action', $this->view . '/atualizarLote')
            ->with('ids', $form['ids'])
            ->with('itensPermitidos', $itensPermitidos);
    }

    public function atualizarLote(Request $request)
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');

        $request = $this->formatOutput($request->except('_token'));
        $entity = $this->model;
        $ids = explode('-', $request['ids']);
        $dados = array();
        foreach ($request as $key => $value) {
            if ($key !== "_token" && $key !== "ids" && $key !== "salvar" && $value !== "") {
                $dados[$key] = $value;
            }
        }

        foreach ($ids as $id) {
            if (is_numeric($id)) {
                try {
                    $object =  $entity::find($id);
                    $object->fill($dados);
                    $object->save();
                } catch (QueryException $e) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(array($e->getMessage()));
                }
            }
        }

        return redirect()
            ->action($this->getName() . 'Controller@listar');

    }

    public function removerLote(Request $request)
    {
        if($this->checkStatus()) return redirect('sair');
        if($this->checkPermissao()) return redirect('error404');

        $strIds = $request->all();
        $ids = explode('-', $strIds['ids']);

        foreach ($ids as $id) {
            if (is_numeric($id)) {
                eval('$object=' . $this->model . '::find($id);');
                $this->removerFoto($object);
                $object->delete();
            }
        }
        return redirect()
            ->action($this->getName() . 'Controller@listar');
    }

    protected function getName()
    {
        $path = explode('\\', get_class($this));
        return str_replace("Controller", "", array_pop($path));
    }

    protected function pluralize($quantity, $singular, $plural = null)
    {
        if ($quantity == 1 || !strlen($singular)) return $singular;
        if ($plural !== null) return $plural;

        $last_letter = strtolower($singular[strlen($singular) - 1]);
        $penultimate_letter = strtolower($singular[strlen($singular) - 2]);

        if ($penultimate_letter == 'a' && $last_letter) {
            return substr($singular, 0, -2) . 'oes';
        }
        else {
            switch ($last_letter) {
                case 'y':
                    return substr($singular, 0, -1) . 'ies';
                case 's':
                    return $singular . 'es';
                default:
                    return $singular . 's';
            }
        }
    }

    protected function getClassesPermissao($id)
    {
        $permissoes = PermissaoClasse::where(['id_permissao'=>$id, 'id_empregador' => Auth::user()->id_empregador])->get();

        $itensPermitidos = array();

        foreach ($permissoes as $permissao) {
            $itensPermitidos[$permissao->classe] = 1;
        }

        return $itensPermitidos;
    }

    /**
     * Checa se o usuario logado tem permissão para acessar a classe solicitada
     * @return ctrl permissao concedida ou não
     */
    protected function checkPermissao()
    {
        $permissoes = PermissaoClasse::where(['classe'=>$this->class, 'id_empregador' => Auth::user()->id_empregador])->get();
        $i = 0;
        $ctrl = true;
        foreach ($permissoes as $permissao){
            if (Auth::user()->permissao->id == $permissao->id_permissao) {
                $ctrl = false;
            }
            $i++;
        }

        return $ctrl;
    }

    /**
     * Checa se o usuario logado é ativo
     * @return boolean
     */
    protected function checkStatus() {
        if (Auth::user()->status == 0)
            return true;
    }

    /**
     * Excluir as fotos da pasta
     * @param $id
     */
    protected function removerFoto($object)
    {
        return ;
    }

    /**
     * Retorna a data local atual no formato yyyy-mm-dd
     * @return string
     */
    protected function dataAtualEn()
    {
        date_default_timezone_set('America/Fortaleza');
        return date('Y-m-d');
    }

    /**
     * Retorna a data local atual no formato dd-mm-yyyy
     * @return string
     */
    protected function dataAtualBr()
    {
        date_default_timezone_set('America/Fortaleza');
        return date('d/m/Y');
    }

    /**
     * Retorna a data local atual no formato dd-mm-yyyy
     * @return string
     */
    protected function mesAtualBr()
    {
        date_default_timezone_set('America/Fortaleza');
        return date('M');
    }

    /**
     * Retorna a hora local atual no hh:mm
     * @return string
     */
    protected function horaAtual()
    {
        date_default_timezone_set('America/Fortaleza');
        return date('H:i:s');
    }

    /**
     * Retorna o dia da semana correpondente a data
     * @param $data no formato americano
     * @return string
     */
    protected function diaSemana($data)
    {
        $diaSemana = date("N", strtotime($data));
        if($diaSemana == 1)
            return "Segunda-Feira";
        else if($diaSemana == 2)
            return "Terça-Feira";
        else if($diaSemana == 3)
            return "Quarta-Feira";
        else if($diaSemana == 4)
            return "Quinta-Feira";
        else if($diaSemana == 5)
            return "Sexta-Feira";
        else if($diaSemana == 6)
            return "Sábado";
        else
            return "Domingo";
    }

    /**
     * Recebe um valor double no formato 1.000,99 e retorna no formato 1000.99
     * @param $valor
     * @return string
     */
    protected function formatarNumeroEn($valor)
    {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }

    /**
     * Recebe um valor double no formato 1,000.99 e retorna no formato 1.000,99
     * @param $valor
     * @return string
     */
    protected function formatarNumeroBr($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    /**
     * Recebe uma string de data no formato dd/mm/yyyy e retorna no formato yyyy-mm-dd
     * @param $dataBr
     * @return string
     */
    protected function formatarDataEn($dataBr)
    {
        $date = implode("-",array_reverse(explode("/", $dataBr)));
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Recebe uma string de data no formato yyyy-mm-dd e retorna no formato dd/mm/yyyy
     * @param $dataEn
     * @return string
     */
    protected function formatarDataBr($dataEn)
    {
        $date = implode("/",array_reverse(explode("-", $dataEn)));
        return $date;
    }

    /**
     * Formatação de dados para serem inseridos no sistema
     * @param $request
     * @return dados formatados
     */
    protected function formatOutput($request)
    {
        return $request;
    }

    /**
     * Formatação de dados para serem inseridos no formulario
     * @param $request
     * @return dados formatados
     */
    protected function formatInput($request)
    {
        return $request;
    }

    /**
     * Retorna um array com o filtro que será utilizado nas pesquisas
     */
    protected function getFilter()
    {
        return [];
    }
    
    protected function removeMask($mask, $value)
    {
        foreach ($mask as $k => $v) $value = str_replace($k, $v, $value);
        return $value;
    }
}

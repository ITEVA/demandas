<?php

namespace App\Http\Controllers;

use App\Chamada;
use App\ChamadaUser;
use App\Permissao;
use Illuminate\Http\Request;
use App\User;
use App\Pedido;
use App\ChamadaAgendada;
use App\ProdutoPedido;
use Illuminate\Support\Facades\Auth;
use Anouar\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;

class RelatorioController extends AbstractCrudController
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

    protected function listarUsuarios()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $usuarios = User::where(['id_empregador' => Auth::user()->id_empregador, 'id_permissao' => Auth::user()->permissao->id])->get();
        $permissoes = Permissao::where($this->getFilter())->get();
        $permissaoAnt = Auth::user()->permissao->id;
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        return view('adm.relatorios.usuarios')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('permissoes', $permissoes)
            ->with('permissaoAnt', $permissaoAnt)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('chamadas', $chamadas);
    }

    protected function listarFiltroUsuarios(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $usuarios = User::where(['id_empregador' => Auth::user()->id_empregador, 'id_permissao' => $request->permissao])->get();
        $permissoes = Permissao::where($this->getFilter())->get();
        $permissaoAnt = $request->permissao;
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        return view('adm.relatorios.usuarios')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('permissoes', $permissoes)
            ->with('permissaoAnt', $permissaoAnt)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('chamadas', $chamadas);
    }

    protected function imprimirUsuarios(Request $request)
    {
        $usuarios = User::where(['id_empregador' => Auth::user()->id_empregador, 'id_permissao' => $request->permissao])->get();
        $dataEn = parent::dataAtualEn();
        $dataBr = parent::dataAtualBr();
        $diaSemana = parent::diaSemana($dataEn);

        //Criando o objeto de PDF e inicializando suas configurações
        $pdf = new FPDF("P", "pt", "A4");

        $pdf->SetTitle('Relatório Usuários');

        //Adiciona uma nova pagina para cada colaborador
        $pdf->AddPage();

        //Desenha o cabeçalho do relatorio
        $pdf->Image('adm/images/logo.png');
        $pdf->SetXY(225, 80);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(595, 14, $dataBr . ' ' . $diaSemana, 0, 0, "C");
        $pdf->Line(20, 100 , 575, 100);

        $pdf->SetXY(0, 115);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(595, 14, "RELATÓRIO DE USUÁRIOS DIA: " . $dataBr, 0, 0, "C");

        //Tabela total de produtos
        $pdf->SetXY(20, 145);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(278, 20, 'Usuários', 1, 0, "C");
        $pdf->Cell(278, 20, 'Permissões', 1, 0, "C");

        //linhas da tabela
        $pdf->SetFont('arial', '', 10);
        if(count($usuarios) > 0) {
            $pdf->SetY($pdf->GetY() + 20);
            foreach ($usuarios as $usuario) {
                $pdf->SetX(20);
                $pdf->Cell(278, 14, $usuario->nome, 1, 0, "C");
                $pdf->Cell(278, 14, $usuario->permissao->nome, 1, 0, "C");
                $pdf->SetY($pdf->GetY() + 14);
            }
        }

        //Rodape
        $pdf->SetAutoPageBreak(5);
        $pdf->SetFont('arial', '', 10);
        $pdf->SetXY(20, -45);
        $pdf->Cell(555, 15, "Rodovia CE - 040 s/n - Aquiraz - CE - cep 61.700-000 - cx. postal 66 - fone (85) 3362-3210 - e-mail iteva@iteva.org.br", 'T', 0, 'C');
        $pdf->SetXY(20, -30);
        $pdf->Cell(555, 15, "www.iteva.org.br", 0, 0, 'C');

        $pdf->Output();
        exit;
    }

    protected function listarChamadas()
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $users = User::where(['id_empregador' => Auth::user()->id_empregador])->get();
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        $usuarioFiltrado = 'geral';

        return view('adm.relatorios.chamadas')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('users', $users)
            ->with('chamadas', $chamadas)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('usuarioFiltrado', $usuarioFiltrado);
    }

    protected function listarFiltroChamadas(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $users = User::where(['id_empregador' => Auth::user()->id_empregador])->get();
        $chamadas = Chamada::where($this->getFilter())->get();
        $chamadasAgendadas = ChamadaAgendada::where($this->getFilter())->get();

        if($request->usuarios == 'geral')
            $chamadas = Chamada::where($this->getFilter())->get();

        else {
            $chamadasUsers = ChamadaUser::where(['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => $request->usuarios])->get();
            $idsFiltro = array();
            $i = 0;

            foreach ($chamadasUsers as $chamadaUser){
                $idsFiltro[$i++] = $chamadaUser->id_chamada;
            }

            $chamadas = Chamada::where(['id_empregador' => Auth::user()->id_empregador])->whereIn('id', $idsFiltro)->get();
        }

        $usuarioFiltrado = $request->usuarios;

        return view('adm.relatorios.chamadas')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('users', $users)
            ->with('chamadas', $chamadas)
            ->with('chamadasAgendadas', $chamadasAgendadas)
            ->with('usuarioFiltrado', $usuarioFiltrado);
    }

    protected function imprimirChamadas(Request $request)
    {
        $users = User::where(['id_empregador' => Auth::user()->id_empregador])->get();
        $userFilter = User::where(['id_empregador' => Auth::user()->id_empregador, 'id' => $request->usuarios])->get();
        $userName = $request->usuarios === "geral" ? 'Geral' : $userFilter[0]->nome;

        if($request->usuarios == 'geral')
            $chamadas = Chamada::where($this->getFilter())->get();

        else {
            $chamadasUsers = ChamadaUser::where(['id_empregador' => Auth::user()->id_empregador, 'id_usuario' => $request->usuarios])->get();
            $idsFiltro = array();
            $i = 0;

            foreach ($chamadasUsers as $chamadaUser){
                $idsFiltro[$i++] = $chamadaUser->id_chamada;
            }

            $chamadas = Chamada::where(['id_empregador' => Auth::user()->id_empregador])->whereIn('id', $idsFiltro)->get();
        }

        foreach ($chamadas as $chamada){
            $chamada->pessoas = "";
            foreach ($chamada->usuariosChamados as $a) {
                $chamada->pessoas = $chamada->pessoas.$a->usuario->apelido."\n";
            }
        }

        
        date_default_timezone_set('America/Sao_Paulo');
        $dataEn = parent::dataAtualEn();
        $dataBr = parent::dataAtualBr();
        $diaSemana = parent::diaSemana($dataEn);
        $mesAtual = parent::mesAtualBr();

        //Criando o objeto de PDF e inicializando suas configurações
        $pdf = new FPDF("P", "pt", "A4");

        $pdf->SetTitle('Relatório de Chamadas');

        //Adiciona uma nova pagina para cada colaborador
        $pdf->AddPage();

        //Desenha o cabeçalho do relatorio
        $pdf->Image('adm/images/logo.png');
        $pdf->SetXY(225, 80);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(595, 14, $mesAtual, 0, 0, "C");
        $pdf->Line(20, 110 , 575, 110);

        $pdf->SetXY(0, 115);
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(595, 14, "RELATÓRIO DE CHAMADAS: " . $userName , 0, 0, "C");

        $pdf->SetXY(20, 135);
        $pdf->Cell(80, 20, 'Data', 1, 0, "C");
        $pdf->Cell(90, 20, 'Nome requeridor', 1, 0, "C");
        $pdf->Cell(150, 20, 'Pessoa(s)', 1, 0, "C");
        $pdf->Cell(150, 20, 'Categoria', 1, 0, "C");
        $pdf->Cell(80, 20, 'Tempo', 1, 0, "C");

        if(count($chamadas) > 0) {
            $pdf->SetY($pdf->GetY() + 20);
            $totalHoras = 0;
            $totalMin = 0;
            $minFinal = 0;
            foreach ($chamadas as $chamada) {
                $data =  parent::formatarDataBr($chamada->data_inicio);

                $partesF = explode(':', $chamada->hora_fim);
                $partesI = explode(':', $chamada->hora_inicio);

                $horaF = $partesF[0];
                $minF = $partesF[1];

                $horaI = $partesI[0];
                $minI = $partesI[1];

                $horaFinal = ((($horaF - $horaI) < 10) ? '0' : '').($horaF - $horaI);

                if(($minF < $minI)) {
                    $minFinal = (($minF - $minI) + 60);
                    $horaFinal = ((($horaF - $horaI) < 10) ? '0' : '').(($horaF - $horaI) - 1);
                }

                else{
                    $minFinal = ((($minF - $minI) < 10) ? '0' : '') . ($minF - $minI);
                }

                $total = ($horaFinal.':'.$minFinal.':00h');

                $nomesQ = explode("\n", $chamada->pessoas);

                $pdf->SetX(20);
                $pdf->Cell(80, 14, $data, 'T, L, R', 0, "C");
                $pdf->Cell(90, 14, $chamada->nome_requeridor, 'T, L, R', 0, "C");
                $pdf->Cell(150, 14, $nomesQ[0], 'T, L, R', 0, "C");
                $pdf->Cell(150, 14, $chamada->categoria->nome, 'T, L, R', 0, "C");
                $pdf->Cell(80, 14, $total, 'T, L, R', 0, "C");
                $pdf->SetY($pdf->GetY() + 14);

                for ($i = 1; $i < count($nomesQ); $i++) {
                    $pdf->SetX(20);
                    $pdf->Cell(80, 14, "", 'L, R', 0, "C");
                    $pdf->Cell(90, 14, "", 'L, R', 0, "C");
                    $pdf->Cell(150, 14, $nomesQ[$i], 'L, R', 0, "C");
                    $pdf->Cell(150, 14, "", 'L, R', 0, "C");
                    $pdf->Cell(80, 14, "", 'L, R', 0, "C");
                    $pdf->SetY($pdf->GetY() + 14);
                }

                $totalHoras = $totalHoras + $horaFinal;
                $totalMin = $totalMin + $minFinal;
            }

            while($totalMin > 60){
                $totalMin = $totalMin - 60;
                $totalHoras++;
            }

            $pdf->SetXY(20,$pdf->GetY());
            $pdf->Cell(100, 20, '', 'T', 0, "C");
            $pdf->Cell(220, 20, '', 'T', 0, "C");
            $pdf->Cell(150, 20, 'Total',1, 0, "C");
            $pdf->Cell(80, 20, ($totalHoras.':'.$totalMin.':00h'), 1, 0, "C");
        }

        //Rodape
        $pdf->SetAutoPageBreak(5);
        $pdf->SetFont('arial', '', 10);
        $pdf->SetXY(20, -45);
        $pdf->Cell(555, 15, "Rodovia CE - 040 s/n - Aquiraz - CE - cep 61.700-000 - cx. postal 66 - fone (85) 3362-3210 - e-mail iteva@iteva.org.br", 'T', 0, 'C');
        $pdf->SetXY(20, -30);
        $pdf->Cell(555, 15, "www.iteva.org.br", 0, 0, 'C');

        $pdf->Output();
        exit;
    }

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
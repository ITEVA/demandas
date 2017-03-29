<?php

namespace App\Http\Controllers;

use App\Permissao;
use Illuminate\Http\Request;
use App\User;
use App\Pedido;
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

        return view('adm.relatorios.usuarios')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('permissoes', $permissoes)
            ->with('permissaoAnt', $permissaoAnt);
    }

    protected function listarFiltroUsuarios(Request $request)
    {
        if($this->checkPermissao()) return redirect('error404');
        $itensPermitidos = $this->getClassesPermissao(Auth::user()->permissao->id);

        $usuarios = User::where(['id_empregador' => Auth::user()->id_empregador, 'id_permissao' => $request->permissao])->get();
        $permissoes = Permissao::where($this->getFilter())->get();
        $permissaoAnt = $request->permissao;

        return view('adm.relatorios.usuarios')
            ->with('itensPermitidos', $itensPermitidos)
            ->with('usuarios', $usuarios)
            ->with('permissoes', $permissoes)
            ->with('permissaoAnt', $permissaoAnt);
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

    protected function getFilter()
    {
        return ['id_empregador' => Auth::user()->id_empregador];
    }
}
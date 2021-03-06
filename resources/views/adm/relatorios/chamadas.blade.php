@extends('adm.layout.adm')
@section('css')
    <!-- Custom styling plus plugins -->
    <link href="adm/css/custom.css" rel="stylesheet">
    <link href="adm/css/icheck/flat/green.css" rel="stylesheet">
    <link href="adm/css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
@endsection
@section('conteudo')
    <div class="">
        <div class="row conteudoPrincipal">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_title">
                        <h2>Chamadas cadastradas no sistema</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <form method="POST" action="relatorios/chamadas" enctype="multipart/form-data" id="filtro" data-parsley-validate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                <label>Pessoa*</label>
                                <select name="usuarios" class="select2_single form-control">
                                    <option {{(isset($ids) ? 'selected="selected"' : "")}} value="">Selecione uma pessoa
                                    </option>
                                    @if (count($users) > 0)
                                        <option {{$usuarioFiltrado == 'geral' ? 'selected= "selected" ' : ''}} value="geral">Geral
                                        </option>
                                        @foreach ($users as $user)
                                            <option {{$user->id == old('user') || $usuarioFiltrado == $user->id ? 'selected="selected"' : ''}}
                                                    value="{{$user->id}}">{{$user->nome}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-lg-3 col-md-5 col-xs-12">
                                <label>Mês*</label>
                                <select name="mes" class="select2_single form-control" required>
                                    <option {{!isset($mesSelecionado) ? 'selected = selected' : ''}} value="">Selecione um mês</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 0 ? 'selected = selected' : '') : ''}} value="0">Geral</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 1 ? 'selected = selected' : '') : ''}} value="1">Janeiro</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 2 ? 'selected = selected' : '') : ''}} value="2">Fevereiro</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 3 ? 'selected = selected' : '') : ''}} value="3">Março</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 4 ? 'selected = selected' : '') : ''}} value="4">Abril</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 5 ? 'selected = selected' : '') : ''}} value="5">Maio</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 6 ? 'selected = selected' : '') : ''}} value="6">Junho</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 7 ? 'selected = selected' : '') : ''}} value="7">Julho</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 8 ? 'selected = selected' : '') : ''}} value="8">Agosto</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 9 ? 'selected = selected' : '') : ''}} value="9">Setembro</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 10 ? 'selected = selected' : '') : ''}} value="10">Outubro</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 11 ? 'selected = selected' : '') : ''}} value="11">Novembro</option>
                                    <option {{isset($mesSelecionado) ? ($mesSelecionado == 12 ? 'selected = selected' : '') : ''}} value="12">Dezembro</option>
                                </select>
                            </div>


                            <div class="form-group col-md-3 col-xs-12 quebrarDiv">
                                <input type="submit" name="filtrar" class="btn btn-success" value="Filtrar"/>
                                <input type="button" id="imprimirChamadas" name="imprimir" class="btn btn-success" value="Imprimir"/>
                            </div>
                        </form>

                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                            <tr class="headings">
                                <th id="checkboxs">
                                    <input type="checkbox" id="check-all" class="tableflat">
                                </th>
                                <th>Data</th>
                                <th>Requeridor</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Visualizar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($chamadas) > 0)
                                @foreach($chamadas as $chamada)
                                    <tr class="even pointer">
                                        <td class="a-center ">
                                            <input type="checkbox" id="row{{$chamada->id}}" class="tableflat">
                                        </td>
                                        <td>{{$chamada->data_inicio}}</td>
                                        <td>{{$chamada->nome_requeridor}}</td>
                                        <td>{{$chamada->descricao}}</td>
                                        <td>{{$chamada->categoria->nome}}</td>
                                        <td><i class="fa fa-search detalhesChamada" iid="{{$chamada->id}}" style="cursor: pointer"></i></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="iconeListagem">Nenhuma chamada encontrada</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <form id="formSelecionados" method="post" action="">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                            <input type="hidden" name="ids" id="ids" value=""/>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="alertRemover" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Remover registro</h4>
                            </div>
                            <div class="modal-body">
                                <p>Você deseja excluir este(s) registro(s)?</p>
                                <input type="hidden" id="tipoRemocao" value="" />
                            </div>
                            <div class="modal-footer">
                                <button id="confirmarRemocao" type="button" class="btn btn-danger">Sim</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                @foreach($chamadas as $chamada)
                    <div class="modal fade" id="detalhesChamadas{{$chamada->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Detalhes Chamada</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="list-group">
                                        <h4 class="list-group-item-heading">Data</h4>
                                        <p class="list-group-item-text">{{date("d/m/Y", strtotime($chamada->data_inicio))}}</p>
                                    </div>

                                    <div class="list-group">
                                        <h4 class="list-group-item-heading">Requeridor</h4>
                                        <p class="list-group-item-text">{{$chamada->nome_requeridor}}</p>
                                    </div>

                                    <div class="list-group">
                                        <h4 class="list-group-item-heading">Descrição</h4>
                                        <p class="list-group-item-text">{{$chamada->descricao}}</p>
                                    </div>

                                    <div class="list-group">
                                        <h4 class="list-group-item-heading">Categoria</h4>
                                        <p class="list-group-item-text">{{$chamada->categoria->nome}}</p>
                                    </div>

                                    <div class="list-group">
                                        <h4 class="list-group-item-heading">Pessoa(s)</h4>
                                        @foreach($chamada->usuariosChamados as $user)
                                            <p class="list-group-item-text">{{$user->usuario->nome}}</p>
                                        @endforeach
                                    </div>

                                    <input type="hidden" id="tipoRemocao" value="" />
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                @endforeach
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="adm/js/relatorios.js"></script>
    <script src="adm/js/chamadas.js"></script>


    <!-- Datatables -->
    <script src="adm/js/datatables/js/jquery.dataTables.js"></script>
    <script src="adm/js/datatables/tools/js/dataTables.tableTools.js"></script>

    <script src="adm/js/datatables/js/formatoDataBr.js"></script>

    <!-- pace -->
    <script src="adm/js/pace/pace.min.js"></script>

    <!-- Listagem -->
    <script src="adm/js/listagem.js"></script>

    <script>
        $('input.tableflat').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        var asInitVals = new Array();
        var oTable = $('#example').dataTable({
            "bPaginate": false,
            "order": [[1, "asc"]],
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar: ",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "aoColumnDefs": [
                {'bSortable': false,
                    'aTargets': [0]},

                {'bSortable': true,
                    'aTargets': [1],
                    render: $.fn.dataTable.render.moment( 'DD/MM/YYYY' )},
                {'bSortable': false,
                    'aTargets': [6]}
            ],
            'iDisplayLength': 10,
            "sPaginationType": "full_numbers"
        });
        $("tfoot input").keyup(function () {
            /* Filter on the column based on the index of this element's parent <th> */
            oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
        });
        $("tfoot input").each(function (i) {
            asInitVals[i] = this.value;
        });
        $("tfoot input").focus(function () {
            if (this.className == "search_init") {
                this.className = "";
                this.value = "";
            }
        });
        $("tfoot input").blur(function (i) {
            if (this.value == "") {
                this.className = "search_init";
                this.value = asInitVals[$("tfoot input").index(this)];
            }
        });

        $('.iCheck-helper').click(function(){
            if($(this).parent().parent().attr('id') === "checkboxs"){
                $('.iCheck-helper').each(function(){
                    if($(this).parent().parent().attr('id') !== "checkboxs") {
                        $(this).click();
                    }
                });
            }
        });
    </script>
@endsection
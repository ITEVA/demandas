@extends('adm.layout.adm')
@section('css')
    <link href="adm/css/permissoes.css" rel="stylesheet">
    <link href="adm/css/select/select2.min.css" rel="stylesheet" type="text/css">
@endsection
@section('conteudo')
    <div class="row conteudoPrincipal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cadastro de Chamadas</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start form for validation -->
                    <form method="POST" action="{{$action}}" enctype="multipart/form-data" id="demo-form"
                          data-parsley-validate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        @if(isset($ids))
                            <input type="hidden" name="ids" value="{{$ids}}"/>
                        @endif
                        @if (count($errors) > 0)
                            <ul style="color: red;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="form-group col-md-5 col-xs-12">
                            <label for="nome">Data Início*</label>
                            <input type="text" class="form-control date date-picker" name="data_inicio"
                                   value="{{old('data_inicio') !== null ? old('data_inicio') : $chamada->data_inicio}}"/>
                        </div>

                        <div class="form-group col-md-5 col-xs-12">
                            <label for="nome">Data Fim*</label>
                            <input type="text" class="form-control date date-picker" name="data_fim"
                                   value="{{old('data_fim') !== null ? old('data_fim') : $chamada->data_fim}}"/>
                        </div>

                        <div class="form-group col-md-5 col-xs-12">
                            <label for="nome">Requeridor*</label>
                            <input type="text" class="form-control" name="nome_requeridor"
                                   value="{{old('nome_requeridor') !== null ? old('nome_requeridor') : $chamada->nome_requeridor}}"/>
                        </div>

                        <div class="form-group col-md-5 col-xs-12">
                            <label>Categoria*</label>
                            <select name="id_categoria" class="form-control select2 select2-container">
                                <option {{(isset($ids) ? 'selected="selected"' : "")}} value="">Selecione uma categoria
                                </option>
                                @if (count($categorias) > 0)
                                    @foreach ($categorias as $categoria)
                                        <option {{$categoria->id == old('categoria') || (old('categoria') === null) ? 'selected="selected"' : ''}}
                                                value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div class="form-group col-md-5 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pessoas*</label>
                                <select id="produtos" class="select2_multiple form-control" multiple="multiple" name="usuarios[]">
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                            @if(isset($usersChamados))
                                                @foreach($usersChamados as $usersChamado)
                                                    @if($user->id == $usersChamado->id_usuario)
                                                        <option selected="selected" value="{{$user->id != old('user') ? $user->id : '' }}">{{$user->nome}}</option>
                                                    @else
                                                        <option value="{{$user->id != old('user') ? $user->id : '' }}">{{$user->nome}}</option>
                                                    @endif
                                                @endforeach

                                            @else
                                                <option {{$idLogado == $user->id ? 'selected="selected"' : ''}}
                                                        value="{{$user->id != old('user') ? $user->id : '' }}">{{$user->nome}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                        </div>

                        <div class="form-group col-md-5 col-xs-12 quebrarDiv">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" name="descricao">{{old('descricao') !== null ? old('descricao') : $chamada->descricao}}</textarea>
                        </div>

                        <div class="ln_solid col-md-12 col-xs-12"></div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success">
                            <a href="chamadas">Voltar</a>
                        </div>
                        <div class="form-group  col-md-12 col-xs-12">
                            <p></p>
                        </div>
                    </form>
                    <!-- end form for validations -->
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $('input.permissao').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>
    <!-- select2 -->
    <script src="adm/js/select/select2.full.js"></script>
    <!-- form validation -->
    <!-- select2 -->
    <script>
        $(document).ready(function() {
            $(".select2_single").select2({
                placeholder: "Select a state",
                allowClear: true
            });
            $(".select2_group").select2({});
            $(".select2_multiple").select2({
                maximumSelectionLength: 1000,
                placeholder: "Selecione as pessoas",
                allowClear: true
            });
        });
    </script>
    <!-- /select2 -->
@endsection
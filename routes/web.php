<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/sair', 'Auth\LoginController@logout');

//Error 404 página não encontrada;
Route::get('/error404', function()
{
    return view('errors.error404');
});

Route::get('/', 'InicioController@index');
Route::get('/home', 'InicioController@index');

//Rotas para gestão de usuários
Route::get('/users', 'UserController@listar');
Route::get('/users/novo', 'UserController@novo');
Route::post('/users/salvar', 'UserController@salvar');
Route::get('/users/editar/{id}', 'UserController@editar');
Route::post('/users/atualizar/{id}', 'UserController@atualizar');
Route::post('/users/removerLote', 'UserController@removerLote');
Route::post('/users/editarLote', 'UserController@editarLote');
Route::post('/users/atualizarLote', 'UserController@atualizarLote');
Route::get('/users/editarPerfil/{id}', 'UserController@editarPerfil');
Route::post('/users/atualizarPerfil/{id}', 'UserController@atualizarPerfil');

//Rotas para gestão de permissões
Route::get('/permissoes', 'PermissaoController@listar');
Route::get('/permissoes/novo', 'PermissaoController@novo');
Route::post('/permissoes/salvar', 'PermissaoController@salvar');
Route::get('/permissoes/editar/{id}', 'PermissaoController@editar');
Route::post('/permissoes/atualizar/{id}', 'PermissaoController@atualizar');
Route::post('/permissoes/removerLote', 'PermissaoController@removerLote');
Route::post('/permissoes/editarLote', 'PermissaoController@editarLote');
Route::post('/permissoes/atualizarLote', 'PermissaoController@atualizarLote');

//Rotas para gestão de relatórios
Route::get('/relatorios/usuarios', 'RelatorioController@listarUsuarios');
Route::post('/relatorios/usuarios', 'RelatorioController@listarFiltroUsuarios');
Route::post('/relatorios/usuarios/imprimir', 'RelatorioController@imprimirUsuarios');

Route::get('/relatorios/chamadas', 'RelatorioController@listarChamadas');
Route::post('/relatorios/chamadas', 'RelatorioController@listarFiltroChamadas');
Route::post('/relatorios/chamadas/imprimir', 'RelatorioController@imprimirChamadas');

//Rotas para gestão de chamadas
Route::get('/chamadas', 'ChamadaController@listar');
Route::get('/chamadas/novo', 'ChamadaController@novo');
Route::post('/chamadas/salvar', 'ChamadaController@salvar');
Route::get('/chamadas/editar/{id}', 'ChamadaController@editar');
Route::post('/chamadas/atualizar/{id}', 'ChamadaController@atualizar');
Route::post('/chamadas/saida/{id}', 'ChamadaController@saida');
Route::post('/chamadas/removerLote', 'ChamadaController@removerLote');

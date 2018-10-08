<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('public');
});
Route::prefix('provincia')->group(function(){
	Route::name('provincia.list')->get('/', ['uses' => 'ComuneController@list']);
	Route::name('provincia.comune')->get('/{provincia_id}/comune/{comune_id}', ['uses' => 'ComuneController@list']);
	Route::name('provincia.comune.loadList')->get('/{provincia_id}/', ['uses' => 'ComuneController@loadComuneList']);
	Route::name('provincia.comune.update')->put('/{provincia_id}/comune/{comune_id}', ['uses' => 'ComuneController@update']);
	Route::get('/load', ['as' => 'load', 'uses' => 'ComuneController@loadComunes']);
	Route::get('/get', ['as' => 'get', 'uses' => 'ComuneController@getComunes']);
});
Route::prefix('cliente')->group(function(){
	Route::name('cliente.list')->get('/', ['uses' => 'ClienteController@list']);
	Route::name('cliente.add')->get('/novo', ['uses' => 'ClienteController@add']);
	Route::name('cliente.add')->put('/novo', ['uses' => 'ClienteController@store']);
});
Route::get('/home', function()
{
	return View::make('home');
});
Route::prefix('buscas')->group(function(){
	Route::name('busca.list')->get('/', ['uses' => 'BuscasController@list']);
	Route::name('busca.add')->get('/novo', ['uses' => 'BuscasController@add']);
	Route::name('busca.add')->put('/novo', ['uses' => 'BuscasController@store']);
	Route::name('busca.edit')->get('/{busca_id}/edit', ['uses' => 'BuscasController@edit']);
	Route::prefix('/{busca_id}/documento')->group(function(){
		Route::name('busca.documento.list')->get('/', ['uses' => 'DocumentosController@list']);
		Route::name('busca.documento.add')->get('/novo', ['uses' => 'DocumentosController@add']);
		Route::name('busca.documento.add')->put('/novo', ['uses' => 'DocumentosController@store']);
		Route::name('busca.documento.edit')->get('/{documento_id}/edit', ['uses' => 'DocumentosController@edit']);
		Route::name('busca.documento.iniciar')->put('/{documento_id}/iniciarbusca', ['uses' => 'DocumentosController@iniciar']);
		Route::prefix('/{documento_id}/requisicao')->group(function(){
			Route::name('busca.documento.requisicao.edit')->get('/{requisicao_id}/edit', ['uses' => 'RequisicoesController@edit']);
			Route::name('busca.documento.requisicao.update')->put('/{requisicao_id}/update', ['uses' => 'RequisicoesController@update']);
			Route::name('busca.documento.requisicao.addcoment')->post('/{requisicao_id}/addcoment', ['uses' => 'RequisicoesController@addcoment']);
		});
	});
});
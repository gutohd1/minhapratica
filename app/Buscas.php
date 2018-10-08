<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buscas extends Model{
    
    protected $table = 'buscas';
	public $primaryKey = 'id';

    function getCliente(){
        $this->cliente = $this->hasMany('App\Clientes','id','idcliente')->first();
    }
    function getDocumentos(){
        $this->documentos = $this->hasMany('App\buscasdocumentos','idbusca','id')->get();
    }
}

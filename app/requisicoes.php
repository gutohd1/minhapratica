<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class requisicoes extends Model
{
	protected $table = 'requisicoes';
	public $primaryKey = 'id';

    function getStatus(){
        $nome = $this->hasOne('App\statusdocumentos', 'id', 'status')->first()->toArray();
        $this->status_nome = $nome['nome'];
    }
    function getTipoDestino(){
        $tipo_destino = $this->hasOne('App\tipodestinos', 'id', 'tipo_destino')->first()->toArray();
        $this->tipo_destino_nome = $tipo_destino['nome'];
        $this->destino = $this->hasOne('App\\'.($tipo_destino['class']), 'id', 'id_destino')->first();
    }
    function getComments(){
        $comments = $this->hasOne('App\observacoesrequisicoes', 'requisicao_id', 'id')->get()->toArray();
        $this->comentarios = $comments;
    }
}

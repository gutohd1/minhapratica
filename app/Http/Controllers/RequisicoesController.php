<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\requisicoes;
use App\statusdocumentos;
use App\meiosolicitacoes;
use App\observacoesrequisicoes;

class RequisicoesController extends Controller
{
    public function edit($busca_id, $documento_id, $requisicao_id){
    	$requisicao = requisicoes::find($requisicao_id);
    	if($requisicao){
    		$requisicao->getStatus();
			$requisicao->getTipoDestino();
			$requisicao->getComments();
			$status = statusdocumentos::pluck('nome', 'id');
			$meiossolicitacao = meiosolicitacoes::pluck('nome', 'id');
	    	$data = array();
	    	$data['status'] = $status;
	    	$data['busca_id'] = $busca_id;
	    	$data['requisicao'] = $requisicao;
	    	$data['documento_id'] = $documento_id;
	    	$data['meiossolicitacao'] = $meiossolicitacao;
	    	$data['solicitacao_field'] = false;
	    	$data['m_solicitacao_field'] = false;
	    	if($requisicao->status == 4 || $requisicao->status == 7){
	    		$data['solicitacao_field'] = true;
	    	}	    	
	    	return View('buscas.documentos.requisicoes.edit', $data);
	    }
    }
    public function update($busca_id, $documento_id, $requisicao_id, Request $request){
    	if($request->has("situacao")){
    		$situacao = (integer)$request->get("situacao");
    		$requisicao = requisicoes::find($requisicao_id);
    		if($requisicao){
    			$requisicao->status = $situacao;
    			$requisicao->data_respondido = Carbon::now('Europe/London');
	    		if($situacao == 4 && $request->has("solicitacao")){
	    			if($request->get("solicitacao") == 2){
	    				$requisicao->meio_solicitacao = $request->get("meio_solicitacao");
	    				if($request->has("solicitado") || $request->has("enivar")){
	    					$requisicao->data_requisitado = Carbon::now('Europe/London');
	    				}
	    				if($request->has("enivar")){
	    					//aqui vai a funcao de envio de e-mail. escrita aqui ou chamada.
	    				}
	    			}
	    		}
	    		$requisicao->save();
	    	}
    	}
    	return redirect()->route('busca.documento.edit', array('busca_id' => $busca_id, 'documento_id' => $documento_id, 'requisicoes' =>true ))
    	/*return redirect()->route('busca.documento.requisicao.edit', array('busca_id' => $busca_id, 'documento_id' => $documento_id, 'requisicao_id' => $requisicao_id))*/->with(['status' => 'success', 'message' => 'Requisicao atualizada com sucesso']);
    }
    public function addcoment($busca_id, $documento_id, $requisicao_id, Request $request){
    	$comentario = new observacoesrequisicoes;
    	$comentario->requisicao_id = $requisicao_id;
    	$comentario->user_id = 1;
    	$comentario->observacao = $request->get('comment');
    	$comentario->save();
    	$comentarios = observacoesrequisicoes::where('requisicao_id', '=', $requisicao_id)->orderBy('id', 'DESC')->first();
    	$html = View('inc.comentariorequisicao', array('comentario' => $comentarios))->render();
    	return response()->json(['status' => 'success', 'comentarios' => $comentarios, 'html' => $html]);
    }
}

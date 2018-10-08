<?php

namespace App\Http\Controllers;
use App\Buscas;
use App\provincia;
use App\requisicoes;
use App\Buscasdocumentos;

use Illuminate\Http\Request;

class DocumentosController extends Controller{
    public function add($busca_id){
    	//dd('nois aqui');
    	$data['busca_id'] = $busca_id;
    	return View('buscas.documentos.novo', $data);
    }
    public function store($busca_id, Request $request){
    	$busca = Buscas::find($busca_id);
    	if($busca){
    		$busca->getCliente();
    		$cliente = $busca->cliente;
	    	$documento = new Buscasdocumentos;
	    	$documento->tipo = 1;
	    	$documento->nome = $request->get('nome');
	    	$documento->ano = $request->get('ano');
	    	if($request->has('conjuge')){
		    	$documento->conjuge = $request->get('conjuge');
		    }
		    if($request->has('pai')){
	    		$documento->pai = $request->get('pai');
	    	}
	    	if($request->has('mae')){
		    	$documento->mae = $request->get('mae');
		    }
	    	$documento->idbusca = $busca_id;
	    	$documento->localizado = 0;
	    	$this->createDoc($documento, $cliente);
	    	if($documento->save()){
		    	return redirect()->route('busca.edit', array('busca_id' => $busca_id))->with(['status' => 'success', 'message' => 'Documento adicionado com sucesso']);
		    }
		}
	    return redirect()->route('busca.edit', array('busca_id' => $busca_id))->with(['status' => 'error', 'message' => 'Nao foi possivel adicionar o documento']);
    }
    public function edit($busca_id, $documento_id){
    	$documento = Buscasdocumentos::find($documento_id);
    	if($documento){
    		$provincias = provincia::get();
    		$requisicoes = requisicoes::where('id_doc', '=', $documento_id)->get();
    		if(count($requisicoes)>0){
    			foreach ($requisicoes as $key => $requisicao) {
					$requisicao->getStatus();
					$requisicao->getTipoDestino();
    				$requisicoes[$key] = $requisicao;
    			}
    		}
	    	$data['busca_id'] = $busca_id;
	    	$data['documento'] = $documento;
	    	$data['provincias'] = $provincias;
	    	$data['requisicoes'] = $requisicoes;
	    	return View('buscas.documentos.edit', $data);
	    }
	    return redirect()->route('busca.edit', array('busca_id' => $busca_id))->with(['status' => 'error', 'message' => 'Documento nao localizado']);
    }
    private function createDoc(&$documento, $cliente){

    	$conteudo = '';
    	switch ($documento->tipo) {
    		case 1:
    			$titulo = 'Ricerca Genealogica';
    			$conteudo = 'Ufficio di Stato Civile

Egregi Signori,
Mi chiamo '.$cliente->nome.' e residente all´indirizzo sottoindicato.
Attualmente sto ricercando l’origine della mia famiglia com l´obiettivo di trovare i documenti che mi sono stati richiesti dal Consolato Italiano in per avviare il processo di riconoscimento della mia cittadinanza italiana, mi é stato detto quindi di rivolgermi a Lei.
Le scrivo per chiederLe gentilmente di aiutarmi con la ricerca:
sto cercando provenienza del mio antenato '.$documento->nome.' che credo sai nato nella Comune di Potenza il cerca di '.$documento->ano;
				if(isset($documento->pai) || isset($documento->mae)){
					$conteudo .= ' Figlio di ';
				}
				if(isset($documento->pai)){
					$conteudo .= $documento->pai;
				}
				if(isset($documento->pai) && isset($documento->mae)){
					$conteudo .= ' e ';
				}
				if(isset($documento->mae)){
					$conteudo .= $documento->mae;
				}
				$conteudo = trim($conteudo);

				$conteudo .= '. La ringrazio in anticipo per la Sua Gentilezza e premura, e chiedo che qualsiasi spesa inerente alla ricerca mi sia addebitata.

Questi documenti che Le chiedo mi sono stati richiesti das Consolato Italiano in e secondo a legge dello Stato Italiano sono assolutamente necessari per poter completare la procedura di acquisto della cittadinanza italiana.

La ringrazio in antecipo per la sua gentilezza e premura.

Distinti saluti,

'.$cliente->nome.' '.$cliente->sobrenome.'

'.$cliente->endereco1;
				if($cliente->endereco2 != null){
					$conteudo .= '
'.$cliente->endereco2;
				}
					$conteudo .= '
'.$cliente->cidade;
				if($cliente->estado != null){
					$conteudo .= '
'.$cliente->estado;
				}
				$conteudo .= '
'.$cliente->pais;

				$documento->msgtitulo = $titulo;
				$documento->msg = $conteudo;
    			break;
    		case 2:
    			# code...
    			break;
    	}
    }
    public function iniciar($busca_id, $documento_id, Request $request){
    	//adicionar validacao para obrgar provincia e comune
    	$documento = Buscasdocumentos::find($documento_id);
    	if($documento){
	    	$documento->msgtitulo = $request->get('titulo');
	    	$documento->msg = $request->get('msg');
	    	$documento->save();
	    	if($request->has('enviar')){
	    		if($request->has('comunes')){
	    			$comunes = $request->get('comunes');
	    			foreach ($comunes as $key => $comune) {
	    				$requisicao = new requisicoes;
			    		$requisicao->tipo_destino = 1;
			            $requisicao->id_destino = $comune;
			            $requisicao->id_doc = $documento_id;
			            $requisicao->status = 2;
			            $requisicao->ativo = 1;
			            $requisicao->save();
	    			}
	    		}
		    }
    		dd($request->all());
		}
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\Buscas;

class BuscasController extends Controller{
    public function list(){
    	$buscas = Buscas::get();
    	$andamento = Array();
    	$concluidas = Array();
    	$canceladas = Array();
    	if($buscas && count($buscas) > 0){
    		foreach ($buscas as $key => $busca) {
				$busca->getCliente();
				//dd($busca);
    			switch ($busca->status) {
    				case 0:
    					array_push($andamento, $busca);
    					break;
    				case 1:
    					array_push($concluidas, $busca);
    					break;
    				case 2:
    					array_push($canceladas, $busca);
    					break;
    			}
    		}
    	}
    	$data['andamento'] = $andamento;
    	$data['concluidas'] = $concluidas;
    	$data['canceladas'] = $canceladas;
    	return View('buscas.show', $data);
    }
    public function add(){
    	$clientes = Clientes::get();
    	$data['clientes'] = $clientes;
    	//dd($clientes);
    	return View('buscas.novo', $data);
    }
    public function store(Request $request){
    	$busca = new Buscas;
        $busca->idcliente = $request->get("cliente");
		$busca->status = 0;
        if($busca->save()){
        	return redirect()->route('busca.list')->with(['status' => 'success', 'message' => 'Busca Criada com sucesso']);
        }
        return redirect()->route('busca.add')->with(['status' => 'error', 'message' => 'Nao foi possivel criar a busca']);
    }
    public function edit($busca_id){
    	$busca = Buscas::find($busca_id);
    	if($busca){
    		$busca->getCliente();
            $busca->getDocumentos();
    		$data['busca'] = $busca;
    		return View('buscas.edit', $data);
    	}
    	return redirect()->route('busca.list')->with(['status' => 'error', 'message' => 'Nao foi possivel localizar esta busca']);
    }
}

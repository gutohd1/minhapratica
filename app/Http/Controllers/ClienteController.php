<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;

class ClienteController extends Controller{
    public function list(){
    	$data['clientes'] = Clientes::get();
    	return View('clientes.show', $data);
    }
    public function add(){
    	return View('clientes.novo');
    }
    public function store(Request $request){
    	$cliente = new Clientes;
        $cliente->nome = $request->get("nome");;
        $cliente->sobrenome = $request->get("sobrenome");
        $cliente->email = $request->get("email");
        //$request->get("repetiremail");
        $cliente->endereco1 = $request->get("endereco");
        if($request->has("complemento")){
	        $cliente->endereco2 = $request->get("complemento");
	    }
        $cliente->cidade = $request->get("cidade");
        if($request->has("estado")){
			$cliente->estado = $request->get("estado");
		}
		$cliente->pais = $request->get("pais");
		$cliente->tipo = 0;//tipo 0 significa que o cliente fora registrado pelo administrador do sistema. Tipo 1 significa que o cliente fez o cadastro dele atraves do site.
        if($cliente->save()){
        	return redirect()->back()->with(['status' => 'success', 'message' => 'Cliente cadastrado com sucesso']);
        }
        return redirect()->back()->with(['status' => 'error', 'message' => 'Nao foi possivel cadastrar o cliente']);
    }
}

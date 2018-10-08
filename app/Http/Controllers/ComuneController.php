<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Busca;
use App\emails;
use App\comunes;
use App\provincia;

class ComuneController extends Controller{

    public function update($provincia_id, $comune_id, Request $request){
        if(($request->has('provinciaNome') && $request->has('provinciaEmail')) || 
            ($request->has('comuneNome') && $request->has('comuneEmail'))){
            $customEmails = Array();
        }
        if($request->has('provinciaNome') && $request->has('provinciaEmail')){
            $provinciaNome = $request->get('provinciaNome');
            $provinciaEmail = $request->get('provinciaEmail');
            foreach($provinciaNome as $key => $nome){
                $customEmail = array(
                    'rel_tipo' => 0, 
                    'nome' => $nome, 
                    'email' => isset($provinciaEmail[$key])?$provinciaEmail[$key]:null
                );
                array_push($customEmails, (object)$customEmail);
            }
        }
        if($request->has('comuneNome') && $request->has('comuneEmail')){
            $provinciaNome = $request->get('comuneNome');
            $comuneEmail = $request->get('comuneEmail');
            foreach($provinciaNome as $key => $nome){
                $customEmail = array(
                    'rel_tipo' => 1, 
                    'nome' => $nome, 
                    'email' => isset($comuneEmail[$key])?$comuneEmail[$key]:null
                );
                array_push($customEmails, (object)$customEmail);
            }
        }
        if(($request->has('provinciaNome') && $request->has('provinciaEmail')) || 
            ($request->has('comuneNome') && $request->has('comuneEmail'))){
            //dd($customEmails);
            if(count($customEmails) > 0){
                foreach ($customEmails as $key => $customEmail) {
                    $dbEmail = new emails;
                    $dbEmail->rel_id = $customEmail->rel_tipo==0?$provincia_id:$comune_id;
                    $dbEmail->rel_tipo = $customEmail->rel_tipo;//email pertencente a provincia
                    $dbEmail->nome_email = $customEmail->nome;
                    $dbEmail->email = $customEmail->email;
                    $dbEmail->tipo = 1;//Adicionado pelo usuario
                    $dbEmail->bloqueado = 0;//caso seja bloqueado pelo usuario
                    $dbEmail->envio = 1;//define como email a ser enviado em caso de contato(ja e adicionado como principal de envio)
                    $dbEmail->save();
                }
            }
        }
        if($request->has('direto')){
            $emails = array();
            $emails_p = emails::where('rel_tipo', '=', 0)->where('rel_id', '=', $provincia_id)->get();
            if(count($emails_p) > 0){
                foreach ($emails_p as $email) {
                    array_push($emails, $email->id);
                }
            }
            $emails_c = emails::where('rel_tipo', '=', 1)->where('rel_id', '=', $comune_id)->get();
            if(count($emails_c) > 0){
                foreach ($emails_c as $email) {
                    array_push($emails, $email->id);
                }
            }
            $direto = $request->get('direto');
            $sent = Array();
            if(count($direto) > 0){
                foreach($direto as $email_id => $each){
                    array_push($sent, $email_id);
                    $email = emails::where('id', '=', $email_id);
                    $email->update(array("envio" => 1));
                }
            }
            $emails_result = array_diff($emails, $sent);
            if(count($emails_result) > 0){
                foreach ($emails_result as $email_id) {
                    $email = emails::where('id', '=', $email_id);
                    $email->update(array("envio" => 0));
                }
            }
        }
        if($request->has('excluidos') && trim($request->get('excluidos')) != ''){
            $excluidos = explode(',', trim($request->get('excluidos')));
            foreach ($excluidos as $email_id) {
                $email = emails::where('id', '=', $email_id);
                $email->delete();
            }
        }
        if($request->has('bloqueados') && trim($request->get('bloqueados')) != ''){
            $bloqueados = explode(',', trim($request->get('bloqueados')));
            foreach ($bloqueados as $email_id) {
                $email = emails::where('id', '=', $email_id);
                $email->update(array("bloqueado" => 1));
            }
        }
        if($request->has('desbloqueados') && trim($request->get('desbloqueados')) != ''){
            $bloqueados = explode(',', trim($request->get('desbloqueados')));
            foreach ($bloqueados as $email_id) {
                $email = emails::where('id', '=', $email_id);
                $email->update(array("bloqueado" => 0));
            }
        }
        /*return redirect()->route('provincia.comune', ['provincia_id' => $provincia_id, 'comune_id' => $comune_id])->with(['status' => 'success', 'message' => 'Informacoes atualizadas com sucesso']);*/
        return redirect()->back()->with(['status' => 'success', 'message' => 'Informacoes atualizadas com sucesso']);
    }
    public function loadComuneList($provincia){
        $comunes = comunes::where('provincia_id', '=', $provincia)->get();
        $linhaRetorno = '';
        if($comunes){
            $linhaRetorno .= '<option>Selecione Provincia</option>';
            foreach($comunes as $comune){
                $linhaRetorno .= '<option value="'.$comune->id.'">'.$comune->nome.'</option>';
            }
        }
        return $linhaRetorno; 
    }
    public function list($provincia_id = null, $comune_id = null){
        $provincias = provincia::get();
        $data['provincias'] = $provincias;
        $data['provincia_id'] = null;
        $data['comune_id'] = null;
        if($provincia_id != null){
            $data['provincia_id'] = $provincia_id;
            foreach($provincias as $provincia){
                if($provincia_id == $provincia->id){
                    $provinciaSel =  $provincia;
                }
            }
            $bloqueados = Array();
            $provinciaSel->getEmails();
            if(isset($provinciaSel->emails)){
                foreach($provinciaSel->emails as $email){
                    if($email->bloqueado == 1){
                        array_push($bloqueados, $email);
                    }
                }
            }
            if($comune_id != null){
                $data['comune_id'] = $comune_id;
                $comunes = comunes::where('provincia_id', '=', (integer)$provincia_id)->get();
                $data['comunes'] = $comunes;
                foreach ($comunes as $comune) {
                    //dd($comunes);
                    if((integer)$comune_id == $comune->id){
                        //dd($comune);
                        $comune->getEmails();
                        if(isset($comune->emails)){
                            foreach($comune->emails as $email){
                                if($email->bloqueado == 1){
                                    array_push($bloqueados, $email);
                                }
                            }
                        }
                        $provinciaSel->comune =  $comune;
                    }
                }
            }
            $data['bloqueados'] = $bloqueados;
            $data['provinciaSel'] = $provinciaSel;
            $response = json_decode(\GoogleMaps::load('geocoding')
            ->setParam (['address' => $data['provinciaSel']->nome.' '.$data['provinciaSel']->comune->nome])
            ->get());

            if($response->status == 'OK'){
                $location = $response->results[0]->geometry->location;
                
                $data['latitude'] = $location->lat;
                $data['longitude'] = $location->lng;
            }
        }
        
        return View('comunes.show', $data);
    }
    public function getComunes(){
        ini_set('max_execution_time', 0); 
        $busca = Busca::orderBy('_id', 'DESC')->first();
        if($busca){
            if(isset($busca->busca) && count($busca->busca) > 0 && (!isset($busca->migrado) || $busca->migrado == false)){
                $deletados = emails::where('tipo', '=', 0)->delete();
                foreach ($busca->busca as $provincia) {
                    $provincia = (Object)$provincia;
                    if(isset($provincia->provincia)){
                        $provincia_id = $this->loadProvincia($provincia);
                    }
                    if(isset($provincia->email) && $provincia->email != null){
                        $dbEmail = new emails;
                        $dbEmail->rel_id = $provincia_id;
                        $dbEmail->rel_tipo = 0;//email pertencente a provincia
                        $dbEmail->nome_email = 'geral';
                        $dbEmail->email = $provincia->email;
                        $dbEmail->tipo = 0;//caregado pelo site
                        $dbEmail->bloqueado = 0;//caso seja bloqueado pelo usuario
                        $dbEmail->envio = 1;//define como email a ser enviado em caso de contato
                        $dbEmail->save();
                    }
                    if(isset($provincia->comunes) && isset($provincia->provincia)){
                        foreach($provincia->comunes as $comune){
                            $comune = (Object)$comune;
                            $comune->provincia_id = $provincia_id;
                            $comune_id = $this->loadComune($comune);
                            if(isset($comune->email)){
                                foreach($comune->email as $key => $email){
                                    if(strlen($email) <= 100){
                                        $dbEmail = new emails;
                                        $dbEmail->rel_id = $comune_id;
                                        $dbEmail->rel_tipo = 1;//email pertencente ao comune
                                        $dbEmail->nome_email = $key;
                                        $dbEmail->email = $email;
                                        $dbEmail->tipo = 0;//caregado pelo site
                                        $dbEmail->bloqueado = 0;//caso seja bloqueado pelo usuario
                                        $dbEmail->envio = 1;//define como email a ser enviado em caso de contato
                                        $dbEmail->save();
                                    }
                                }
                            }
                        }
                    }
                }
                $busca->migrado = true;
                $busca->save();
            }else{
                echo 'Nao ha migracoes a serem feitas';
            }
        }
        exit;
        //dd(Busca::orderBy('_id', 'DESC')->first()->toArray());
    }
    private function loadComune($comune){
        $data = comunes::where('nome', '=', $comune->nome)->first();
        if(!$data){
            $data = new comunes;
            $data->provincia_id = $comune->provincia_id;
            $data->nome = $comune->nome;
            $data->url = 'url';
            $data->save();
        }
        return $data->id;
    }
    private function loadProvincia($provincia){
        $data = provincia::where('nome', '=', $provincia->provincia)->first();
        if(!$data){
            $data = new provincia;
            $data->regiao_id = 0;
            $data->nome = $provincia->provincia;
            $data->url = $provincia->url;
            $data->save();
        }
        return $data->id;
    }
    public function loadComunes(){
        //dd(Busca::all());
        ini_set('max_execution_time', 0); 
        $host = 'www.comuni-italiani.it';
        $response = Curl::to($host)->get();
        $page = htmlqp($response);
        $urls = array();
        $provincias = Array();
        $trs = $page->find('#table1')->find('tr')->each(function($i, $e){return $e;});
        if(count($trs)>0){
            foreach ($trs as $keytr => $tr) {
                $tds = $tr->find('td')->each(function($i, $e){return $e;});
                //dd(count($tds));
                if(count($tds)>1){
                    foreach ($tds as $keytd => $td) {
                        if(trim($td->find('a')->attr('href')) != ''){
                            array_push($urls, $host.'/'.$td->find('a')->attr('href'));
                        }
                    }
                }
            }
            foreach($urls as $url){
                array_push($provincias, $this->loadProvincias($url));
            }
        }
        //dd($provincias);
        $dbbusca = new Busca;
        $dbbusca->busca = $provincias;
        $dbbusca->save();
    }
    protected function loadProvincias($url){
        $provincia = Array();
        $response = Curl::to($url)->get();
        $page = htmlqp($response);
        $tableBase = $page->find('.tabwrap')->eq(0);
        $tableInfo = $page->find('.tabwrap')->eq(1);
        $trsbase = $tableBase->find('tr')->each(function($i, $e){return $e;});
        foreach($trsbase as $tr){
            if(trim($tr->find('.ivoce')->text()) == 'Regione'){
                $provincia['regiao'] = trim($tr->find('.ival')->text());
            }else if(trim($tr->find('.ivoce')->text()) == 'Capoluogo' || trim($tr->find('.ivoce')->text()) == 'Capoluoghi'){
                $provincia['provincia'] = trim($tr->find('.ival')->text());
            }
        }
        $provincia['url'] = $url;
        $provincia['email'] = trim(str_replace('mailto:', '', $tableInfo->find('tr a:contains("Email Provincia")')->attr('href')));
        $provincia['comunes'] = $this->loadProvinciaContent(str_replace('index', 'pec', $url));
        return $provincia;
    }
    protected function loadProvinciaContent($url){
        $response = Curl::to($url)->get();
        $page = htmlqp($response);
        $trs = $page->find('.tabwrap tr')->each(function($i, $e){return $e;});
        $anterior = null;
        $lista = Array();
        $comune = Array();
        $email = Array();
        foreach ($trs as $key => $tr) {
            $linha = trim($tr->text());
            if(strpos($linha, '@')){
                if(strpos($linha, ':')){
                    $linhaEmail = explode(':', $linha);
                    if(isset($linhaEmail[0]) && isset($linhaEmail[1])){
                        $email[trim($linhaEmail[0])] = trim($linhaEmail[1]);
                    }else{
                        dd($linha);
                    }
                }else{
                    $email['geral'] = trim($linha);
                }
            }else{
                if($anterior != null){
                    $comune['email'] = (Object)$email;
                    array_push($lista, (Object)$comune);
                    $comune = Array();
                    $email = Array();
                }
                $anterior = 'nome';
                $comune['nome'] = $linha;
            }
        }
        return $lista;
    }
}

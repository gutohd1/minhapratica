@extends('layouts.dashboard')
@section('page_heading','Documento')
@section('bread')
	<li class="breadcrumb-item"><a href="{{ route('busca.list') }}">Buscas</a></li>
    <li class="breadcrumb-item"><a href="{{ route('busca.edit', array('busca_id' => $busca_id)) }}">Busca: {{ $busca_id }}</a></li>
    <li class="breadcrumb-item active">Documento: {{ $documento->id }}</li>
@stop
@section('section')
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
		  <li class="{{ !Request::has('requisicoes')?'active':'' }}"><a data-toggle="tab" href="#dados">Dados do documento</a></li>
		  <li class="{{ Request::has('requisicoes') && Request::get('requisicoes') == 1?'active':''}}"><a data-toggle="tab" href="#requisicoes">Requisicoes</a></li>
		</ul>
		<div class="tab-content">
			<div id="dados" class="tab-pane fade {{ !Request::has('requisicoes')?'in active':'' }}">
				<h3>Dados do documento</h3>
				{!! Form::open(['url' => route('busca.documento.iniciar', array('busca_id' => $busca_id, 'documento_id' => $documento->id)),  'method' => 'put']) !!}
					<div class="row">
					    <div class="col-lg-6">
					    	<div class="form-group">
			                	<label>Nome:</label>
				                <p>{{isset($documento->nome)?$documento->nome:''}}</p>
				            </div>
				            <div class="form-group">
			                	<label>Ano:</label>
				                <p>{{isset($documento->ano)?$documento->ano:''}}</p>
				            </div>
				            <div class="form-group">
			                	<label>conjuge:</label>
				                <p>{{isset($documento->conjuge)?$documento->conjuge:''}}</p>
				            </div>
				            <div class="form-group">
			                	<label>Pai:</label>
				                <p>{{isset($documento->pai)?$documento->pai:''}}</p>
				            </div>
				            <div class="form-group">
			                	<label>Mae:</label>
				                <p>{{isset($documento->mae)?$documento->mae:''}}</p>
				            </div>
					    </div>
					    <div class="col-lg-6">
					    	<div class="form-group">
			                	<label>Provincia:</label>
				                 <select class="form-control slcProvincias select2" required name="provincia" data-url="{{route('provincia.comune.loadList', ['provincia_id' => 0])}}">
				                    <option>Selecione uma provincia</option>
				                    @if(isset($provincias) && count($provincias) > 0)
				                    	@foreach($provincias as $provincia)
				                    		<option value="{{$provincia->id}}" {{isset($provincia_id) && $provincia_id==$provincia->id?'selected':''}}>{{$provincia->nome}}</option>
				                    	@endforeach
				                    @endif
				                </select>
				            </div>
				            <div class="form-group">
			                	<label>Comunes:</label>
				                <select class="form-control slcComunes" multiple {{!isset($comunes)?'disabled':''}} required data-url="{{route('provincia.comune', ['provincia_id' => 'provincia_id', 'comune_id' => 'comune_id'])}}"  name="comunes[]">
				                    <option>Selecione Provincia</option>
				                    @if(isset($comunes))
				                    	@foreach($comunes as $comune)
				                    		<option value="{{$comune->id}}" {{isset($comune_id) && $comune_id==$comune->id?'selected':''}}>{{$comune->nome}}</option>
				                    	@endforeach
				                    @endif
				                </select>
				            </div>
					    </div>
					</div>
					<div class="row">
						<div class="form-group">
							<label>Assunto:</label>
							<input class="form-control" value="{{$documento->msgtitulo != null?$documento->msgtitulo:''}}" name="titulo">
						</div>
						<div class="form-group">
							<label>Mensagem:</label>
							<textarea class="form-control" rows="10" name="msg">{{$documento->msg != null?$documento->msg:''}}</textarea>
						</div>
						<div class="form-group">
							<label>Enviar:</label>  
							<input type="checkbox" name="enviar"><i class="fa fa-arrow-left"></i> Marque esta opcao caso deseje enviar agora.
						</div>
						<div class="form-group">
							<a href="{{route('busca.edit', array('busca_id' => $busca_id))}}" class="btn btn-default pull-left">voltar</a> 
							{{ Form::submit('Salvar', ['class' => 'btn btn-success pull-right']) }}
						</div>
					</div>
				{!!Form::close()!!}
			</div>
			<div id="requisicoes" class="tab-pane fade {{ Request::has('requisicoes') && Request::get('requisicoes') == 1?'in active':''}}">
			    <h3>Requisicoes</h3>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Tipo</th>
							<th>Nome</th>
							<th>Data Envio</th>
							<th>Data Resposta</th>
							<th>Situacao</th>
						</tr>
					</thead>
					<tbody>
						@foreach($requisicoes as $key => $requisicao)
			    			<?php $url = route('busca.documento.requisicao.edit', array('busca_id' => $busca_id, 'documento_id' => $documento->id, 'requisicao_id' => $requisicao->id)); ?>
							<tr>
								<td><a href='{{ $url }}'>{{$requisicao->tipo_destino_nome}}</a></td>
								<td><a href='{{ $url }}'>{{$requisicao->destino->nome}}</a></td>
								<td><a href='{{ $url }}'>{{$requisicao->data_questionado}}</a></td>
								<td><a href='{{ $url }}'>{{$requisicao->data_respondido}}</a></td>
								<td><a href='{{ $url }}'>{{$requisicao->status_nome}}</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop

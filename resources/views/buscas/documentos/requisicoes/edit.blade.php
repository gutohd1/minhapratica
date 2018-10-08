@extends('layouts.dashboard')
@section('page_heading','Requisicao')
@section('bread')
	<li class="breadcrumb-item"><a href="{{ route('busca.list') }}">Buscas</a></li>
    <li class="breadcrumb-item"><a href="{{ route('busca.edit', array('busca_id' => $busca_id)) }}">Busca: {{ $busca_id }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('busca.documento.edit', array('busca_id' => $busca_id, 'documento_id' => $documento_id )) }}">Documento: {{ $documento_id }}</a></li>
    <li class="breadcrumb-item active">Requisicao: {{ $requisicao->id }}</li>
@stop
@section('section')
	<div class="col-sm-12">
		
		<div class="tab-content">
			<div id="dados" class="tab-pane fade in active">
				<h3>Dados da requisicao</h3>
				
			</div>
			{!! Form::open(['url' => route('busca.documento.requisicao.update', array('busca_id' => $busca_id, 'documento_id' => $documento_id, 'requisicao_id' => $requisicao->id)),  'method' => 'put']) !!}
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
			                {{ Form::label('tipo_destino', 'Tipo:', ['class' => 'control-label']) }}
	    					{{ Form::text('tipo_destino', $requisicao->tipo_destino_nome, ['class' => 'form-control', 'disabled' => 'disabled']) }}
			            </div>
			            <div class="form-group">
			                {{ Form::label('nome_destino', 'Nome:', ['class' => 'control-label']) }}
	    					{{ Form::text('nome_destino', $requisicao->destino->nome, ['class' => 'form-control', 'disabled' => 'disabled']) }}
			            </div>
			            <div class="form-group">
			                {{ Form::label('data_questionado', 'Data Envio:', ['class' => 'control-label']) }}
	    					{{ Form::date('data_questionado', $requisicao->data_questionado, ['class' => 'form-control', 'disabled' => 'disabled']) }}
			            </div>
			            <div class="form-group" {{ is_null($requisicao->data_respondido)?'hidden':'' }}>
			            	{{ Form::label('data_respondido', 'Data Resposta:', ['class' => 'control-label']) }}
	    					{{ Form::date('data_respondido', !is_null($requisicao->data_respondido)?$requisicao->data_respondido:'', ['class' => 'form-control', 'disabled' => 'disabled']) }}
			            </div>
			            <div class="form-group">
			                {{ Form::label('situacao', 'Situacao:', ['class' => 'control-label']) }}
			                {{ Form::select('situacao', $status, $requisicao->status, ['class' => 'form-control']) }}
			            </div>
					</div>
					<div class="col-lg-6">
			            <div class="form-group {{$solicitacao_field == false?'hidden':'' }}">
			                {{ Form::label('solicitacao', 'Deseja Solicitar o documento?', ['class' => 'control-label']) }}
			                {{ Form::select('solicitacao', [0 => 'Selecione', 1 => 'Nao', 2 => 'Sim'], $requisicao->status == 7?2:null , ['class' => 'form-control', 'disabled' => true, 'required' => true]) }}
			            </div>
			            <div class="form-group {{$solicitacao_field == false?'hidden':'' }}">
			                {{ Form::label('meio_solicitacao', 'Tipo da solicitacao: ', ['class' => 'control-label']) }}
			                {{ Form::select('meio_solicitacao', $meiossolicitacao, $requisicao->meio_solicitacao, ['class' => 'form-control', 'disabled' => true]) }}
			            </div>
			            <div class="form-group {{$requisicao->data_requisitado != null && $requisicao->meio_solicitacao == 2?'':'hidden' }}">
			                {{ Form::label('solicitado', 'Marcar como Solicitado? ', ['class' => 'control-label']) }}
			                {{ Form::select('solicitado', [0 => 'Selecione', 1 => 'Nao', 2 => 'Sim'], $requisicao->data_requisitado != null ? 2:null, ['class' => 'form-control', 'disabled' => true]) }}
			            </div>
			            <div class="form-group {{$requisicao->data_requisitado != null && $requisicao->meio_solicitacao == 1?'':'hidden' }}">
			                {{ Form::label('enviar', 'Deseja enviar agora?', ['class' => 'control-label']) }}
			                {{ Form::select('enivar', [0 => 'Selecione', 1 => 'Nao', 2 => 'Sim'], $requisicao->data_requisitado != null ? 2:null, ['class' => 'form-control', 'disabled' => true]) }}
			            </div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
			                {{ Form::label('observacoes', 'Observacoes:', ['class' => 'control-label']) }}
			                {{--{{ Form::textarea('observacoes', '', ['class' => 'form-control']) }}--}}
			                <div class="form-control table-responsive observacoes" style="height: 300px;">
			                	<table class="table">
				                	<thead>
				                		<tr>
						                	<th>Data</th>
						                	<th>User</th>
						                	<th>Comentario</th>
					                	</tr>
				                	</thead>
				                	<tbody>
				                		@if(isset($requisicao->comentarios) && count($requisicao->comentarios) > 0)
				                			@foreach($requisicao->comentarios as $comentario)
						                		@include('inc.comentariorequisicao', array('comentario' => $comentario))
				                			@endforeach
				                		@endif
				                	</tbody>
			                	</table>
			                </div>
			            </div>
			            <?php $token = csrf_token(); ?>
			            <div class="form-group input-group">
			                {{ Form::textarea('add_observacoes', '', ['class' => 'form-control ', 'rows' => 2, 'data-url' => route('busca.documento.requisicao.addcoment', array('busca_id' => $busca_id, 'documento_id' => $documento_id, 'requisicao_id' => $requisicao->id)), 'data-token' => "$token"]) }}
			                <span class="input-group-addon">
			                	<a href="javascript:void(0)" class="adicionarComentario">Enviar</a>
			                </span>
			            </div>
			            <div class="form-group">
			            	<a href="{{route('busca.documento.edit', array('busca_id' => $busca_id, 'documento_id' => $documento_id))}}" class="btn btn-default pull-left">voltar</a> 
			                {{ Form::submit('Salvar', ['class' => 'btn btn-success pull-right']) }}
			            </div>
					</div>
					<div class="col-lg-12">
					&nbsp;
					</div>
			    </div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

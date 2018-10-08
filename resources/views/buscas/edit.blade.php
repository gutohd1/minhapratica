@extends('layouts.dashboard')
@section('page_heading','Busca: '.$busca->id)
@section('bread')
	<li class="breadcrumb-item"><a href="{{ route('busca.list') }}">Buscas</a></li>
    <li class="breadcrumb-item active">Busca: {{ $busca->id }}</li>
@stop
@section('section')		
	<div class="col-sm-12">
		<div class="row">
		    <div class="col-lg-5">
		    	<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<h3 class="panel-title">Informacoes</h3>
					</div>
					<div class="panel-body">
			        	<div class="form-group">
		                	<label>Nome: </label>
			                {{$busca->cliente->nome . ' ' . $busca->cliente->sobrenome}}
			            </div>
			            <div class="form-group">
			                <label>Data: </label>
			                {{$busca->created_at}}
			            </div>
		            </div>
		        </div>
		    </div>
		    <div class="col-lg-7">
		    	<div class="panel panel-default">
					<div class="panel-heading clearfix">
				    	<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Documentos</h4>
			      		<div class="btn-group pull-right">
					        <a href="{{route('busca.documento.add', array('busca_id' => $busca->id))}}" class="btn btn-default btn-sm" title="Novo documento">
					        	<i class="fa fa-file-o"></i>
		                    	<i class="fa fa-plus"></i>
		                    </a>
			      		</div>
				    </div>
					{{--style="bottom: 0; position: relative; top: -25px;"--}}
					<div class="panel-body">
						@if(isset($busca->documentos) && count($busca->documentos) > 0)
				        	@foreach($busca->documentos as $documento)
					        	<div class="form-group">
				                	<label>{{$documento->tipo}}</label>
					                {{$documento->nome}}
					                <div class="btn-group pull-right">
								        <a href="{{route('busca.documento.edit', array('busca_id' => $busca->id, 'documento_id' => $documento->id))}}" class="btn btn-default btn-sm">
								        	<i class="fa fa-edit"></i>
					                    </a>
					                    <a href="#" class="btn btn-default btn-sm">
					                    	<i class="fa fa-trash-o"></i>
					                    </a>
						      		</div>
					            </div>
					        @endforeach
				        @endif
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="form-group">
				<a href="{{route('busca.list')}}" class="btn btn-default pull-left">voltar</a> 
			</div>
		</div>
	</div>
@stop

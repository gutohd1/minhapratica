@extends('layouts.dashboard')
@section('page_heading','Nova Busca')
@section('section')
	{!! Form::open(['url' => route('busca.add'),  'method' => 'put']) !!}
		<div class="col-sm-12">
			<div class="row">
			    <div class="col-lg-6">
			    	<div class="form-group">
	                	<label>Cliente: *</label>
		                <select class="form-control select2" required name="cliente">
		                	<option value="0">Selecione um cliente</option>
		                	@if(isset($clientes) && count($clientes) > 0)
		                		@foreach($clientes as $cliente)
		                			<option value="{{$cliente->id}}">{{$cliente->nome . ' ' . $cliente->sobrenome}}</option>
		                		@endforeach
		                	@endif
		                </select>
		            </div>
		            
			    </div>
			    <div class="col-lg-6">
			    	
			    	<button class="btn btn-success pull-right">Criar</button>
			    </div>
			</div>
		</div>
	{!!Form::close()!!}
@stop

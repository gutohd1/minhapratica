@extends('layouts.dashboard')
@section('page_heading','Novo documento')
@section('section')
	{!! Form::open(['url' => route('busca.documento.add', array('busca_id' => $busca_id)),  'method' => 'put']) !!}
		<div class="col-sm-12">
			<div class="row">
			    <div class="col-lg-6">
			    	<div class="form-group">
	                	<label>Nome: *</label>
		                <input class="form-control" required name="nome">
		            </div>
		            <div class="form-group">
	                	<label>Ano: *</label>
		                <input class="form-control" required name="ano">
		            </div>
		            <div class="form-group">
	                	<label>conjuge:</label>
		                <input class="form-control" name="conjuge">
		            </div>
		            <div class="form-group">
	                	<label>Pai:</label>
		                <input class="form-control" name="pai">
		            </div>
		            <div class="form-group">
	                	<label>Mae:</label>
		                <input class="form-control" name="mae">
		            </div>
			    </div>
			    <div class="col-lg-6">
			    	
			    	<button class="btn btn-success pull-right">Enviar</button>
			    </div>
			</div>
		</div>
	{!!Form::close()!!}
@stop

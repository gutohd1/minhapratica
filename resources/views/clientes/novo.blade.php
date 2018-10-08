@extends('layouts.dashboard')
@section('page_heading','Cadastrar Cliente')
@section('section')
	{!! Form::open(['url' => route('cliente.add'),  'method' => 'put']) !!}
		<div class="col-sm-12">
			<div class="row">
			    <div class="col-lg-6">
			    	<div class="form-group">
	                	<label>Nome: *</label>
		                <input class="form-control" required name="nome">
		            </div>
		            <div class="form-group">
	                	<label>Sobrenome: *</label>
		                <input class="form-control" required name="sobrenome">
		            </div>
		            <div class="form-group">
	                	<label>Email: *</label>
		                <input class="form-control" required name="email">
		            </div>
		            <div class="form-group">
	                	<label>Repetir Email: *</label>
		                <input class="form-control" required name="repetiremail">
		            </div>
		            <div class="form-group">
	                	<label>Nacionalidade: *</label>
		                <input class="form-control" required name="nacionalidade">
		            </div>
			    </div>
			    <div class="col-lg-6">
			    	<div class="form-group">
	                	<label>Endereco: *</label>
		                <input class="form-control" required name="endereco">
		            </div>
		            <div class="form-group">
	                	<label>Complemento:</label>
		                <input class="form-control"  name="complemento">
		            </div>
		            <div class="form-group">
	                	<label>Cidade: *</label>
		                <input class="form-control" required  name="cidade">
		            </div>
		            <div class="form-group">
	                	<label>Estado:</label>
		                <input class="form-control" name="estado">
		            </div>
		            <div class="form-group">
	                	<label>Pais: *</label>
		                <input class="form-control" required name="pais">
		            </div>
			    	<button class="btn btn-success pull-right">Enviar</button>
			    </div>
			</div>
		</div>
	{!!Form::close()!!}
@stop

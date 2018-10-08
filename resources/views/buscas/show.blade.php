@extends('layouts.dashboard')
@section('page_heading','Buscas')
@section('section')
	<div class="panel panel-primary">  
		<div class="panel-heading clearfix">
			<h3 class="panel-title pull-left" style="padding-top: 7.5px;">Andamento</h3>
			<a class="btn btn-default pull-right" href="{{route('busca.add')}}">
		        Nova busca
		    </a>
		</div>			
		<div class="panel-body">
			<div class="col-sm-12">
				<div class="row">
				    <table class="table table-hover">
						<thead>
							<tr>
								<th>id</th>
								<th>Nome</th>
								<th>Data</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($andamento) && count($andamento) > 0)
								@foreach($andamento as $busca)
									<tr>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->id}}</a></td>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->cliente->nome.' '.$busca->cliente->sobrenome}}</a></td>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->created_at}}</a></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			
		</div>
	</div>
	<div class="panel panel-primary">  
		<div class="panel-heading">
			<h3 class="panel-title">Concluidas</h3>
		</div>			
		<div class="panel-body">
			<div class="col-sm-12">
				<div class="row">
				    <table class="table table-hover">
						<thead>
							<tr>
								<th>id</th>
								<th>Nome</th>
								<th>Data</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($concluidas) && count($concluidas) > 0)
								@foreach($concluidas as $busca)
									<tr>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->id}}</a>s</td>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->cliente->nome.' '.$busca->cliente->sobrenome}}</a></td>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->created_at}}</a></td>
									</tr>		
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			
		</div>
	</div>
	<div class="panel panel-primary">  
		<div class="panel-heading">
			<h3 class="panel-title">Canceladas</h3>
		</div>			
		<div class="panel-body">
			<div class="col-sm-12">
				<div class="row">
				    <table class="table table-hover">
						<thead>
							<tr>
								<th>id</th>
								<th>Nome</th>
								<th>Data</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($canceladas) && count($canceladas) > 0)
								@foreach($canceladas as $busca)
									<tr>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->id}}</a></td>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->cliente->nome.' '.$busca->cliente->sobrenome}}</a></td>
										<td><a href="{{route('busca.edit', array('busca_id' => $busca->id))}}">{{$busca->created_at}}</a></td>
									</tr>		
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			
		</div>
	</div>
@stop

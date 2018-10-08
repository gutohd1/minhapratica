@extends('layouts.dashboard')
@section('page_heading','Clientes')
@section('section')
	<div class="panel panel-primary">  
			<div class="panel-heading">
				<h3 class="panel-title">Lista</h3>
				<div class="pull-right">
					<a class="btn btn-default " href="{{route('cliente.add')}}">
	                    <i class="fa fa-user"></i>
	                    <i class="fa fa-plus"></i>
	                </a>
				</div>
			</div>			
			<div class="panel-body">
				<div class="col-sm-12">
					<div class="row">
					    <table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Telefone</th>
									<th>Endereco</th>
									<th>Complemento</th>
									<th>Cidade</th>
									<th>Estado</th>
									<th>Pais</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($clientes) && count($clientes) > 0)
									@foreach($clientes as $cliente)
										<tr>
											<td>{{$cliente->nome.' '.$cliente->sobrenome}}</td>
											<td>{{$cliente->email}}</td>
											<td>+4407399309762</td>
											<td>{{$cliente->endereco1}}</td>
											<td>{{$cliente->endereco2}}</td>
											<td>{{$cliente->cidade}}</td>
											<td>{{$cliente->estado}}</td>
											<td>{{$cliente->pais}}</td>
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

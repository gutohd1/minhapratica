@extends('layouts.dashboard')
@section('page_heading','Provincias')
@section('section')
	{!! Form::open(['url' => route('provincia.comune.update', ['provincia_id' => $provincia_id, 'comune_id' => $comune_id]),  'method' => 'put']) !!}
		<div class="panel panel-primary">  
			<div class="panel-heading">
				<h3 class="panel-title">Panel</h3>
			</div>			
			<div class="panel-body">
				<div class="col-sm-12">
					<div class="row">
					    <div class="col-lg-5">
				            <div class="form-group">
				                <label>Provincias</label>
				                <select class="form-control slcProvincias select2" data-url="{{route('provincia.comune.loadList', ['provincia_id' => 0])}}">
				                    <option>Selecione uma provincia</option>
				                    @if(isset($provincias) && count($provincias) > 0)
				                    	@foreach($provincias as $provincia)
				                    		<option value="{{$provincia->id}}" {{isset($provincia_id) && $provincia_id==$provincia->id?'selected':''}}>{{$provincia->nome}}</option>
				                    	@endforeach
				                    @endif
				                </select>
				            </div>
				            <div class="form-group">
				                <label>Comunes</label>
				                <select class="form-control slcComunes" {{!isset($comunes)?'disabled':''}} data-url="{{route('provincia.comune', ['provincia_id' => 'provincia_id', 'comune_id' => 'comune_id'])}}">
				                    <option>Selecione Provincia</option>
				                    @if(isset($comunes))
				                    	@foreach($comunes as $comune)
				                    		<option value="{{$comune->id}}" {{isset($comune_id) && $comune_id==$comune->id?'selected':''}}>{{$comune->nome}}</option>
				                    	@endforeach
				                    @endif
				                </select>
				            </div>
				            <div class="form-group">
			            		<div id="map" data-lat="{{isset($latitude)?$latitude:'none'}}" data-lng="{{isset($longitude)?$longitude:'none'}}"></div>
		            		</div>
		            		@if($provincia_id !=null && $comune_id != null)
				            	<div class="form-group">
				            		<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">Atualizacoes</h3>
										</div>
										<div class="panel-body">
											atualizacoes
										</div>
									</div>
					           	</div>
				           	@endif
					    </div>
					    <div class="col-lg-7">
					    	@if(isset($provinciaSel))
					    		<div class="panel panel-default">
		  
									<div class="panel-heading">
										<h3 class="panel-title">Regiao & Provincia</h3>
									
									</div>
									
									<div class="panel-body">
							        	<div class="form-group">
						                	<label>Regiao: </label>
							                <p>{{$provinciaSel->regiao_id}}</p>
							            </div>
								        <div class="form-group">
						                	<label>Provincia: </label>
							                <p>{{$provinciaSel->nome}}</p>
							            </div>
							            @if($provinciaSel->emails)
							            	<div class="form-group">
							            		<label>Emails: </label>
							            		<table class="table table-striped emailsDesloqueadosProvinciaTable">
							                		<thead>
								                		<tr>
								                		 	<th>Nome</th>
								                		 	<th>Email</th>
								                		 	<th>Acao</th>
								                		</tr>
							                		</thead>
							                		<tbody>
									            	@foreach($provinciaSel->emails as $email)
									            		<tr data-id="{{$email->id}}" data-reltipo="{{$email->rel_tipo}}">
									            			<td>{{$email->nome_email}}</td>
									                		<td>{{$email->email}}</td>
									                		<td>
										            			<input type="checkbox" {{$email->envio==1?'checked':''}} class="" title="Envio direto" data-placement="top" data-toggle="tooltip" name="direto[{{$email->id}}]">
										            			<a href="javascript:void(0)"><i class="fa fa-unlock emailBlock" title="Bloquear" data-placement="top" data-toggle="tooltip"></i></a>
										            			<a href="javascript:void(0)" class="excluirEmail"><i class="fa fa-trash-o" title="Excluir" data-placement="top" data-toggle="tooltip"></i></a>
									            			</td>
									            		</tr>		
									            	@endforeach
									            		
									            	</tbody>
									            </table>
							            	</div>
							            @endif
							            <div class="form-group">
							            	<a href="javascript:void(0)" data-tipo="provincia" class="btnAddEmail">Adicionar email</a>
							            </div>
						            </div>
						        </div>
					            @if(isset($provinciaSel->comune))
					            	<div class="panel panel-default">
		  
										<div class="panel-heading">
											<h3 class="panel-title">Comune</h3>
										
										</div>
										
										<div class="panel-body">
								            <div class="form-group">
							                	<label>Comune: </label>
								                <p>{{$provinciaSel->comune->nome}}</p>
								            </div>
								            @if(isset($provinciaSel->comune->emails))
								            	<div class="form-group">
								                	<label>Emails: </label>
								                	<table class="table table-striped emailsDesloqueadosComuneTable">
								                		<thead>
									                		<tr>
									                		 	<th>Nome</th>
									                		 	<th>Email</th>
									                		 	<th>Acao</th>
									                		</tr>
								                		</thead>
								                		<tbody>
											                @foreach($provinciaSel->comune->emails as $email)
											                	@if($email->bloqueado == 0)
												                	<tr data-id="{{$email->id}}" data-reltipo="{{$email->rel_tipo}}">
												                		<td>{{$email->nome_email}}</td>
												                		<td>{{$email->email}}</td>
												                		<td>
													            			<input type="checkbox" {{$email->envio==1?'checked':''}} class="" title="Envio direto" data-placement="top" data-toggle="tooltip" name="direto[{{$email->id}}]">
													            			<a href="javascript:void(0)"><i class="fa fa-unlock emailBlock" title="Bloquear" data-placement="top" data-toggle="tooltip"></i></a>
												                			<a href="javascript:void(0)" class="excluirEmail"><i class="fa fa-trash-o" title="Excluir" data-placement="top" data-toggle="tooltip"></i></a>
												                		</td>
												            		</tr>
												            	@endif	
											            	@endforeach
											            	</tbody>
									            	</table>
									            </div>
									            <div class="form-group">
									            	<a href="javascript:void(0)" data-tipo="comune" class="btnAddEmail">Adicionar email</a>
									            </div>
									        </div>
									    </div>
						            @endif
					            @endif
					            <div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Emails bloqueados</h3>
									</div>
									<div class="panel-body">
										<table class="table table-striped emailsBloqueadosTable">
											<thead>
												<tr>
													<th>Name</th>
													<th>Email</th>
													<th>Acao</th>
												</tr>
											</thead>
											<tbody>
												@if(isset($bloqueados))
													@foreach($bloqueados as $email)
														<tr data-id="{{$email->id}}" data-reltipo="{{$email->rel_tipo}}">
									                		<td>{{$email->nome_email}}</td>
									                		<td>{{$email->email}}</td>
									                		<td>
									                			<input type="checkbox" {{$email->envio==1?'checked':''}} class="hidden" title="Envio direto" data-placement="top" data-toggle="tooltip" name="direto[{{$email->id}}]">
										            			<a href="javascript:void(0)"><i class="fa fa-lock emailUnblock" title="Bloquear" data-placement="top" data-toggle="tooltip"></i></a>
									                			<a href="javascript:void(0)" class="excluirEmail"><i class="fa fa-trash-o" title="Excluir" data-placement="top" data-toggle="tooltip"></i></a>
									                		</td>
									            		</tr>
													@endforeach
												@endif
											</tbody>
										</table>
									</div>
								</div>
								<input type="hidden" name="bloqueados" class="emailsBloqueados">
								<input type="hidden" name="desbloqueados" class="emailsDesbloqueados">
								<input type="hidden" name="excluidos" class="emailsExcluidos">	
				            @endif
					    </div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				@if($provincia_id !=null && $comune_id != null)
					<div class="text-right">
			            <button type="reset" class="btn btn-default">Limpar</button>
						<button type="submit" class="btn btn-success">Salvar</button>
		            </div>
	            @endif
			</div>
		</div>
	{!! Form::close() !!}
@stop

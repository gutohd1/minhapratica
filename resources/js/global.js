$(document).on('change', '.slcProvincias', function(){
	var element = $(this);
	var url = element.data('url').replace('0', element.val());
	$.ajax({
		method: "GET",
		url: url,
		//data: { name: "John", location: "Boston" }
		success: function(data){
			//alert(data);
			var comunes = element.closest('form').find('.slcComunes');
			comunes.html('');
			comunes.append(data);
			comunes.prop('disabled', '');
		}
	});
});
$('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
});
$(document).on('change', '.slcComunes', function(){
	var element = $(this);
	var url = element.data('url').replace('provincia_id', $('.slcProvincias').val()).replace('comune_id', element.val());
	if($.isNumeric($('.slcProvincias').val()) && $.isNumeric(element.val())){
		window.location.replace(url);
	}
	$/*.ajax({
		method: "GET",
		url: url,
		//data: { name: "John", location: "Boston" }
		success: function(data){
			//alert(data);
			var comunes = element.closest('form').find('.slcComunes');
			comunes.html('');
			comunes.append(data);
			comunes.prop('disabled', '');
		}
	});*/
});
var modificado = false;
var validaModificacoes = function(){
	//criar aqui as validacoes para informar ao usuario que ele deve salvar a pagina
}
$(document).on('click', '.emailBlock', function(){
	var element = $(this);
	var aExcluir = Array();
	if($.trim($('.emailsBloqueados').val()) != ''){
		aExcluir = $('.emailsBloqueados').val().split(',');	
	}
	element.closest('tr').hide('slow', function(){
		aExcluir.push($(this).data('id'));
		element.removeClass('emailBlock').addClass('emailUnblock').removeClass('fa-unlock').addClass('fa-lock');
		element.closest('td').find('input').addClass('hidden');
		$('.emailsBloqueadosTable tbody').append($(this));
		$(this).show('slow');
		$('.emailsBloqueados').val(aExcluir.join(','));
		modificado = true;
		validaModificacoes();
	});
});
$(document).on('click', '.emailUnblock', function(){
	var element = $(this);
	var aIncluir = Array();
	if($.trim($('.emailsDesbloqueados').val()) != ''){
		aIncluir = $('.emailsDesbloqueados').val().split(',');	
	}
	element.closest('tr').hide('slow', function(){
		aIncluir.push($(this).data('id'));
		element.removeClass('emailUnblock').addClass('emailBlock').removeClass('fa-lock').addClass('fa-unlock');
		element.closest('td').find('input').removeClass('hidden');
		if($(this).data('reltipo') == 0){
			$('.emailsDesloqueadosProvinciaTable tbody').append($(this));
		}else if($(this).data('reltipo') == 1){
			$('.emailsDesloqueadosComuneTable tbody').append($(this));
		}
		$(this).show('slow');
		//alert(aIncluir.join(','));
		$('.emailsDesbloqueados').val(aIncluir.join(','));
		modificado = true;
		validaModificacoes();
	});
});
function initMap() {
	var element = $('#map');
	if(element.length > 0){
		if(element.data('lat') != 'none' && element.data('lng') != 'none'){
			var comuneSlc = $.trim($('.slcComunes').find(':selected').html());
			var myLatLng = {lat: element.data('lat'), lng: element.data('lng')};

			// Create a map object and specify the DOM element for display.
			var map = new google.maps.Map(document.getElementById('map'), {
			  center: myLatLng,
			  scrollwheel: false,
			  zoom: 17
			});

			// Create a marker and set its position.
			var marker = new google.maps.Marker({
			  map: map,
			  position: myLatLng,
			  title: comuneSlc
			});
		}
	}
}
$(document).on('click', '.btnAddEmail', function(){
	var element = $(this);
	var tbody = element.closest('.panel-body').find('table tbody');
	if(tbody.length > 0){
		var tipo = element.data('tipo');
		var line = '<tr>' +
	        			'<td class="tdComune">' +
	        				'<input type="text" class="form-control" placeholder="Nome" name="'+tipo+'Nome[]">' +
	        			'</td>' +
	        			'<td>' +
			                '<input type="text" class="form-control" placeholder="Email" name="'+tipo+'Email[]">' +
	        			'</td>' +
	        			'<td>' +
			                '<a href="javascript:void(0)" class="excluirNovoEmail"><i class="fa fa-trash-o" title="Excluir" data-placement="top" data-toggle="tooltip"></i></a>' +
	        			'</td>' +
	        		'</tr>';
		tbody.append(line);
	}
});
$(document).on('click', '.excluirNovoEmail', function(){
	var element = $(this);
	element.closest('tr').remove();
});
$(document).on('click', '.excluirEmail', function(){
	var element = $(this);
	var excluidosField = $('.emailsExcluidos');
	var aExcluir = new Array();
	if($.trim(excluidosField.val()) != ''){
		aExcluir = excluidosField.val().split(',');	
	}
	element.closest('tr').hide('slow', function(){
		aExcluir.push($(this).data('id'));
		$(this).remove();
		excluidosField.val(aExcluir.join(','));
		modificado = true;
		validaModificacoes();
	});
});
$(document).on('click', '.adicionarComentario', function(e){
	var element = $(this);//
	var comentario = $('[name="add_observacoes"]');
	var observacoes = $('.observacoes').find('tbody');
	var url = comentario.data('url');
	var token = comentario.data('token');
	var data = new FormData();
    data.append( 'comment', comentario.val() );
	data.append( '_token', token );
    $.ajax({
        url: url,
        data: data,
        processData: false,
  		contentType: false,
  		dataType : "json",
        type: 'POST',
        success: function ( data ) {
            console.log( data );
            if(data.status == 'success'){
            	observacoes.append(data.html);
            	comentario.val('');
            }
        }
    });
	//var code = e.keyCode || e.which;
	//if(code == 13) { //Enter keycode
		//observacoes.append('\n'+comentario.val());
		//comentario.val('');
	//}
});
$(document).on('change', 'select[name="situacao"]', function(e){
	var element = $(this);
	if(element.val() == 4){
		var question = $('[name="solicitacao"]');
		question.prop('disabled', false);
		question.parent().removeClass('hidden');
	}
});
$(document).on('change', 'select[name="solicitacao"]', function(e){
	var element = $(this);
	var questionOne = $('[name="meio_solicitacao"]');
	if(element.val() == 2){
		questionOne.prop('disabled', false);
		questionOne.parent().removeClass('hidden');
	}else {
		questionOne.parent().addClass('hidden');
		questionOne.prop('disabled', true);
	}
});
$(document).on('change', 'select[name="meio_solicitacao"]', function(e){
	var element = $(this);
	var questionOne = $('[name="solicitado"]');
	var questionTwo = $('[name="enivar"]');
	if(element.val() == 2){
		questionTwo.parent().addClass('hidden');
		questionTwo.prop('disabled', true);
		questionOne.prop('disabled', false);
		questionOne.parent().removeClass('hidden');
	}else{
		questionOne.parent().addClass('hidden');
		questionOne.prop('disabled', true);
		questionTwo.prop('disabled', false);
		questionTwo.parent().removeClass('hidden');
	}
});

$(function(){
	
	initialize();
	
});

function initialize() {
	
	var latitud 	= $('#latitud').val();
	var longitud	= $('#longitud').val();
	
	 var mapOptions = {

			center : new google.maps.LatLng(latitud, longitud),
			zoom : 18,
			mapTypeId : google.maps.MapTypeId.ROADMAP

	 };

	 var map = new google.maps.Map(document.getElementById("map"),mapOptions);

	 //Poner un Marker
	
	 var marker = new google.maps.Marker({
			position : new google.maps.LatLng(latitud, longitud),
			map : map,
			title : '',
			draggable: true
			
	 });

   var contentString = '<div id="contentx" class="w320">';
   contentString += '<div id="siteNotice">';
   contentString += '</div>';
   contentString += '<div id="bodyContent">';
   contentString += '<img src="<?php echo base_url()?>images/logo-t&s.png" class="fl mr_5" width="100"/>';
   contentString += '<p><h1 id="firstHeading" class="firstHeading">T&SCargo</h1><b>Somos una empresa de transporte logistico integral con cobertura a nivel nacional tanto terrestre, fluvial y aéreo. ';
   contentString += '</p>';

	 var infowindow = new google.maps.InfoWindow({
			content : contentString
	 });
	
	 google.maps.event.addListener(marker, 'click', function() {
	 });
	 /*
	 google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
	 });
	 */
}



function adicionar_form(){
	
	var serializedformdata;
	//var iIdFormulario = $('#iIdFormulario').val();
	
	serializedformdata = '';
	
	return serializedformdata;
	
}


function adicionar_form(){
	
	var serializedformdata;
		
	serializedformdata = "";
		
	return serializedformdata;
}

function desabilitar(){
	
}

function guardar_serialize(form){
	
	var r_validation=validar_formulario(form);
	if(r_validation>0){
		dialogo_zebra("Falta Ingresar Datos Obligatorios",'warning','Alerta de '+gtitle,300,'');
		return false;	
	}
	
	var serializedformdata = $('#'+form).serialize();
	
	serializedformdata += adicionar_form(serializedformdata);
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	$('#button_agregar').attr('disabled',true).val('Procesando ...').addClass("w100");
	$.ajax({
		type:'POST',
		url: $("#"+form).attr('action'),
		data:serializedformdata,
		success: function(data) {
			if(data > 0){
				//dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,500,gurl+gcontroller+'/'+gmethod);
				var iIdLocal = $('#iIdLocal').val();
			dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'locales/'+gcontroller+'/'+gmethod+'/'+iIdLocal);
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
			}
			$("#AjaxLoading").css("display","none");
			precarga('none');
			$('#button_agregar').attr('disabled',false).val('Buscar').removeClass("w100");
		}
	 });	
	
}

$(function(){
	$(".menu__formulario--accordion").accordion();
	$( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
		if (jqxhr.status == 401) {
			window.location.replace("./");
		}
	});
});


function adicionar_form(){
	
	var serializedformdata;
	//var iIdFormulario = $('#iIdFormulario').val();
	
	serializedformdata = '';
	
	return serializedformdata;
	
}


function fun_AjaxUpload_galeria(obj){
	
	$("#cargan").css("display","block");
	
	new AjaxUpload($(obj), {
		action: gurl + "locales/registro/upload_galeria",
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
		},
		onComplete: function(file, response) {
			if(response == 'success'){
				var newRow = "";
				newRow += "<div class='galeria h_64 bkg_C9C9C9 w100p relativo'>";
				newRow += "<img class='fl' src='"+gurl+"public/images/galeria/"+file+"' width='321' height='203' />";
				newRow += "<input type='hidden' name='vimagen' value='"+file+"' class='bordercaja' validar='ok' />";
				newRow += "<a class='edit_img' onclick='remove_img(this)'></a>";
				newRow += "<a class='delete_img' onclick='remove_img(this)'></a>";
				newRow += "<div class='fl ml_70'>";
				newRow += "<label class='w100 fl'>Comentario :</label>";
				newRow += "<textarea rows='3' name='vDescripcion' class='w310 h_100 fl fs_12'>comentario sobre la imagen</textarea>";
				newRow += "</div>";
				newRow += "<div class='clear mb_10'></div>";
				newRow += "</div>";
				
				$('#resultado_imagenes').append(newRow);
				
				//alert_success(400, 200, "Archivo "+file+" Subido Correctamente !!!","");
			}
			
			$("#cargan").css("display","none");
			
		}
  	});
	
}

function fun_AjaxUpload_documento(obj){
	
	$("#cargan").css("display","block");
	
	new AjaxUpload($(obj), {
		action: gurl + "locales/registro/upload_documento",
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
		},
		onComplete: function(file, response) {
			if(response == 'success'){
				var newRow = "";
				newRow += "<div class='documento'>";
				newRow += "<img class='fl' src='"+gurl+"public/images/u149_normal.png' width='16' height='16' />";
				newRow += "<input type='text' name='vNombre' value='"+file+"' class='bordercaja al w320 lh_20 mb_2 ml_10' validar='ok' style='background-color:transparent;border:0px'/>";
				newRow += "<div class='fr'>";
                newRow += "<a class='delete_img fl' style='position:static' onclick='remove_img(this)'></a>";
				newRow += "<label class='fl label w50 lh_20 mb_2 ml_10'>Eliminar</label>";
				newRow += "</div>";
				newRow += "</div>";
                newRow += "<div class='clear'></div>";
					
				$('#resultado_documentos').append(newRow);
				
				//alert_success(400, 200, "Archivo "+file+" Subido Correctamente !!!","");
			}
			
			$("#cargan").css("display","none");
			
		}
  	});
	
}


var detalle 		= new Array();
var sub_detalle 	= new Array();
var sub_detalle2 	= new Array();

function adicionar_form(){
	
	var serializedformdata;
		
	serializedformdata = "";
		
	return serializedformdata;
}

function data_array(){
	
	var flag = 0;
	
	$('.galeria').each(function(){
		detalle.push({
			"vDescripcion"	: $(this).find("textarea[name=vDescripcion]").val(),
			"vimagen"		: $(this).find("input[name=vimagen]").val()
		});
	});	
	
	if(detalle.length == 0){
		
		alert("Debe ingresar una Muestra");
		
		flag = 1;
	}
	
	return flag;
	
}

function desabilitar(){
	
}

function guardar_serialize_array_imagen(form){
	
	if (data_array() > 0){
		for(var i = detalle.length - 1; i>=0 ;i--){
		detalle.splice(i,1);
		}
		for(var i = sub_detalle.length - 1; i>=0 ;i--){
				sub_detalle.splice(i,1);
		}
		for(var i = sub_detalle2.length - 1; i>=0 ;i--){
				sub_detalle2.splice(i,1);
		}
			return false;
	}
	
	desabilitar();
	
	var serializedformdata = $('#'+form).serialize();
	//alert(serializedformdata);
	serializedformdata += adicionar_form(serializedformdata);
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	$('#button_agregar').attr('disabled',true).val('Procesando ...');
	
	$.post($("#"+form).attr('action'),{'formdata': serializedformdata,'detalle':detalle,'sub_detalle':sub_detalle,'sub_detalle2':sub_detalle2},function(data){
																																						
		for(var i = detalle.length - 1; i>=0 ;i--){
			detalle.splice(i,1);
		}
		for(var i = sub_detalle.length - 1; i>=0 ;i--){
				sub_detalle.splice(i,1);
		}
		for(var i = sub_detalle2.length - 1; i>=0 ;i--){
				sub_detalle2.splice(i,1);
		}
		
		if(data == 'success'){
			var iIdLocal = $('#iIdLocal').val();
			dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'locales/'+gcontroller+'/'+gmethod+'/'+iIdLocal);
		}else{
			dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
		}
		
		$("#AjaxLoading").css("display","none");
		precarga('none');
		$('#button_agregar').attr('disabled',false).val('Guardar');
		
	});
	
}



function guardar_serialize(form, creacion = false, xxfase = 3, xxfase_id = 2){
	console.log("d", form);
	var redirect = '';
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
		    if(creacion){
                redirect = gurl+'locales/'+gcontroller  +'/ver_local/' +data+'?fase='+xxfase+'&fase_id='+xxfase_id;
		    }
			if(data > 0){
				//,gurl+'locales/'+gcontroller+'/'+gmethod+'/'+data
				dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300, redirect);
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300,'');
			}
			$("#AjaxLoading").css("display","none");
			precarga('none');
			$('#button_agregar').attr('disabled',false).val('Buscar').removeClass("w100");
		}
	 });	
	
}

function recuperar_select_controller_id_ubigeo_inicio(idorigen,controlador,destino,seleccionado, aux = 0){
	
	console.log(aux);
	console.log("rrr");
	var id 		= $("#"+seleccionado+" option:selected").attr('vCodigo');
	var idDpto  = $("#fase_3_fase_id_2_departamento option:selected").attr('vCodigo');
	
	if(seleccionado == 'fase_3_fase_id_2_departamento'){
		$('#fase_3_fase_id_2_distrito').html('');
		$('#fase_3_fase_id_2_ubigeo').val('');
		$('#fase_3_fase_id_2_distrito').append($('<option></option>').val('').html('[ --Seleccionar-- ]'));
	}
	
	if(seleccionado == 'fase_3_fase_id_2_provincia'){
		$('#fase_3_fase_id_2_ubigeo').val('');
	}
	
	
	$.post(controlador,{id:id, idDpto:idDpto},function(data){
			$('#'+destino).html('');
			$('#'+destino).append($('<option></option>').val('').html('[ --Seleccionar-- ]'));
			$.each(data, function(i,obj)
			{
				var option = '';
				var selected = '';
				if (seleccionado == obj['id']) { selected = "selected='selected'";}
				option = "<option vCodigo='"+obj['vCodigo']+"' "+selected+"></option>";
				$('#'+destino).append($(option).val(obj['id']).html(obj['vNombre']));
				if(obj['id'] == aux && destino == 'fase_3_fase_id_2_provincia'){
				    $("#fase_3_fase_id_2_provincia").val(aux).change();
				}

				if(obj['id'] == aux && destino == 'fase_3_fase_id_2_distrito'){
				    $("#fase_3_fase_id_2_distrito").val(aux).change();
				}
			});
		}, 'json');
		
			

          		
}


function recuperar_select_controller_id_ubigeo(idorigen,controlador,destino,seleccionado){
	
	var id = idorigen;
	
	$.post(controlador,{id:id},function(data){
		
			$('#'+destino).html('');
			$('#'+destino).append($('<option></option>').val('').html('[ --Seleccionar-- ]'));
			$.each(data, function(i,obj)
			{
				var option = '';
				var selected = '';
				if (seleccionado == obj['id']) { selected = "selected='selected'";}
				option = "<option vCodigo='"+obj['vCodigo']+"' "+selected+"></option>";
				$('#'+destino).append($(option).val(obj['id']).html(obj['vNombre']));
				
			}); 
			
		}, 'json');
	
	recuperar_ubigeo();
		
}

function recuperar_ubigeo(){
	
	var ubigeo_iIdDepartamento 	= '';
	var ubigeo_iIdProvincia 	= '';
	var ubigeo_iIdDistrito 		= '';	
	if($("#fase_3_fase_id_2_departamento option:selected").attr('vCodigo') != null)ubigeo_iIdDepartamento = $("#fase_3_fase_id_2_departamento option:selected").attr('vCodigo').replace(' ','');
	if($("#fase_3_fase_id_2_provincia option:selected").attr('vCodigo') != null)ubigeo_iIdProvincia = $("#fase_3_fase_id_2_provincia option:selected").attr('vCodigo').replace(' ','');
	if($("#fase_3_fase_id_2_distrito option:selected").attr('vCodigo') != null)ubigeo_iIdDistrito = $("#fase_3_fase_id_2_distrito option:selected").attr('vCodigo').replace(' ','');
	
	var ubigeo = ubigeo_iIdDepartamento+ubigeo_iIdProvincia+ubigeo_iIdDistrito;
	$('#fase_3_fase_id_2_ubigeo').val(ubigeo);
	
}

function exportar_local_principal(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/pdf_local_principal/',
	data:$("#"+form).serialize(),
	success: function(response) {
		if(!response){
			window.location.reload();
		}
		var obj=eval('('+response+')');
		var archivo=obj.archivo;
		location.href=gurl+"locales/registro/descargar/"+archivo;
	},beforeSend:function(){
			 $("#cargan").css("display","block");
	},complete:function(){
			$("#cargan").css("display","none");
	}
	});
	
}

function cargarFormularioCampos(fase, fase_id, fase_tres_id, fase_cuatro_id, fase_cinco_id) {
	$.ajax({
		type: 'POST',
		url: 'registro/formularios_campos',
		data: { fase, fase_id, fase_tres_id, fase_cuatro_id, fase_cinco_id },
		success: function(response) {
			if(!response){
				window.location.reload();
			} 
			$("#box__formulario--campos").html(response);
		}
	});
}

function cargarEditFormularioCampos(fase, fase_id, fase_tres_id, fase_cuatro_id, fase_cinco_id) {
	$.ajax({
		type: 'POST',
		url: addRetroUrl + 'registro/formularios_campos_editar/' + iIdLocal,
		data: { fase, fase_id, fase_tres_id, fase_cuatro_id, fase_cinco_id,  'formulario_id' : 1 },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#box__formulario--campos").html(response);
		}
	});
}



$(function(){
	
});


function adicionar_form(){
	
	var serializedformdata;
	//var iIdFormulario = $('#iIdFormulario').val();
	
	serializedformdata = '';
	
	return serializedformdata;
	
}


function fun_AjaxUpload_galeria(obj){
	console.log(obj);
	new AjaxUpload($(obj), {
		action: gurl + "locales/registro/upload_galeria",
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
			$("#AjaxLoading").css("display","block");
			precarga('block');
		},
		onComplete: function(file, response) {
			if(response == 'success'){
				var newRow = "";
				newRow += "<div class='galeria h_64 bkg_C9C9C9 w100p relativo'>";
				newRow += "<img class='fl' src='"+gurl+"public/images/galeria/"+file+"' width='321' height='203' />";
				newRow += "<input type='hidden' id='upload_img' name='vimagen' value='"+file+"' class='bordercaja' validar='ok' />";
				if(in_array(3,opciones)){
				newRow += "<a class='edit_img'  onclick='fun_AjaxUpload_galeria_update(this)'></a>";
				}
				if(in_array(4,opciones)){
				newRow += "<a class='delete_img' onclick='remove_img(this)'></a>";
				}
				newRow += "<div class='fl ml_70'>";
				newRow += "<label class='w100 fl'>Comentario :</label>";
				newRow += "<textarea rows='3' name='vDescripcion' class='w310 h_100 fl fs_12'>comentario sobre la imagen</textarea>";
				newRow += "</div>";
				newRow += "<div class='clear mb_10'></div>";
				newRow += "</div>";
				$('#resultado_imagenes').append(newRow);
			}
			
			$("#AjaxLoading").css("display","none");
			precarga('none');
			
		}
  	});

  	$("[name=file]").trigger("click");
	
}

function fun_AjaxUpload_galeria_update(obj){
	
	new AjaxUpload($(obj), {
		action: gurl + "locales/registro/upload_galeria",
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
			$("#AjaxLoading").css("display","block");
			precarga('block');
		},
		onComplete: function(file, response) {
			console.log(file);
			if(response == 'success'){
				$(obj).parent().find('img').attr('src',gurl+'public/images/galeria/'+file);
				$(obj).parent().find('input[name=vimagen]').val(file);
			}
			
			$("#AjaxLoading").css("display","none");
			precarga('none');
			
		}
  	});
	
	$("[name=file]").trigger("click");
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
			//dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,500,'');
			var iIdLocal = $('#iIdLocal').val();
			dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'locales/'+gcontroller+'/imagenes/'+iIdLocal);
			
			//Buscar();
		}else{
			dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
		}
		
	});
	
}



function guardar_serialize(form){
	
	var r_validation=validar_formulario(form);
	if(r_validation>0){
		//dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'locales/'+gcontroller+'/'+gmethod);
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
				dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'locales/'+gcontroller+'/'+gmethod+'/'+data);
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
			}
			$("#AjaxLoading").css("display","none");
			$('#button_agregar').attr('disabled',false).val('Buscar').removeClass("w100");
			precarga('none');
		}
	 });	
	
}

function recuperar_select_controller_id_ubigeo_inicio(idorigen,controlador,destino,seleccionado){
	
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
	if($("#departamento option:selected").attr('vCodigo') != null)ubigeo_iIdDepartamento = $("#departamento option:selected").attr('vCodigo');
	if($("#provincia option:selected").attr('vCodigo') != null)ubigeo_iIdProvincia = $("#provincia option:selected").attr('vCodigo');
	if($("#distrito option:selected").attr('vCodigo') != null)ubigeo_iIdDistrito = $("#distrito option:selected").attr('vCodigo');
	
	var departamento = $("#departamento").val();
	var provincia = $("#provincia").val();
	var distrito = $("#distrito").val();
	$.post(gurl+'locales/registro/recuperar_local_serie',{departamento:departamento,provincia:provincia,distrito:distrito},function(data){
		var ubigeo = ubigeo_iIdDepartamento+ubigeo_iIdProvincia+ubigeo_iIdDistrito+'-'+data;
		$('#codigo_de_local').val(ubigeo);	
	});
	
}

function remove_img(obj){
	dialogo_zebra_eliminar("Estas Seguro de Eliminar el documento",'question','Alerta de '+gtitle,300,'',obj);
}

function dialogo_zebra_eliminar(msg,type,title,width,enlace,obj){
	$.Zebra_Dialog(msg, {
		'type':  type,
		'title':    false,
		'buttons': [
					{caption:'Si', callback: function() {
															$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();
															$(obj).parent().remove();
														}
					}
					,{caption:'No', callback: function() {$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();}}
					],
		'width': width,
		'overlay_opacity': 0.5
	});
	$('.ZebraDialog_Buttons').css('width','150px');
}

function exportar_local_imagen(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/pdf_local_imagen/',
	data:$("#"+form).serialize(),
	success: function(response) {
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


function in_array(needle, haystack, argStrict) {

  var key = '',
    strict = !! argStrict;
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}



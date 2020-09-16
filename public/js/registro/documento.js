$(function(){
	Buscar();
	$(".menu__formulario--accordion").accordion()
});

function cargarEditFormularioCampos(fase, fase_id, fase_tres_id, fase_cuatro_id, fase_cinco_id) {
	$.ajax({
		type: 'POST',
		url: '../formularios_campos_editar/' + iIdLocal + '/true/',
		data: { fase, fase_id, fase_tres_id, fase_cuatro_id, fase_cinco_id, 'formulario_id' : 2 },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#box__formulario--campos").html(response);
		}
	});
}

function adicionar_form(){
	
	var serializedformdata;
	//var iIdFormulario = $('#iIdFormulario').val();
	
	serializedformdata = '';
	
	return serializedformdata;
	
}

function fun_AjaxUpload_documento(obj) {
	new AjaxUpload($(obj), {
		action: gurl + "locales/registro/upload_documento",
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, ext) {
			/*
			if (! (ext && /^(doc|docx|pdf)$/.test(ext))){
				dialogo_zebra("S&oacute;lo se permiten Documentos .doc, .docx o .pdf",'warning','Alerta de '+gtitle,300,'');
				return false;
			} else {
			*/
			$("#AjaxLoading").css("display","block");
			precarga('block');
		},
		onComplete: function(file, response) {
			if(response == 'success'){
				var ext = file.split('.');
				var icono_img = '';
				if(ext[1] == 'doc' || ext[1] == 'docx')icono_img = 'u149_normal.png';
				if(ext[1] == 'pdf')icono_img = 'u46_normal.png';
				var newRow = "";
				newRow += "<div class='documento'>";
				newRow += "<img class='fl' src='"+gurl+"public/images/"+icono_img+"' width='16' height='16' />";
				newRow += "<input type='text' name='vDocumento' value='"+file+"' class='bordercaja al w320 lh_20 mb_2 ml_10' validar='ok' style='background-color:transparent;border:0px'/>";
				newRow += "<div class='fr'>";
                newRow += "<a class='delete_img fl' style='position:static' onclick='remove_img(this)'></a>";
				newRow += "<label class='fl label w50 lh_20 mb_2 ml_10 pointer' onclick='remove_img(this)'>Eliminar</label>";
				newRow += "</div>";
				newRow += "</div>";
                newRow += "<div class='clear'></div>";
					
				$('#resultado_documentos').append(newRow);
			}
			
			$("#AjaxLoading").css("display","none");
			precarga('none');
			
		}
  	});
	
}

function remove_img(obj){
	dialogo_zebra_eliminar("Estas Seguro de Eliminar el documento",'question','Alerta de '+gtitle,300,'',obj);
}

function eliminar_registro(id){
	dialogo_zebra_eliminar_proceso("Estas Seguro de Eliminar el documento",'question','Alerta de '+gtitle,300,'',id,'locales/registro/eliminar_documento');
}

function dialogo_zebra_eliminar(msg,type,title,width,enlace,obj){
	$.Zebra_Dialog(msg, {
		'type':  type,
		'title':    false,
		'buttons': [
					{caption:'Si', callback: function() {
															$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();
															$(obj).parent().parent().remove();
														}
					}
					,{caption:'No', callback: function() {$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();}}
					],
		'width': width,
		'overlay_opacity': 0.5
	});
	$('.ZebraDialog_Buttons').css('width','150px');
}

function dialogo_zebra_eliminar_proceso(msg,type,title,width,enlace,id,proceso){
	$.Zebra_Dialog(msg, {
		'type':  type,
		'title':    false,
		'buttons': [
			{
				caption:'Si', callback: function() {
				$.post(gurl+proceso,{id:id},function(data){
					$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();
						dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
						Buscar();
					});
					//$(obj).parent().parent().remove();
				}
			}
			, {caption:'No', callback: function() {$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();}}
		],
		'width': width,
		'overlay_opacity': 0.5
	});
	$('.ZebraDialog_Buttons').css('width','150px');
}

function fun_AjaxUpload_documento_proceso(obj, id, fase, fase_id) {
	new AjaxUpload($(obj), {
		action: gurl + "locales/registro/update_detalledocumento",
		data:  {iIdDetalleDocumento : id},
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
			$("#AjaxLoading").css("display","block");
			precarga('block');
		},
		onComplete: function(file, response) {
			if(response == 'success'){
				dialogo_zebra("Se Actualizo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
				if (fase == undefined) {
					Buscar();
				}
			}
			
			$("#AjaxLoading").css("display","none");
			precarga('none');
			
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
	
	$('.documento').each(function(){
		detalle.push({
			"vDocumento"	: $(this).find("input[name=vDocumento]").val()
		});
	});	
	
	if(detalle.length == 0){
		flag = 1;
	}
	
	return flag;
	
}

function desabilitar(){
	
}

function guardar_serialize_array(form){
	
	var r_validation=validar_formulario(form);
	
	if(r_validation>0){
		for(var i = detalle.length - 1; i>=0 ;i--){
			detalle.splice(i,1);
		}
		for(var i = sub_detalle.length - 1; i>=0 ;i--){
				sub_detalle.splice(i,1);
		}
		for(var i = sub_detalle2.length - 1; i>=0 ;i--){
				sub_detalle2.splice(i,1);
		}
		dialogo_zebra("Falta Ingresar Datos Obligatorios",'warning','Alerta de '+gtitle,300,'');
		return false;	
	}
	
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
		dialogo_zebra("Falta Ingresar Documentos Obligatorios",'warning','Alerta de '+gtitle,300,'');
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
			dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
			Buscar();
			$('.documento').remove();
		}else{
			dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300, '');
		}
		
		$("#AjaxLoading").css("display","none");
		precarga('none');
		$('#button_agregar').attr('disabled',false).val('Importar');
		
	});
	
}


function guardar_serialize(form){
	console.log("d", form);
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
		    console.log(data);
			if(data > 0){
				//,gurl+'locales/'+gcontroller+'/'+gmethod+'/'+data
				dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300,'');
			}
			$("#AjaxLoading").css("display","none");
			precarga('none');
			$('#button_agregar').attr('disabled',false).val('Buscar').removeClass("w100");
		}
	 });	
	
}

function recuperar_iIdDocumento(){
	
	var iIdCategoria = $('#iIdCategoria').val();
	$.post(gurl+'locales/registro/recuperar_iIdDocumento',{iIdCategoria:iIdCategoria},function(data){
		$('#iIdDocumento').val(data);
	});
	
}

function open_detalle(obj){
	
	var abierto = $(obj).attr('abierto');
	if(abierto == 1){
		$(obj).parent().parent().next('div').hide();
		$(obj).attr('abierto','2');
	}
	if(abierto == 2){
		$(obj).parent().parent().next('div').show();
		$(obj).attr('abierto','1');
	}
	
}

function agregar_registro(width,url,frm){
	$.post(gurl+url,{} ,
        function(data){
			 dialogo_zebra_agregar(width,data,frm);
        }
   );
}

function dialogo_zebra_agregar(width,msg,frm){
	$.Zebra_Dialog(msg, {
		'type':  '',
		'title':    false,
		'buttons': [
					{caption:'Guardar', callback: function() {
														$.ajax({
															type:'POST',
															url: $("#"+frm).attr('action'),
															data:$("#"+frm).serialize(),
															success: function(response) {
																$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();
																setTimeout(function(){
																	if(response == 'success'){
																		dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
																		Buscar_combo('locales/registro/recuperar_categoria','iIdCategoria');
																	}else{
																		dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
																	}																	
																},500);
																
															}
														 });
														}
					}
					,{caption:'Cancelar', callback: function() {$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();}}
					],
		'width': width,
		'overlay_opacity': 0.5
	});
	$('.ZebraDialog_Buttons').css('width','150px');
}

function Buscar_combo(controlador,destino){
	
	$.post(gurl+controlador,{},function(data){
			$('#'+destino).html('');
			$('#'+destino).append($('<option></option>').val('').html('[ --Seleccionar-- ]'));
			$.each(data, function(i,obj){
				$('#'+destino).append($('<option></option>').val(obj['id']).html(obj['vNombre']));
			}); 
		}, 'json');
		
}

function exportar_local_documento(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/pdf_local_documento/',
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


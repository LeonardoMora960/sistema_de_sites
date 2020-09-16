


$(function(){
	
	autocomplete__AjaxBusqueda_nombre();
	autocomplete__AjaxBusqueda_dni();
	autocomplete__AjaxBusqueda_usuario();
	//Buscar();	
	
});


var detalle 		= new Array();
var sub_detalle 	= new Array();
var sub_detalle2 	= new Array();

function adicionar_form(){
	
	var serializedformdata;
	
	var iIdUsuario = $('#iIdUsuario').val();
	
	serializedformdata = "&iIdUsuario="+iIdUsuario;
		
	return serializedformdata;
}

function data_array(){
	
	var flag = 0;
	
	$('.fila').each(function(){
		detalle.push({
			"iIdSubModulo"	: $(this).attr("iIdSubModulo")
		});
		
		var sub_tempdetalle = new Array();
		var sub_iIdOpciones	= new Array();
		
		$(this).find("input[type='checkbox']").each(function(){
			var iPermiso = 0;
			if($(this).is(':checked')==true)iPermiso = 1
			sub_iIdOpciones.push({
				"iIdOpciones"	: $(this).attr('name'),
				"iPermiso"		: iPermiso
			});
		});
		
		if(sub_iIdOpciones.length > 0){
			for(var i=0;i<sub_iIdOpciones.length;i++){
				sub_tempdetalle.push({
					"iIdOpciones"	: sub_iIdOpciones[i]["iIdOpciones"],
					"iPermiso"		: sub_iIdOpciones[i]["iPermiso"],
				});
			}
		}
		
		sub_detalle.push(sub_tempdetalle);
		delete sub_tempdetalle;	
	
	});	
		
	if(detalle.length == 0){
		//alert("Debe ingresar una Muestra");
		flag = 1;
	}
	
	return flag;
	
}

function desabilitar(){
	
}


function autocomplete__AjaxBusqueda_nombre(){
	
	$("#nombre").autocomplete({
   minLength: 1,
   delay : 400,
   source: function(request, response) {
    $.ajax({
      url:   gurl+'usuario/'+gcontroller+"/recuperar_codigo_usuario_x_nombre/",
      data:  {
      mode : "ajax",
      component : "consearch",
      searcharg : "company",
      task : "display",
      limit : 15,
      term : request.term
      },
      dataType: "json",
      success: function(data)  {
      response(data);
      }
      })
      },select:  function(e, ui) { 
		
		var iIdUsuario = ui.item.iIdUsuario;
		$('#iIdUsuario').val(iIdUsuario);

      }
    });	
	
}

function autocomplete__AjaxBusqueda_dni(){
	
	$("#dni").autocomplete({
   minLength: 1,
   delay : 400,
   source: function(request, response) {
    $.ajax({
      url:   gurl+'usuario/'+gcontroller+"/recuperar_codigo_usuario_x_dni/",
      data:  {
      mode : "ajax",
      component : "consearch",
      searcharg : "company",
      task : "display",
      limit : 15,
      term : request.term
      },
      dataType: "json",
      success: function(data)  {
      response(data);
      }
      })
      },select:  function(e, ui) { 
		
		var iIdUsuario = ui.item.iIdUsuario;
		$('#iIdUsuario').val(iIdUsuario);

      }
    });	
	
}


function autocomplete__AjaxBusqueda_usuario(){
	
	$("#usuario").autocomplete({
   minLength: 1,
   delay : 400,
   source: function(request, response) {
    $.ajax({
      url:   gurl+'usuario/'+gcontroller+"/recuperar_codigo_usuario_x_usuario/",
      data:  {
      mode : "ajax",
      component : "consearch",
      searcharg : "company",
      task : "display",
      limit : 15,
      term : request.term
      },
      dataType: "json",
      success: function(data)  {
      response(data);
      }
      })
      },select:  function(e, ui) { 
		
		var iIdUsuario = ui.item.iIdUsuario;
		$('#iIdUsuario').val(iIdUsuario);

      }
    });	
	
}

function Buscar(page,nav){
	
	var r_validation=validar_formulario(gform);
	if(r_validation>0){
		dialogo_zebra("Falta seleccionar un Usuario",'warning','Alerta de Permiso de Usuario',300,'');
		return false;	
	}
	
	if(typeof page =="undefined")page = 1;
	if(typeof nav == "undefined")nav = 0;
	$("#AjaxLoading").css("display","block");
	$('#busqueda_fichas').attr('disabled',true).val('Procesando ...').addClass("w100");
	precarga('block');
	 $.ajax({
		type:'POST',
		url: $("#"+gform).attr('action'),
		data:$("#"+gform).serialize()+"&page="+page+"&nav="+nav,
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#AjaxLoading").css("display","none");
			precarga('none');
			$('#busqueda_fichas').attr('disabled',false).val('Buscar').removeClass("w100");
			$("#resultado_busqueda").html(response);
		}
	 });
}


function guardar_serialize_array(form){
	
	if (cajas() > 0){
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
		dialogo_zebra("Debe hacer check en minimo un permiso",'warning','Alerta de '+gtitle,300,'');
		return false;	
	}
	
	desabilitar();
	
	var serializedformdata = $('#'+form).serialize();
	
	serializedformdata += adicionar_form(serializedformdata);
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	$('#button_agregar').attr('disabled',true).val('Procesando ...').addClass("w100");
	
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
			dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'usuario/'+gcontroller+'/'+gmethod);
		}else{
			dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300,'');
		}
		$("#AjaxLoading").css("display","none");
		precarga('none');
		$('#button_agregar').attr('disabled',false).val('Agregar').removeClass("w100");
		
	});
	
}

function agregar_registro(width,url,frm){
	var iIdUsuario = $('#iIdUsuario').val();
	$.post(gurl+url,{iIdUsuario:iIdUsuario} ,
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
																guardar_serialize_array_temp(frm);
																$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();
															}
					}
					,{caption:'Cancelar', callback: function() {$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();}}
					],
		'width': width,
		'overlay_opacity': 0.5
	});
	$('.ZebraDialog_Buttons').css('width','150px');
	$(".ZebraDialog").css({
		top: 0,
		overflow: "auto",
		height: "95%"
	});
}

function guardar_serialize_array_temp(form){
	
	if (cajas() > 0){
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
	
	if (data_array_temp() > 0){
		for(var i = detalle.length - 1; i>=0 ;i--){
				detalle.splice(i,1);
		}
		for(var i = sub_detalle.length - 1; i>=0 ;i--){
				sub_detalle.splice(i,1);
		}
		for(var i = sub_detalle2.length - 1; i>=0 ;i--){
				sub_detalle2.splice(i,1);
		}
		dialogo_zebra("Debe hacer check en minimo un permiso",'warning','Alerta de '+gtitle,300,'');
		return false;	
	}
	
	desabilitar();
	
	var serializedformdata = $('#'+form).serialize();
	
	serializedformdata += adicionar_form(serializedformdata);
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	$('#button_agregar').attr('disabled',true).val('Procesando ...').addClass("w100");
	
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
		}else{
			dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300,'');
		}
		$("#AjaxLoading").css("display","none");
		precarga('none');
		$('#button_agregar').attr('disabled',false).val('Agregar').removeClass("w100");
		
	});
	
}

function agregar_check_visualizar(obj){
	
	if($(obj).is(':checked')){
		$(obj).parent().parent().find('.visualizar').prop('checked',true);
	}
	
}


function exportar_usuario_permiso(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'usuario/registro_usuario/pdf_usuario_permiso/',
	data:$("#"+form).serialize(),
	success: function(response) {
			var obj=eval('('+response+')');
			var archivo=obj.archivo;
			location.href=gurl+"usuario/registro_usuario/descargar/"+archivo;
	},beforeSend:function(){
			 $("#cargan").css("display","block");
	},complete:function(){
			$("#cargan").css("display","none");
	}
	});
	
}




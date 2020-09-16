$(function(){
	Buscar(	);
});


function adicionar_form(){
	
	var serializedformdata;
	//var iIdFormulario = $('#iIdFormulario').val();
	
	serializedformdata = '';
	
	return serializedformdata;
	
}

function validar_comparar(obj){
	
	var total_cObligatorio = 0;
	total_cObligatorio = $('input[name=cComparar]:checked').length;
	
	if(total_cObligatorio > 2){
		dialogo_zebra("Solo puede seleccionar 2 locales",'warning','Alerta de '+gtitle,300,'');
		$(obj).prop('checked',false);
		return false;
	}
	
	var nombre_de_local = $(obj).parent().parent().find('.fase_3_fase_id_2_nombre_del_sitio').html();
	var iIdLocal = $(obj).parent().parent().attr('id').replace('fila_','');
	
	if($(obj).is(":checked") == false){
		$('#comparar_'+iIdLocal).remove();
		return false;
	}
	
	var newRow = "";
	newRow = "<div id='comparar_"+iIdLocal+"' class='comparar w115 fl db'><img class='fl' src='"+gurl+"public/images/u56_normal.png' width='15px' /><label class='fl w90 lh_15 mb_2 ml_7 fs_9 db'>"+nombre_de_local+"</label></div>";
	
	$('#resultado_comparar').append(newRow);
	
	
}

function Comparar(page,nav){
	
	var total_cObligatorio = 0;
	total_cObligatorio = $('input[name=cComparar]:checked').length;
	
	if(total_cObligatorio != 2){
		dialogo_zebra("Solo puede seleccionar 2 locales",'warning','Alerta de '+gtitle,300,'');
		return false;
	}


	var detalle_local = new Array();
	
	$('.comparar').each(function(){
		detalle_local.push({
			"iIdLocal"	: $(this).attr('id').replace('comparar_',''),
			"local"		: $(this).find('label').html(),
		});
	});	
	
	if(detalle_local.length == 0){
		dialogo_zebra("Debe seleccionar maximo dos locales para poder comparar",'warning','Alerta de '+gtitle,300,'');
		return false;
	}
	
	$("#AjaxLoading").css("display","block");
	$('#busqueda_fichas').attr('disabled',true).val('Procesando ...').addClass("w100");
	
	$.post(gurl+'locales/registro/comparar_local',{'detalle_local':detalle_local},function(response){
		if(!response){
			window.location.reload();
		}
		$("#AjaxLoading").css("display","none");
		$('#busqueda_fichas').attr('disabled',false).val('Buscar').removeClass("w100");
		$("#resultado_busqueda").html(response);
		$('.title_cabecera').html('Comparaci&oacute;n de locales');
		$('#div_opciones_busqueda').hide();
	});
	
}


function Buscar(page, nav, obj, fase, fase_id){
	if(typeof page =="undefined")page = 1;
	if(typeof nav == "undefined")nav = 0;
	$("#AjaxLoading").css("display","block");
	$('#busqueda_fichas').attr('disabled',true).val('Procesando ...').addClass("w100");
	
	var campo 	= $('#campo').val();
	var asc 	= $('#asc').val();
	if (fase > 0) {
		parameters = "fase=" + fase + "&fase_id=" + fase_id;
	}
	
	if(obj){
		var campo_new = $(obj).parent().attr('class').replace('cabecera_','');
		var asc_new = 'ASC';
		$('#campo').val(campo_new);
		
		if(asc == 'ASC')asc_new = 'DESC';
		if(asc == 'DESC')asc_new = 'ASC';
		$('#asc').val(asc_new);
		
	}

	precarga('block');
	 $.ajax({
		type:'POST',
		url: $("#"+gform).attr('action'),
		data:$("#"+gform).serialize()+"&page="+page+"&nav="+nav,
		success: function(response) {
			$("#AjaxLoading").css("display","none");
			precarga('none');
			$('#busqueda_fichas').attr('disabled',false).val('Buscar').removeClass("w100");
			$("#resultado_busqueda").html(response);
			$('.title_cabecera').html('B&uacute;squeda de Locales')
			$('#div_opciones_busqueda').show();
			
			$('.comparar').each(function(){
				var iIdLocal = $(this).attr('id').replace('comparar_','');
				$('#cComparar_'+iIdLocal).attr('checked',true);
			});
		}
	 });

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
		
}

function recuperar_select_controller_id_ubigeo_inicio(idorigen,controlador,destino,seleccionado){
	
	var id 		= $("#"+seleccionado+" option:selected").attr('vCodigo');
	var idDpto  = $("#fase_3_fase_id_2_departamento option:selected").attr('vCodigo');
	if(seleccionado == 'fase_3_fase_id_2_departamento'){
		$('#fase_3_fase_id_2_distrito').html('');
		$('#fase_3_fase_id_2_ubigeo').val('');
		$('#fase_3_fase_id_2_distrito').append($('<option></option>').val('').html('[ --Seleccionar-- ]'));
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
				
			}); 
			
		}, 'json');
		
}

function exportar_local_busqueda(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/pdf_local_busqueda/',
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

function exportar_excel_local_busqueda(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/excel_local_busqueda/',
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


function exportar_local_comparar(form){
	
	var detalle_local = new Array();
	
	$('.comparar').each(function(){
		detalle_local.push({
			"iIdLocal"	: $(this).attr('id').replace('comparar_',''),
			"local"		: $(this).find('label').html(),
		});
	});	
	
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/pdf_local_comparar/',
	data:{'detalle_local':detalle_local},
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

function exportar_excel_local_formato(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'locales/registro/excel_local_formato/',
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

function importar_excel_local(obj,form){
	
	new AjaxUpload($(obj), {
		action: gurl+"locales/registro/upload_excel_local",
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
		},
		onComplete: function(file, response) {			
			if(response == 'success'){
				$('#vNombreArchivo').val("")
				$('#vNombreArchivo').val(file);
				ImportarExcelLocal(form);
			}
		}
  	});
	
}

function ImportarExcelLocal(form){
	
	$.ajax({
		type:'POST',
		url: gurl+'locales/registro/importar_excel_local/',
		data:$("#"+form).serialize(),
		success: function(response) {
			//alert(response);return false;
			if(response == 'success'){
				dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
				Buscar();
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300,'');
			}
			//var obj=eval('('+response+')');
			//alert_success(400, 200, "Se importo Correctamente !!!","");
		},beforeSend:function(){
			precarga("block");
		},complete:function(){
			precarga("none");
		},error:function(){
			 dialogo_zebra("Error del sistema pongase en contacto con el administrador.",'error','Alerta de '+gtitle,500,'');
		}
 	});
}


function imprimir_comparar(){
	//precarga('block');
	
	$("#logo_impresion_busqueda_comparar").css("display","block");
	$(".title_cabecera_comparar").css("display","block");
	imprimir_none();
	//$("#bt_imprimir").css("display","none");
	$("#resultado_impresion_comparar").jqprint();
	setTimeout(function(){
		 //precarga('none');
		$("#logo_impresion_busqueda_comparar").css("display","none");
		$(".title_cabecera_comparar").css("display","none");
		//$("#bt_imprimir").css("display","block");
		
		imprimir_block();
	},1000);
}

function limpieza(form){
	$('#'+form).find(':input,select').each(function() {
					switch(this.type) {
						case 'text':
						case 'textarea':
						case 'password':
						$(this).val('');
						break;
						case 'select-one':
						this.selectedIndex = 0;
						break;
						case 'checkbox':
						case 'radio':
						$(this).prop('checked',false);
						break;
					}
	});
	
	$('#resultado_comparar').html('');
	$('#resultado_impresion_comparar').html('');
	
}

$(function(){
	//$('#enviar').click(SubirFotos);
});

function SubirFotos(){	
	var archivos = document.getElementById("archivos");
	//alert($('#archivos').attr('files'));
	var archivo = archivos.files;
	var archivos = new FormData();
	
	/*xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var children, i, l, child,
	form_data = '';
	children = form.childNodes;
	for( i=0,l=children.length;i<l;i++ ){
		if( typeof children[i] != 'object' ||
		(children[i].tagName == null && children[i].localName == null) ){
			continue;
		}
		child = children[i];
		if( child.getAttribute('name') && child.getAttribute('type') != 'file' ){
			var name = child.getAttribute('name'),
			value = child.value;
			if( form_data != '' ) form_data += '&'
			form_data += name+'='+encodeURIComponent(value);
		}
	}*/
	
	//alert(archivos);return false;
	
	for(i=0; i<archivo.length; i++){
	archivos.append('archivo'+i,archivo[i]);
	}
	$("#AjaxLoading").css("display","block");
	precarga('block');
	$.ajax({
		url:gurl+'utilitarios/administracion_formulario/upload_importacion_masiva',
		type:'POST',
		contentType:false,
		data:archivos,
		processData:false,
		cache:false
	}).done(function(msg){
		var msg = msg.substr(1).split(',');
		var res_msg = '';
		for(var i=0;i<msg.length;i++){
			
			var datos_local = msg[i].split('@');
			
			if(datos_local[1] > 0){

			var newRow = "";
			newRow += "<div class='documento ml_20'>";
			newRow += "<img class='fl' src='"+gurl+"public/images/u149_normal.png' width='16' height='16' />";
			newRow += "<input type='text' name='vDocumento' value='"+datos_local[0]+"' class='bordercaja fl al w250 lh_20 mb_2 ml_10' validar='ok' style='background-color:transparent;border:0px'/>";
			newRow += "<div class='fl'>";
			newRow += "<a class='delete_img fl pointer' style='position:static' onclick='remove_img(this)'></a>";
			newRow += "<label class='fl label w50 lh_20 mb_2 ml_10 pointer' onclick='remove_img(this)'>Eliminar</label>";
			
			newRow += "<label class='fl label w180 lh_20 mb_2 ml_60'>Se importar&aacute; al local :</label>";
			newRow += "<label class='fl label w100 lh_20 mb_2 ml_10'>"+datos_local[2]+"</label>";
			newRow += "<input type='hidden' name='iIdLocal' value='"+datos_local[1]+"' class='bordercaja fl al w100 lh_20 mb_2 ml_10' validar='ok' style='background-color:transparent;border:0px'/><input type='hidden' name='codigo_de_local' value='"+datos_local[3]+"' />";
			
			
			newRow += "</div>";
			newRow += "</div>";
			newRow += "<div class='clear'></div>";
			$('#resultado_documentos').append(newRow);
			
			}else{
				res_msg += datos_local[0]+' <br> ';
			}
		}
		
		if(res_msg != '')dialogo_zebra("<div class='scrollable_new' style='width:600px!important'>Los archivos <br> "+res_msg+" no tienen la estructura correcta o ya existen</div>",'warning','Alerta de '+gtitle,700,'');			
		$("#AjaxLoading").css("display","none");
		precarga('none');
		
		//$('#mensage').val(msg);
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
			"vDocumento"		: $(this).find("input[name=vDocumento]").val(),
			"iIdLocal"			: $(this).find("input[name=iIdLocal]").val(),
			"codigo_de_local"	: $(this).find("input[name=codigo_de_local]").val(),
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


function guardar_serialize_array(form){
	
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
	//serializedformdata += adicionar_form(serializedformdata);
	
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
			//dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,500,'');
			dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,gurl+'utilitarios/'+gcontroller+'/'+gmethod);
		}else{
			dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
		}
		
		$("#AjaxLoading").css("display","none");
		precarga('none');
		$('#button_agregar').attr('disabled',false).val('Importar');
		
		
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


function dialogo_zebra(msg,type,title,width,enlace){
	$.Zebra_Dialog(msg, {
		'type':  type,
		'title':    false,
		'buttons': [{caption:'Aceptar', callback: function() { 
					if (enlace.length > 0)location.href = enlace;
		}}],
		'width': width,
		'overlay_opacity': 0.5
	});
	
	$('.ZebraDialog_Buttons').css('width','80px');
	//$('.ZebraDialog_Buttons').css('width','80px').css({height:"200px", overflow:"auto"});
	//$('.ZebraDialog_Buttons').css('width','80px').css('height','200px !important');
}



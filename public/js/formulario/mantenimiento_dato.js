


$(function(){
	
	//autocomplete__AjaxBusqueda_proforma();	
	//$("#dFechaEmision").datepicker({ dateFormat: 'dd/mm/yy' });
	//$("#dFechaEntrega").datepicker({ dateFormat: 'dd/mm/yy' });
	
	Buscar();	
	
});


function adicionar_form(){
	
	var serializedformdata;
	var iIdDetalleFormulario = $('#iIdDetalleFormulario').val();
	
	serializedformdata = '&iIdDetalleFormulario='+iIdDetalleFormulario;
	
	return serializedformdata;
	
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
	$('#button_agregar').attr('disabled',true).val('Procesando ...').addClass("w100");
	$.ajax({
		type:'POST',
		url: $("#"+form).attr('action'),
		data:serializedformdata,
		success: function(data) {
			//alert(data);
			if(data == 'success'){
				dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
				Buscar();
				limpieza(form)
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','Alerta de '+gtitle,300);
			}
			$("#AjaxLoading").css("display","none");
			$('#button_agregar').attr('disabled',false).val('Buscar').removeClass("w100");
		}
	 });	
	
}

function get_registro(obj,id){
	
	var vNombre 		= $(obj).parent().parent().find('.vNombre').html();
	var vCodigo			= $(obj).parent().parent().find('.vCodigo').html();
	var eEstado			= $(obj).parent().parent().find('.eEstado').html();
	
	$('#vNombre').val(vNombre);
	$('#vCodigo').val(vCodigo);
	if(eEstado == 'activo')eEstado = 1;
	if(eEstado == 'inactivo')eEstado = 2;
	$('#eEstado').val(eEstado);
		
	$('#id').val(id);
	
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
	$('#id').val('');
}

/*
function eliminar_registro(id){
    var iIdDetalleFormulario = $('#iIdDetalleFormulario').val();
    confirmacion_eliminar(400, 200, 'Estas Seguro Eliminar el Dato', 'utilitarios/mantenimiento_datos/eliminar_registro', id,iIdDetalleFormulario) 
}
*/

function eliminar_registro(id, table){
	var iIdDetalleFormulario = $('#iIdDetalleFormulario').val();
	dialogo_zebra_eliminar_proceso("Estas Seguro de Eliminar el Dato",'question','Alerta de '+gtitle,300,'',id,iIdDetalleFormulario,'utilitarios/mantenimiento_datos/eliminar_registro', table);
}

function eliminar_categoria(id){
	dialogo_zebra_eliminar_proceso("Estas Seguro de Eliminar el Dato",'question','Alerta de '+gtitle,300,'',id,'','utilitarios/mantenimiento_datos/eliminar_categoria');
}

function dialogo_zebra_eliminar_proceso(msg,type,title,width,enlace,id,iIdDetalleFormulario,proceso, table){
	$.Zebra_Dialog(msg, {
		'type':  type,
		'title':    false,
		'buttons': [
					{caption:'Si', callback: function() {
															$.post(gurl+proceso,{id,iIdDetalleFormulario, table},function(data){
																$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();
																dialogo_zebra("Se Elimino Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
																Buscar();
															});
															
														}
					}
					,{caption:'No', callback: function() {$('.ZebraDialog').remove();$('.ZebraDialogOverlay').remove();}}
					],
		'width': width,
		'overlay_opacity': 0.5
	});
	$('.ZebraDialog_Buttons').css('width','150px');
}


function confirmacion_eliminar(ancho, alto, mensaje, url, id,iIdDetalleFormulario) {

    var html = "";

    $("#confirmacion").remove();
    $('body').append("<div id='confirmacion'>");

    $("#confirmacion").dialog({
        title: "SISTEMA DE GESTION",
        width: ancho,
        height: alto,
        modal: true,
        draggable: true,
        show: "blind",
        hidden: "fade",
        buttons: {
            "SI": function() { 
                $.ajax({
                        type: "POST",
                        data: "id=" + id+"&iIdDetalleFormulario="+iIdDetalleFormulario,
                        url: gurl + url,
                        success: function(data) {                            
                            if (data == '1') {
                                alert_success(400, 200, 'Se Elimino Satifactoramente', "");
								Buscar();
                            }
                            if (data == '0') {
                                alert_error(400, 200, 'Se se Pudo Elimino el Dato', "");
                            }
                            

                        },
                        beforeSend: function() {
                            precarga('block');
                        },
                        complete: function() {
                            precarga('none');
                        }

                    });
                    $(this).dialog("close");
               
            },
            "NO ": function() {
                $(this).dialog("close");
            }
        }

    });

    html += "<div class=\"warning\">";
    html += "</div>";
    html += "<div class=\"message\">";
    html += mensaje;
    html += "</div>";

    $("#confirmacion").html(html)
    $("#confirmacion").dialog("open");

}

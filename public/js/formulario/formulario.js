


$(function() {
	//autocomplete__AjaxBusqueda_proforma();
	//$("#dFechaEmision").datepicker({ dateFormat: 'dd/mm/yy' });
	//$("#dFechaEntrega").datepicker({ dateFormat: 'dd/mm/yy' });
	Buscar();
});

function Buscar(page, nav, fase, fase_id) {
	if (typeof page == "undefined" || page == false) page = 1;
	if (typeof nav == "undefined" || nav == false) nav = 0;

	$("#AjaxLoading").css("display", "block");
	$('#busqueda_fichas').attr('disabled', true).val('Procesando ...').addClass("w100");
	precarga('block');
	
	var vNombreBusqueda = $('#vNombreBusqueda').val();
	var parameters = $("#" + gform).serialize();
	if (fase > 0) {
		parameters = "fase=" + fase + "&fase_id=" + fase_id;
	}
	
	$.ajax({
		type:'POST',
		url: $("#"+gform).attr('action'),
		data: parameters + "&page=" + page + "&nav=" + nav + "&vNombreBusqueda=" + vNombreBusqueda,
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#AjaxLoading").css("display", "none");
			precarga('none');
			$('#busqueda_fichas').attr('disabled', false).val('Buscar').removeClass("w100");
			$("#resultado_busqueda").html(response);
		}
	});

	if (typeof fase == "undefined") {
		var id_formulario = $("#iIdFormulario").val();
		if (id_formulario != 3) {
			$("#box_registers_campos").addClass("dn");
			selectFaseDos(id_formulario);
		} else {
			$("#resultado_select_fase_dos").html("");
			$("#box_registers_campos").removeClass("dn");
		}
	}
}

function selectFaseDos(select_fase_uno) {
	$.ajax({
		type: 'POST',
		url: 'administracion_formulario/select_fase_dos',
		data: { select_fase_uno },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#resultado_select_fase_dos").html(response);
		}
	});
}

function autocomplete__AjaxBusqueda_proforma(){
	
	$("#proforma").autocomplete({
   minLength: 1,
   delay : 400,
   source: function(request, response) {
    $.ajax({
      url:   gurl+gcontroller+"/recuperar_codigo_proforma/",
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
		
		var iIdProforma = ui.item.iIdProforma;
		$('#iIdProforma').val(iIdProforma);

      }
    });	
	
}


function adicionar_form() {
	var serializedformdata;
	var iIdFormulario = $('#iIdFormulario').val();

	serializedformdata = '&iIdFormulario=' + iIdFormulario;

	return serializedformdata;
}

function guardar_serialize(form) {
	var r_validation = validar_formulario(form);
	$('#btn__campo_niveles').attr('disabled', true);
	$('#btn__campo_niveles').css('opacity', 0.4);
	if (r_validation > 0) {
		dialogo_zebra("Falta Ingresar Datos Obligatorios", 'warning', 'Alerta de ' + gtitle, 300, '');
		$('#btn__campo_niveles').attr('disabled', false);
		$('#btn__campo_niveles').css('opacity', 1);
		return false;
	}
	
	var serializedformdata = $('#' + form).serialize();
	
	serializedformdata += adicionar_form(serializedformdata);

	var fase = 0;
	var fase_id = 0;
	var formulario_fase_tres = $("#formulario_fase_tres").val();
	var formulario_fase_cuatro = $("#formulario_fase_cuatro").val();
	var formulario_fase_cinco = $("#formulario_fase_cinco").val();

	if (formulario_fase_cinco != undefined && formulario_fase_cinco != "") {
		fase = 5;
		fase_id = formulario_fase_cinco;
	}
	if (fase == 0 && formulario_fase_cuatro != undefined && formulario_fase_cuatro != "") {
		fase = 4;
		fase_id = formulario_fase_cuatro;
	}
	if (fase == 0 && formulario_fase_tres != undefined && formulario_fase_tres != "") {
		fase = 3;
		fase_id = formulario_fase_tres;
	}

	if (fase > 0) {
		serializedformdata += "&locales_formulario_fase=" + fase + "&locales_formulario_fase_id=" + fase_id;
	}
	
	$("#AjaxLoading").css("display", "block");
	precarga('block');
	$('#button_agregar').attr('disabled', true).val('Procesando ...').addClass("w100");
	console.log(serializedformdata);
	$.ajax({
		type: 'POST',
		url: $("#" + form).attr('action'),
		data: serializedformdata,
		success: function(data) {
			if (data == 1 || data == 3) {
				dialogo_zebra("Se Guardo Satisfactoriamente", 'confirmation', 'Alerta de ' + gtitle, 300, '');
				if (fase > 0) {
					Buscar(false, false, fase, fase_id);
				} else {
					Buscar();
				}
				limpieza(form)
			} else {
				if (data == 2) {
					dialogo_zebra("El campo existe, debe cambiar el nombre", 'error', 'Alerta de ' + gtitle, 300, '');
				} else {
					dialogo_zebra("Error Al Grabar Registro", 'error', 'Alerta de ' + gtitle, 300, '');
				}
			}

			$("#AjaxLoading").css("display", "none");
			precarga('none');
			$('#button_agregar').attr('disabled', false).val('Buscar').removeClass("w100");
			$('#btn__campo_niveles').attr('disabled', false);
			$('#btn__campo_niveles').css('opacity', 1);
		}
	 });
}

function get_registro(obj,id){
	
	var iIdFormulario 	= $(obj).parent().parent().attr('iIdFormulario');
	var vNombre 		= $(obj).parent().parent().find('.vNombre').html();
	var iIdTipoCampo 	= $(obj).parent().parent().attr('iIdTipoCampo');
	var a_expiration    = $(obj).parent().parent().attr('alert_expiration');
	var iOrden 			= $(obj).parent().parent().attr('iOrden');
	var cObligatorio	= $(obj).parent().parent().attr('cObligatorio');
	var cNumerico		= $(obj).parent().parent().attr('cNumerico');
	var eEstado			= $(obj).parent().parent().find('.eEstado').html();

	$('#alert_expiration').prop('checked',false);
	$('#cObligatorio').prop('checked',false);
	$('#cNumerico').prop('checked',false);
	$('#iIdFormulario').val(iIdFormulario);
	$('#vNombre').val(vNombre);
	$('#iIdTipoCampo').val(iIdTipoCampo);
	$('#iOrden').val(iOrden);
	
	if(cObligatorio == 1)$('#cObligatorio').prop('checked',true);
	if(a_expiration == 1)$('#alert_expiration').prop('checked',true);
	if(cNumerico == 1)$('#cNumerico').prop('checked',true);
	
	if(eEstado == 'activo')eEstado = 1;
	if(eEstado == 'inactivo')eEstado = 2;
	$('#eEstado').val(eEstado);
	
	$('#iIdDetalleFormulario').val(id);
	
}

function limpieza(form) {
	$('#' + form).find(':input, select').each(function() {
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
	$('#iIdDetalleFormulario').val('');
	$('#vNombreBusqueda').val('');
}
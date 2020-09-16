
$(function(){
	
	autocomplete__AjaxBusqueda_nombre();
	autocomplete__AjaxBusqueda_dni();
	autocomplete__AjaxBusqueda_usuario();
	
	Buscar();	
	
	$("#fecha_de_expiracion_desde").datepicker({ dateFormat: 'dd/mm/yy' });
	$("#fecha_de_expiracion_hasta").datepicker({ dateFormat: 'dd/mm/yy' });
	
});


function adicionar_form(){
	
	var serializedformdata;
	
	serializedformdata = '';
	
	return serializedformdata;
	
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

function exportar_usuario_busqueda(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'usuario/registro_usuario/pdf_usuario_busqueda/',
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

function exportar_usuario_log(form){
		
	$.ajax({
	type:'POST',
	url: gurl+'usuario/registro_usuario/pdf_usuario_log/',
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



$(function(){
	
	$("#ingresar").click(function(){
		var frm=$(this).attr("name_frm");
		var controlador=$(this).attr("controlador");
		 
		var mail = $('#usuario').val();
		var ab = mail.indexOf("@");
		var pt = mail.lastIndexOf(".");
		/*if (pt<1 || pt<ab+2 || pt+2>=mail.length){
			dialogo_zebra("Ingrese un Correo corporativo correcto",'warning','',300,'');
			return false;
		}*/
		
		$("#AjaxLoading").css("display","block");
		precarga('block');
		
		 $.ajax({
			  type : "POST",
			  url : gurl+controlador,
			  data : $("#"+frm).serialize(),
			  success:function(data){
					if (data == 'success'){
						location.href=gurl+"locales/registro/busqueda/";
					}else{
						location.href=gurl+"login/index/error/";
					}
					$("#AjaxLoading").css("display","none");
					precarga('none');
				  
			  },beforeSend:function(){
			  }
			  
		 });

  });
  
	
	$("#enviar_clave").click(function(){
		var frm=$(this).attr("name_frm");
		var controlador=$(this).attr("controlador");
		 
		var mail = $('#usuario').val();
		var ab = mail.indexOf("@");
		var pt = mail.lastIndexOf(".");
		/*if (pt<1 || pt<ab+2 || pt+2>=mail.length){
			dialogo_zebra("Ingrese un Correo corporativo correcto",'warning','',300,'');
			return false;
		}*/
		
		$("#AjaxLoading").css("display","block");
		precarga('block');
		
		 $.ajax({
			  type : "POST",
			  url : gurl+controlador,
			  data : $("#"+frm).serialize(),
			  success:function(data){
					if(data == 'success'){
						dialogo_zebra("Su solicitud se envio satisfactoriamente",'confirmation','',300,'');
					}else{
						dialogo_zebra(data,'error','',300,'');
					}
					$("#AjaxLoading").css("display","none");
					precarga('none');
				  
			  },beforeSend:function(){
			  }
			  
		 });

  });
	
	$("#restablecer_clave").click(function(){
		var frm=$(this).attr("name_frm");
		var controlador=$(this).attr("controlador");
		 
		var mail = $('#usuario').val();
		var ab = mail.indexOf("@");
		var pt = mail.lastIndexOf(".");
		/*if (pt<1 || pt<ab+2 || pt+2>=mail.length){
			dialogo_zebra("Ingrese un Correo corporativo correcto",'warning','',300,'');
			return false;
		}*/
		
		var contrasena = $('#contrasena').val();
		var Ncontrasena = $('#Ncontrasena').val();
		
		if(contrasena != Ncontrasena && contrasena.length > 0){
			dialogo_zebra("Las contrase&ntilde;as no son iguales",'warning','',300,'');
			return false;
		}
		
		$("#AjaxLoading").css("display","block");
		precarga('block');
		
		 $.ajax({
			  type : "POST",
			  url : gurl+controlador,
			  data : $("#"+frm).serialize(),
			  success:function(data){
					if(data == 'success'){
						dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','',300,gurl+'login/');
					}else{
						dialogo_zebra("Error Al Grabar Registro",'error','',300,'');
					}
					$("#AjaxLoading").css("display","none");
					precarga('none');
				  
			  },beforeSend:function(){
			  }
			  
		 });

  });
	
	
});


function acceder(){
	
	var frm = 'loginIn';
	var controlador=$('#ingresar').attr("controlador");
	
	var mail = $('#usuario').val();
	var ab = mail.indexOf("@");
    var pt = mail.lastIndexOf(".");
    /*if (pt<1 || pt<ab+2 || pt+2>=mail.length){
		dialogo_zebra("Ingrese un Correo corporativo correcto",'warning','',300,'');
		return false;
	}*/
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	
	 $.ajax({
	  type : "POST",
	  url : gurl+controlador,
	  data : $("#"+frm).serialize(),
	  success:function(data){
			if (data == 'success'){
				location.href=gurl+"home/";
			}else{
				location.href=gurl+"login/index/error/";
			}
			$("#AjaxLoading").css("display","none");
			precarga('none');
		  
		  },beforeSend:function(){
		  }
		  
	 });	
	
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
	
}

function enviar_clave(){
	
	var frm = 'loginIn';
	var controlador=$('#ingresar').attr("controlador");
	
	var mail = $('#usuario').val();
	var ab = mail.indexOf("@");
    var pt = mail.lastIndexOf(".");
    /*if (pt<1 || pt<ab+2 || pt+2>=mail.length){
		dialogo_zebra("Ingrese un Correo corporativo correcto",'warning','',300,'');
		return false;
	}*/
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	
	 $.ajax({
	  type : "POST",
	  url : gurl+controlador,
	  data : $("#"+frm).serialize(),
	  success:function(data){
		  
			if(data == 'success'){
				dialogo_zebra("Su solicitud se envio satisfactoriamente",'confirmation','',300,'');
			}else{
				dialogo_zebra(data,'error','',300,'');
			}
			$("#AjaxLoading").css("display","none");
			precarga('none');
		  
		  },beforeSend:function(){
		  }
		  
	 });	
	
}

function restablecer_clave(){
	
	var frm = 'loginIn';
	var controlador=$('#ingresar').attr("controlador");
	
	var mail = $('#usuario').val();
	var ab = mail.indexOf("@");
    var pt = mail.lastIndexOf(".");
    /*if (pt<1 || pt<ab+2 || pt+2>=mail.length){
		dialogo_zebra("Ingrese un Correo corporativo correcto",'warning','',300,'');
		return false;
	}*/
	
	var contrasena = $('#contrasena').val();
    var Ncontrasena = $('#Ncontrasena').val();
	
    if(contrasena != Ncontrasena && contrasena.length > 0){
        dialogo_zebra("Las contrase&ntilde;as no son iguales",'warning','',300,'');
		return false;
    }
	
	$("#AjaxLoading").css("display","block");
	precarga('block');
	
	 $.ajax({
	  type : "POST",
	  url : gurl+controlador,
	  data : $("#"+frm).serialize(),
	  success:function(data){
		  	
			if(data == 'success'){
				dialogo_zebra("Se Guardo Satisfactoriamente",'confirmation','',300,gurl+'login/');
			}else{
				dialogo_zebra("Error Al Grabar Registro",'error','',300,'');
			}
			
			$("#AjaxLoading").css("display","none");
			precarga('none');
		  
		  },beforeSend:function(){
		  }
		  
	 });	
	
}


function validarMail(mail){
	/*
    var ab = mail.indexOf("@");
    var pt = mail.lastIndexOf(".");
    if (pt<1 || pt<ab+2 || pt+2>=mail.length)
    {
        $('#check').html("<img src='"+gurl+"public/images/cross-circle.png'>");
		
    }else{
        $('#check').html("<img src='"+gurl+"public/images/check.png'>");
		$("#ingresar").removeAttr('disabled');
		$('.error').hide('slow');
		$("#enviar").removeAttr('disabled');
    }
	*/
}

function ConfirmarClave(){
    var contrasena = $('#contrasena').val();
    var Ncontrasena = $('#Ncontrasena').val();
	
    if(contrasena == Ncontrasena){
        $('#check_clave').html("<img src='"+gurl+"public/images/cross-circle.png'>");
    }else{
        $('#check_clave').html("<img src='"+gurl+"public/images/check.png'>");
		$("#ingresar").removeAttr('disabled');
		$('.error').hide('slow');
		$("#enviar").removeAttr('disabled');
    }
}



<div class="content">
<?php 
$pagina["tab"]="documentos";
$this->load->view('template/tabs', $pagina);
$opciones = explode(',', $opciones);
?>

	<div class="clear"></div>
	<div class="contenido formulario" style="min-height:400px;margin-top:192px">
		<div class="row">
			<div class="col-md-2">
				<div class="menu__formulario--accordion" style="margin-left: -1.5em;">
					<?php
					$id_fase_uno = 0;
					$id_principal = 0;
					foreach($menu_items as $menu_item) {
						if ($id_principal == 0) {
							$id_principal = $menu_item->id_fase_tres;
						}
						if ($id_fase_uno != 0 && $id_fase_uno != $menu_item->id) {
					?>
							</ul>
						</div>
					<?php
						}
						if ($id_fase_uno != $menu_item->id) {
							$id_fase_uno = $menu_item->id;
					?>
						<h3><?= $menu_item->nombre ?></h3>
						<div style="min-height: 130px;max-height: 130px">
							<ul class="menu__formulario_accordion">
								<li onClick="cargarEditFormularioCampos(3, <?= $menu_item->id_fase_tres ?>)"><?= $menu_item->nombre_fase_tres ?></li>
					<?php
						} else {
					?>
								<li onClick="cargarEditFormularioCampos(3, <?= $menu_item->id_fase_tres ?>)"><?= $menu_item->nombre_fase_tres ?></li>
					<?php
						}
					}
					?>
							</ul>
						</div>
				</div>
			</div>
			<div class="col-md-10">
				<div id="box__formulario--campos"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
	<div id="dialog-form" style="display:none;" title="Configurar fecha de vencimiento"> 
	  <form>
	    <fieldset style="border:0px">
	    	<table style="border:0px; margin-top: 20px">
				<tr>
			      <td style="text-align: right;padding-right: 20px;"><label style="display: inline;font-size: 14px;" for="fecha_alerta" class="forma_variable">Fecha de Vencimiento: </label></td>
			      	<td>
			      		<input style="display: inline;max-width: 175px;font-size: 14px" type="datetime-local" name="fecha_alerta" id="fecha_alerta" class="text_v ui-widget-content ui-corner-all forma_variable">
			      		<input type="hidden" id="id_formulario_alert" name="" value="" placeholder="">
			      		<input type="hidden" id="id_alert_form" name="" value="" placeholder="">
			      	</td>
				</tr>
				<tr style="height: 5px;width: 5px">
				</tr>
				<tr>
			      	<td style="text-align: right;padding-right: 20px;"><label style="display: inline;font-size: 14px;" min="1" for="dias_anticipacion" class="forma_variable">Dias previos de alerta: </label></td>
			      	<td><input style="display: inline;max-width: 80px;font-size: 14px" type="number" min=1 name="dias_anticipacion" id="dias_anticipacion" value="" class="text_v ui-widget-content ui-corner-all forma_variable"></td>
				</tr>
			</table>
	      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
	    </fieldset>
	  </form>
	</div>

<script type="text/javascript">
var iIdLocal = <?= $iIdLocal ?>;
var fase = 3;
var fase_id = <?= $id_principal ?>;
cargarEditFormularioCampos(3, <?= $id_principal ?>);

function selectFile(that, id_input_file, id) {
	if (that.value != "") {
		$('#option_' + id_input_file).removeClass('dn');
	}
}

function clickUploadDocument(that) {
		switch (Number(that.value)) {
			case 2 :
			case 5 :
			precarga('block');
			break;
		}
}

var i = 0;
function move() {
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= 99) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width  + "%";
      }
    }
  }
}

function opcionSelectFile(that, id, id_input_file, iIdDetalleFormulario) {
	if (that.value != "") {
		switch (Number(that.value)) {
			case 1:
				name_file = $(that).attr("data-file-name")
				window.open("../../../public/images/documento/" + name_file)
			break;
			case 2:
				if ($('#' + id_input_file)[0].files[0] != undefined) {
					$("#btnSave").attr("disabled", true);
					$("#btnCancel").attr("disabled", true);
					$("#btnSave").css("opacity", 0.7);
					$("#btnCancel").css("opacity", 0.7);

					$("#AjaxLoading").css("display","block");
					precarga('block');

					$('#upload_' + id_input_file).removeClass('dn');

					var formData = new FormData();
					formData.append("file", $('#' + id_input_file)[0].files[0]);
					formData.append("iIdDetalleDocumento", id);
					formData.append("fase", fase);
					formData.append("fase_id", fase_id);
					formData.append("iIdLocal", iIdLocal);
					formData.append("iIdDetalleFormulario", iIdDetalleFormulario);
					$.ajax({
					    url: gurl + "locales/registro/create_detalledocumento",
					    type: 'POST',
					    data: formData,
					    success: function(response) {
					    	var data = JSON.parse(response);
					        if (data.iIdDetalleDocumento) {
					        	$(that).attr("data-file-name", data.vDocumento);
					        	$("#label_" + id_input_file).text(data.vDocumento);
					        	$("#date_update_" + id_input_file + " input")[0].value = data.dModificacion;
								dialogo_zebra("Se Actualizo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');
							}
					        $("#AjaxLoading").css("display","none");
							precarga('none');
							$('#date_update_' + id_input_file).removeClass('dn');

							$('#upload_' + id_input_file).addClass('dn');
							$("#btnSave").attr("disabled", false);
							$("#btnCancel").attr("disabled", false);
							$("#btnSave").css("opacity", 1);
							$("#btnCancel").css("opacity", 1);
					    },
					    cache: false,
					    contentType: false,
					    processData: false
					});
				} else {
					dialogo_zebra("Debe selecionar una archivo",'warning','Alerta de '+gtitle,300,'');
				}
			break;
			case 3:
				name_file = $(that).attr("data-file-name")
				window.open("../../../public/images/documento/" + name_file)
			break;
			case 4:
				eliminar_registro(id);
			break;
			case 5:
			    $('#myProgress').css('display','block');
					move();
			    setTimeout(function(){
			     if ($('#' + id_input_file)[0].files[0] != undefined) {
					$("#btnSave").attr("disabled", true);
					$("#btnCancel").attr("disabled", true);
					$("#btnSave").css("opacity", 0.7);
					$("#btnCancel").css("opacity", 0.7);

					$("#AjaxLoading").css("display","block");
					precarga('block');

					$('#upload_' + id_input_file).removeClass('dn');

					var formData = new FormData();
					formData.append("file", $('#' + id_input_file)[0].files[0]);
					formData.append("iIdDetalleDocumento", id);
					formData.append("fase", fase);
					formData.append("fase_id", fase_id);
					formData.append("iIdLocal", iIdLocal);
					formData.append("iIdDetalleFormulario", iIdDetalleFormulario);
					
					$.ajax({
					    url: gurl + "locales/registro/create_detalledocumento",
					    type: 'POST',
					    data: formData,
					    async: false,
					    success: function(response) {
					        var data = JSON.parse(response);
					        if (data.iIdDetalleDocumento) {
					        	$(that).attr("data-file-name", data.vDocumento);
					        	$("#label_" + id_input_file).text(data.vDocumento);
					        	$("#label_" + id_input_file).attr("title", data.vDocumento);
					        	$("#label_" + id_input_file).removeClass('dn');
					        	$("#date_update_" + id_input_file + " input")[0].value = data.dModificacion;
								dialogo_zebra("Se Actualizo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');

								var opciones = '';
								<?php
								if (in_array(3, $opciones)) {
								?>
									opciones += '<option value="2">Actualizar</option><option value="3">Descargar</option>';
								<?php
								}
								if (in_array(4, $opciones)) {
								?>
									opciones += '<option value="4">Eliminar</option>';
								<?php
								}
								?>
								$(that).html('<option value="">Opción</option><option value="1">Ver</option>' + opciones);
								$('#' + id_input_file).addClass('dn');
							}
					        $("#AjaxLoading").css("display","none");
							precarga('none');
							$('#date_update_' + id_input_file).removeClass('dn');

							$('#upload_' + id_input_file).addClass('dn');
							$("#btnSave").attr("disabled", false);
							$("#btnCancel").attr("disabled", false);
							$("#btnSave").css("opacity", 1);
							$("#btnCancel").css("opacity", 1);
							
							var elem = document.getElementById("myBar");
							elem.style.width = 100 + "%";
                            elem.innerHTML = 100  + "%";
                            $('#myProgress').css('display','none');
                            
					    },
					    cache: false,
					    contentType: false,
					    processData: false
					});
				} else {
					dialogo_zebra("Debe selecionar una archivo",'warning','Alerta de '+gtitle,300,'');
				}   
			    },1000);
			    
				/*if ($('#' + id_input_file)[0].files[0] != undefined) {
					$("#btnSave").attr("disabled", true);
					$("#btnCancel").attr("disabled", true);
					$("#btnSave").css("opacity", 0.7);
					$("#btnCancel").css("opacity", 0.7);

					$("#AjaxLoading").css("display","block");
					precarga('block');

					$('#upload_' + id_input_file).removeClass('dn');

					var formData = new FormData();
					formData.append("file", $('#' + id_input_file)[0].files[0]);
					formData.append("iIdDetalleDocumento", id);
					formData.append("fase", fase);
					formData.append("fase_id", fase_id);
					formData.append("iIdLocal", iIdLocal);
					formData.append("iIdDetalleFormulario", iIdDetalleFormulario);
					$('#myProgress').css('display','block');
					move();
					$.ajax({
					    url: gurl + "locales/registro/create_detalledocumento",
					    type: 'POST',
					    data: formData,
					    async: false,
					    success: function(response) {
					        var data = JSON.parse(response);
					        if (data.iIdDetalleDocumento) {
					        	$(that).attr("data-file-name", data.vDocumento);
					        	$("#label_" + id_input_file).text(data.vDocumento);
					        	$("#label_" + id_input_file).attr("title", data.vDocumento);
					        	$("#label_" + id_input_file).removeClass('dn');
					        	$("#date_update_" + id_input_file + " input")[0].value = data.dModificacion;
								dialogo_zebra("Se Actualizo Satisfactoriamente",'confirmation','Alerta de '+gtitle,300,'');

								var opciones = '';
								<?php
								if (in_array(3, $opciones)) {
								?>
									opciones += '<option value="2">Actualizar</option><option value="3">Descargar</option>';
								<?php
								}
								if (in_array(4, $opciones)) {
								?>
									opciones += '<option value="4">Eliminar</option>';
								<?php
								}
								?>
								$(that).html('<option value="">Opción</option><option value="1">Ver</option>' + opciones);
								$('#' + id_input_file).addClass('dn');
							}
					        $("#AjaxLoading").css("display","none");
							precarga('none');
							$('#date_update_' + id_input_file).removeClass('dn');

							$('#upload_' + id_input_file).addClass('dn');
							$("#btnSave").attr("disabled", false);
							$("#btnCancel").attr("disabled", false);
							$("#btnSave").css("opacity", 1);
							$("#btnCancel").css("opacity", 1);
							
							var elem = document.getElementById("myBar");
							elem.style.width = 100 + "%";
                            elem.innerHTML = 100  + "%";
                            $('#myProgress').css('display','none');
                            
					    },
					    cache: false,
					    contentType: false,
					    processData: false
					});
				} else {
					dialogo_zebra("Debe selecionar una archivo",'warning','Alerta de '+gtitle,300,'');
				}*/
			break;
		}
		$(that).val("").change();
	}
}
</script>


<style type="text/css">
.formulario{
	font-size:10px;
}
</style>

<form name="frm_permiso_campo" id="frm_permiso_campo" method='post' class="formulario" action="<?php echo base_url()?>usuario/registro_usuario/agregar_permisocampo">

<img class="fl" src="<?php echo base_url().'public/images/u322_normal.png'?>" />
<div class="title_frm fl w400 mt_15 ml_10 fs_20 normal">Administrar columnas - Datos a mostrar</div>

<div class="clear mb_5"></div>

<label class="label w470 lh_20 mb_2 ml_15 fs_13">Seleccione el nombre de las columnas que se podr&aacute;n mostrar para este usuario</label>

<input type="checkbox" id="seleccionar_todo" class="w10 fl mt_3 ml_10" value="1" onchange="sel_todo(this)" />
<label class="fl label w90 lh_20 mb_2 ml_5">Seleccionar todo</label>
<input type="checkbox" id="deseleccionar_todo" class="w10 fl mt_3" value="1" onchange="desel_todo(this)" />
<label class="fl label w90 lh_20 mb_2 ml_5">Deseleccionar todo</label>

<div class="clear mb_10"></div>

<?php foreach($permisocampo as $key=>$row):?>
	<div class="fila ml_10 w170 fl">
	<input type="checkbox" permiso='ok' id="<?php echo $row->iIdDetalleFormulario?>" <?php if($row->iPermiso== 1)echo "checked='checked'";?> class="w10 fl mt_3" value="1"/>
	<label class="fl label w150 lh_20 mb_2 ml_5"><?php echo $row->vNombre?>:</label>
	</div>
<?php endforeach;?>

<div class="clear mb_5"></div>

<div class="fila_mantenedor">
	    <span id="mensaje_mantenedor"></span>
</div>

</form>


<script type="text/javascript">

function data_array_temp(){
	
	var flag = 0;
	
	$("input[permiso='ok']").each(function(){
		var iPermiso = 0;
		if($(this).is(':checked')==true)iPermiso = 1
		detalle.push({
			"iIdDetalleFormulario"	: $(this).attr("id"),
			"iPermiso"				: iPermiso
		});
	});	
		
	if(detalle.length == 0){
		//alert("Debe ingresar una Muestra");
		flag = 1;
	}
	
	return flag;
	
}

function sel_todo(obj){
	$('#deseleccionar_todo').prop('checked',false);
	if($(obj).is(':checked') == true){
		$("input[permiso='ok']").prop('checked',true);
	}
}

function desel_todo(obj){
	$('#seleccionar_todo').prop('checked',false);
	if($(obj).is(':checked') == true){
		$("input[permiso='ok']").prop('checked',false);
	}
}


</script>
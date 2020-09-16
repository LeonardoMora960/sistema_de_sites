<label class="label w100p lh_20 mb_10">3. Seleccione</label>
<label class="label w140 lh_20 mb_2 ml_20">Formulario:</label>
<select name="formulario_fase_tres" id="formulario_fase_tres" class="bordercaja w240 fl lh_15 mb_7" validar="ok">
	<option value="">[--Seleccione--]</option>
	<?php foreach($registers as $register): ?>
	<option value="<?= $register->id ?>" data-estatus="<?= $register->estatus ?>" data-nombre="<?= $register->nombre ?>"><?= $register->nombre . ' - ' . $register->estatus ?></option>
	<?php endforeach ?>
</select>
<input type="button" value="Recuperar" id="btn__fase_tres_rec" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Eliminar" id="btn__fase_tres_del" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Editar" id="btn__fase_tres_edit" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Crear" id="btn__fase_tres_rew" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
<div id="form__fase_tres" class="dn">
	<div class="clear mb_10"></div>
	<label class="label w140 lh_20 mb_2 ml_20">Nombre:</label>
	<input type="hidden" name="id" id="form__fase_tres_id" />
	<input id="form__fase_tres_nombre" name="form__fase_tres_nombre" type="text" class="bordercaja w240 fl lh_15 mb_7" validar="ok" value="" />
	<input type="button" value="Cancelar" id="btn__fase_tres_cancel" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
	<input type="button" value="Guardar" id="btn__fase_tres_save" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
</div>
<div class="clear mb_10"></div>
<div id="resultado_select_fase_cuatro"></div>

<script>
$(document).ready(function () {
	var id_formulario = <?= $id_formulario ?>;

	$("#formulario_fase_tres").change(function() {
		$("#btn__fase_tres_del").addClass("dn");
		$("#btn__fase_tres_rew").addClass("dn");
		$("#box_registers_campos").addClass("dn");
		limpieza('frm_formulario');
		$("#resultado_select_fase_cuatro").html("");
		if ($(this).val() != "") {
			$("#btn__fase_tres_edit").removeClass("dn");
			$("#form__fase_tres").addClass("dn");
			if ($("#formulario_fase_tres option:selected").attr("data-estatus") == "activo") {
				$("#btn__fase_tres_del").removeClass("dn");
				$("#btn__fase_tres_rec").addClass("dn");
			} else {
				$("#btn__fase_tres_rec").removeClass("dn");
			}
			$("#box_registers_campos").removeClass("dn");
			selectFaseCuatro($(this).val());
			Buscar(false, false, 3, $(this).val());
		} else {
			$("#formulario_fase_cuatro").val("");
			$("#resultado_select_fase_cuatro").html("");
			$("#btn__fase_tres_edit").addClass("dn");
			$("#btn__fase_tres_rew").removeClass("dn");
		}
		$("#vNombreBusqueda").val("");
	});

	$("#btn__fase_tres_edit").click(function() {
		$("#form__fase_tres").removeClass("dn");
		$("#form__fase_tres_id").val($("#formulario_fase_tres").val());
		$("#form__fase_tres_nombre").val($("#formulario_fase_tres option:selected").attr("data-nombre"));
	});

	$("#btn__fase_tres_rew").click(function() {
		$("#form__fase_tres").removeClass("dn");
	});

	$("#btn__fase_tres_del").click(function() {
		$("#form__fase_tres").addClass("dn");
		deleteFaseTres();
	});

	$("#btn__fase_tres_rec").click(function() {
		$("#form__fase_tres").addClass("dn");
		restoreFaseTres();
	});

	$("#btn__fase_tres_cancel").click(function() {
		$("#form__fase_tres").addClass("dn");
	});

	$("#btn__fase_tres_save").click(function() {
		saveFaseTres();
	});

	function saveFaseTres() {
		var id = $("#form__fase_tres_id").val();
		var nombre = $("#form__fase_tres_nombre").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/guardar_fase_tres',
			data: { id, nombre, id_formulario },
			success: function(response) {
				selectFaseTres(id_formulario);
			}
		});
	}

	function deleteFaseTres() {
		var id = $("#formulario_fase_tres").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/eliminar_fase_tres',
			data: { id },
			success: function(response) {
				selectFaseTres(id_formulario);
			}
		});
	}

	function restoreFaseTres() {
		var id = $("#formulario_fase_tres").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/recuperar_fase_tres',
			data: { id },
			success: function(response) {
				selectFaseTres(id_formulario);
			}
		});
	}
});

function selectFaseCuatro(select_fase_tres) {
	$.ajax({
		type: 'POST',
		url: 'administracion_formulario/select_fase_cuatro',
		data: { select_fase_tres },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#resultado_select_fase_cuatro").html(response);
			formularioFilter(3, select_fase_tres);
		}
	});
}
</script>
<label class="label w100p lh_20 mb_10">2. Seleccione</label>
<label class="label w140 lh_20 mb_2 ml_20">Formulario:</label>
<select name="formulario_fase_dos" id="formulario_fase_dos" class="bordercaja w240 fl lh_15 mb_7" validar="ok">
	<option value="">[--Seleccione--]</option>
	<?php foreach($registers as $register): ?>
	<option value="<?= $register->id ?>" data-estatus="<?= $register->estatus ?>" data-nombre="<?= $register->nombre ?>"><?= $register->nombre . ' - ' . $register->estatus ?></option>
	<?php endforeach ?>
</select>
<input type="button" value="Recuperar" id="btn__fase_dos_rec" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Eliminar" id="btn__fase_dos_del" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Editar" id="btn__fase_dos_edit" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Crear" id="btn__fase_dos_rew" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
<div id="form__fase_dos" class="dn">
	<div class="clear mb_10"></div>
	<label class="label w140 lh_20 mb_2 ml_20">Nombre:</label>
	<input type="hidden" name="id" id="form__fase_dos_id" />
	<input id="form__fase_dos_nombre" name="form__fase_dos_nombre" type="text" class="bordercaja w240 fl lh_15 mb_7" validar="ok" value="" />
	<input type="button" value="Cancelar" id="btn__fase_dos_cancel" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
	<input type="button" value="Guardar" id="btn__fase_dos_save" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
</div>
<div class="clear mb_10"></div>
<div id="resultado_select_fase_tres"></div>

<script>
$(document).ready(function () {
	var id_formulario = <?= $id_formulario ?>;

	$("#formulario_fase_dos").change(function() {
		$("#btn__fase_dos_del").addClass("dn");
		$("#btn__fase_dos_rew").addClass("dn");
		$("#btn__fase_dos_edit").addClass("dn");
		if ($(this).val() != "") {
			$("#btn__fase_dos_edit").removeClass("dn");
			$("#form__fase_dos").addClass("dn");
			if ($("#formulario_fase_dos option:selected").attr("data-estatus") == "activo") {
				$("#btn__fase_dos_del").removeClass("dn");
				$("#btn__fase_dos_rec").addClass("dn");
			} else {
				$("#btn__fase_dos_rec").removeClass("dn");
			}
			selectFaseTres($(this).val());
		} else {
			$("#formulario_fase_tres").val("");
			$("#resultado_select_fase_tres").html("");
			$("#btn__fase_dos_edit").addClass("dn");
			$("#btn__fase_dos_rew").removeClass("dn");
		}
		$("#box_registers_campos").addClass("dn");
		$("#vNombreBusqueda").val("");
	});

	$("#btn__fase_dos_edit").click(function() {
		$("#form__fase_dos").removeClass("dn");
		$("#form__fase_dos_id").val($("#formulario_fase_dos").val());
		$("#form__fase_dos_nombre").val($("#formulario_fase_dos option:selected").attr("data-nombre"));
	});

	$("#btn__fase_dos_rew").click(function() {
		$("#form__fase_dos").removeClass("dn");
	});

	$("#btn__fase_dos_del").click(function() {
		$("#form__fase_dos").addClass("dn");
		deleteFaseDos();
	});

	$("#btn__fase_dos_rec").click(function() {
		$("#form__fase_dos").addClass("dn");
		restoreFaseDos();
	});

	$("#btn__fase_dos_cancel").click(function() {
		$("#form__fase_dos").addClass("dn");
	});

	$("#btn__fase_dos_save").click(function() {
		saveFaseDos();
	});

	function saveFaseDos() {
		var id = $("#form__fase_dos_id").val();
		var nombre = $("#form__fase_dos_nombre").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/guardar_fase_dos',
			data: { id, nombre, id_formulario },
			success: function(response) {
				selectFaseDos(id_formulario);
			}
		});
	}

	function deleteFaseDos() {
		var id = $("#formulario_fase_dos").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/eliminar_fase_dos',
			data: { id },
			success: function(response) {
				selectFaseDos(id_formulario);
			}
		});
	}

	function restoreFaseDos() {
		var id = $("#formulario_fase_dos").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/recuperar_fase_dos',
			data: { id },
			success: function(response) {
				selectFaseDos(id_formulario);
			}
		});
	}

});

function selectFaseTres(select_fase_dos) {
	$.ajax({
		type: 'POST',
		url: 'administracion_formulario/select_fase_tres',
		data: { select_fase_dos },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#resultado_select_fase_tres").html(response);
			formularioFilter(2, select_fase_dos);
		}
	});
}

function formularioFilter(fase, fase_id) {
	$.ajax({
		type: 'POST',
		url: 'administracion_formulario/formulario_filter',
		data: { fase, fase_id },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#filter_formulario").html(response);
		}
	});
}
</script>
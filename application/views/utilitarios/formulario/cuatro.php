<label class="label w100p lh_20 mb_10">4. Seleccione</label>
<label class="label w140 lh_20 mb_2 ml_20">Formulario:</label>
<select name="formulario_fase_cuatro" id="formulario_fase_cuatro" class="bordercaja w240 fl lh_15 mb_7" validar="ok">
	<option value="">[--Seleccione--]</option>
	<?php foreach($registers as $register): ?>
	<option value="<?= $register->id ?>" data-estatus="<?= $register->estatus ?>" data-nombre="<?= $register->nombre ?>"><?= $register->nombre . ' - ' . $register->estatus ?></option>
	<?php endforeach ?>
</select>
<input type="button" value="Recuperar" id="btn__fase_cuatro_rec" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Eliminar" id="btn__fase_cuatro_del" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Editar" id="btn__fase_cuatro_edit" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Crear" id="btn__fase_cuatro_rew" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
<div id="form__fase_cuatro" class="dn">
	<div class="clear mb_10"></div>
	<label class="label w140 lh_20 mb_2 ml_20">Nombre:</label>
	<input type="hidden" name="id" id="form__fase_cuatro_id" />
	<input id="form__fase_cuatro_nombre" name="form__fase_cuatro_nombre" type="text" class="bordercaja w240 fl lh_15 mb_7" validar="ok" value="" />
	<input type="button" value="Cancelar" id="btn__fase_cuatro_cancel" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
	<input type="button" value="Guardar" id="btn__fase_cuatro_save" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
</div>
<div class="clear mb_10"></div>
<div id="resultado_select_fase_cinco"></div>

<script>
$(document).ready(function () {
	var id_formulario = <?= $id_formulario ?>;

	$("#formulario_fase_cuatro").change(function() {
		$("#btn__fase_cuatro_del").addClass("dn");
		$("#btn__fase_cuatro_rew").addClass("dn");
		$("#box_registers_campos").addClass("dn");
		limpieza('frm_formulario');
		if ($(this).val() != "") {
			$("#btn__fase_cuatro_edit").removeClass("dn");
			$("#form__fase_cuatro").addClass("dn");
			if ($("#formulario_fase_cuatro option:selected").attr("data-estatus") == "activo") {
				$("#btn__fase_cuatro_del").removeClass("dn");
				$("#btn__fase_cuatro_rec").addClass("dn");
			} else {
				$("#btn__fase_cuatro_rec").removeClass("dn");
			}
			$("#box_registers_campos").removeClass("dn");
			selectFaseCinco($(this).val());
			Buscar(false, false, 4, $(this).val());
		} else {
			$("#formulario_fase_cinco").val("");
			$("#resultado_select_fase_cinco").html("");
			$("#formulario_fase_tres").change();
			$("#btn__fase_cuatro_edit").addClass("dn");
			$("#btn__fase_cuatro_rew").removeClass("dn");
		}
		$("#vNombreBusqueda").val("");
	});

	$("#btn__fase_cuatro_edit").click(function() {
		$("#form__fase_cuatro").removeClass("dn");
		$("#form__fase_cuatro_id").val($("#formulario_fase_cuatro").val());
		$("#form__fase_cuatro_nombre").val($("#formulario_fase_cuatro option:selected").attr("data-nombre"));
	});

	$("#btn__fase_cuatro_rew").click(function() {
		$("#form__fase_cuatro").removeClass("dn");
	});

	$("#btn__fase_cuatro_del").click(function() {
		$("#form__fase_cuatro").addClass("dn");
		deleteFaseCuatro();
	});

	$("#btn__fase_cuatro_rec").click(function() {
		$("#form__fase_cuatro").addClass("dn");
		restoreFaseCuatro();
	});

	$("#btn__fase_cuatro_cancel").click(function() {
		$("#form__fase_cuatro").addClass("dn");
	});

	$("#btn__fase_cuatro_save").click(function() {
		saveFaseCuatro();
	});

	function saveFaseCuatro() {
		var id = $("#form__fase_cuatro_id").val();
		var nombre = $("#form__fase_cuatro_nombre").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/guardar_fase_cuatro',
			data: { id, nombre, id_formulario },
			success: function(response) {
				selectFaseCuatro(id_formulario);
			}
		});
	}

	function deleteFaseCuatro() {
		var id = $("#formulario_fase_cuatro").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/eliminar_fase_cuatro',
			data: { id },
			success: function(response) {
				selectFaseCuatro(id_formulario);
			}
		});
	}

	function restoreFaseCuatro() {
		var id = $("#formulario_fase_cuatro").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/recuperar_fase_cuatro',
			data: { id },
			success: function(response) {
				selectFaseCuatro(id_formulario);
			}
		});
	}
});

function selectFaseCinco(select_fase_cuatro) {
	$.ajax({
		type: 'POST',
		url: 'administracion_formulario/select_fase_cinco',
		data: { select_fase_cuatro },
		success: function(response) {
			if(!response){
				window.location.reload();
			}
			$("#resultado_select_fase_cinco").html(response);
			formularioFilter(4, select_fase_cuatro);
		}
	});
}
</script>
<label class="label w100p lh_20 mb_10">5. Seleccione</label>
<label class="label w140 lh_20 mb_2 ml_20">Formulario:</label>
<select name="formulario_fase_cinco" id="formulario_fase_cinco" class="bordercaja w240 fl lh_15 mb_7" validar="ok">
	<option value="">[--Seleccione--]</option>
	<?php foreach($registers as $register): ?>
	<option value="<?= $register->id ?>" data-estatus="<?= $register->estatus ?>" data-nombre="<?= $register->nombre ?>"><?= $register->nombre . ' - ' . $register->estatus ?></option>
	<?php endforeach ?>
</select>
<input type="button" value="Recuperar" id="btn__fase_cinco_rec" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Eliminar" id="btn__fase_cinco_del" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Editar" id="btn__fase_cinco_edit" class="btn fl fs_11 w80 dn" style="height: 20px;margin-left: 0.5em;" />
<input type="button" value="Crear" id="btn__fase_cinco_rew" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
<div id="form__fase_cinco" class="dn">
	<div class="clear mb_10"></div>
	<label class="label w140 lh_20 mb_2 ml_20">Nombre:</label>
	<input type="hidden" name="id" id="form__fase_cinco_id" />
	<input id="form__fase_cinco_nombre" name="form__fase_cinco_nombre" type="text" class="bordercaja w240 fl lh_15 mb_7" validar="ok" value="" />
	<input type="button" value="Cancelar" id="btn__fase_cinco_cancel" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
	<input type="button" value="Guardar" id="btn__fase_cinco_save" class="btn fl fs_11 w80" style="height: 20px;margin-left: 0.5em;" />
</div>
<div class="clear mb_10"></div>
<div id="resultado_select_fase_cinco"></div>

<script>
$(document).ready(function () {
	var id_formulario = <?= $id_formulario ?>;

	$("#formulario_fase_cinco").change(function() {
		$("#btn__fase_cinco_del").addClass("dn");
		$("#btn__fase_cinco_rew").addClass("dn");
		$("#box_registers_campos").addClass("dn");
		limpieza('frm_formulario');
		if ($(this).val() != "") {
			$("#btn__fase_cinco_edit").removeClass("dn");
			$("#form__fase_cinco").addClass("dn");
			if ($("#formulario_fase_cinco option:selected").attr("data-estatus") == "activo") {
				$("#btn__fase_cinco_del").removeClass("dn");
				$("#btn__fase_cinco_rec").addClass("dn");
			} else {
				$("#btn__fase_cinco_rec").removeClass("dn");
			}
			$("#box_registers_campos").removeClass("dn");
			Buscar(false, false, 5, $(this).val());
		} else {
			$("#formulario_fase_cuatro").change();
			$("#btn__fase_cinco_edit").addClass("dn");
			$("#btn__fase_cinco_rew").removeClass("dn");
		}
		$("#vNombreBusqueda").val("");
	});

	$("#btn__fase_cinco_edit").click(function() {
		$("#form__fase_cinco").removeClass("dn");
		$("#form__fase_cinco_id").val($("#formulario_fase_cinco").val());
		$("#form__fase_cinco_nombre").val($("#formulario_fase_cinco option:selected").attr("data-nombre"));
	});

	$("#btn__fase_cinco_rew").click(function() {
		$("#form__fase_cinco").removeClass("dn");
	});

	$("#btn__fase_cinco_del").click(function() {
		$("#form__fase_cinco").addClass("dn");
		deleteFaseCinco();
	});

	$("#btn__fase_cinco_rec").click(function() {
		$("#form__fase_cinco").addClass("dn");
		restoreFaseCinco();
	});

	$("#btn__fase_cinco_cancel").click(function() {
		$("#form__fase_cinco").addClass("dn");
	});

	$("#btn__fase_cinco_save").click(function() {
		saveFaseCinco();
	});

	function saveFaseCinco() {
		var id = $("#form__fase_cinco_id").val();
		var nombre = $("#form__fase_cinco_nombre").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/guardar_fase_cinco',
			data: { id, nombre, id_formulario },
			success: function(response) {
				selectFaseCinco(id_formulario);
			}
		});
	}

	function deleteFaseCinco() {
		var id = $("#formulario_fase_cinco").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/eliminar_fase_cinco',
			data: { id },
			success: function(response) {
				selectFaseCinco(id_formulario);
			}
		});
	}

	function restoreFaseCinco() {
		var id = $("#formulario_fase_cinco").val();
		$.ajax({
			type: 'POST',
			url: 'administracion_formulario/recuperar_fase_cinco',
			data: { id },
			success: function(response) {
				selectFaseCinco(id_formulario);
			}
		});
	}
});
</script>
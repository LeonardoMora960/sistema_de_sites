<script>
fase = <?= $fase ?>;
fase_id = <?= $fase_id ?>;
</script>
<div style="width:59.5em">
	<div class="titleLocalReg" style="margin-left: 1.2em;">
		<?= $fase_tres_selecionada->inicial ?>

		>

		<?= $fase_tres_selecionada->final ?>

		<?php
		$is_campos_uno = count($columna);
		$is_active_uno = false;
		$refresh_uno = false;
		$is_active_id = 0;
		if (!empty($fase_cuatro)) {
		?>

		>

		<select name="select__fase_cuatro" id="select__fase_cuatro" style="width: 8em;">
			<option value="0">[ --Seleccionar-- ]</option>
			<?php
			foreach ($fase_cuatro as $fase) {
				if ($is_campos_uno == 0 &&
					((int) $this->registro->buscar_campo_first([4, $fase->id])->total > 0 || !empty($fase_cinco))
				) {
					$is_active_uno = true;
					$is_active_id = $fase->id;
				}
			?>
			<option value="<?= $fase->id ?>" <?= ($fase_cuatro_id == $fase->id) || $is_active_uno ? 'selected': '' ?>><?= $fase->nombre ?></option>
			<?php
				if ($is_active_uno) {
					$is_active_uno = false;
					$is_campos_uno = 1;
					$refresh_uno = true;
				}
			}
			?>
		</select>
		<?php
		}

		if (!empty($fase_cinco)) {
		?>

		>

		<select name="select__fase_cinco" id="select__fase_cinco" style="width: 8em;">
			<option value="0">[ --Seleccionar-- ]</option>
			<?php
			if (count($fase_cinco) > 0) {
				foreach ($fase_cinco as $fase) {
			?>
				<option value="<?= $fase->id ?>" <?= ($fase_cinco_id == $fase->id) ? 'selected': '' ?>><?= $fase->nombre ?></option>
			<?php
				}
			}
			?>
		</select>
		<?php
		}
		?>
		<br />
		<br />
	</div>

<script>
var is_active_id = (is_active_id > 0) ? 0 : <?= $is_active_id ?>;

$(document).ready(function () {
	var id_formulario = <?= $id_formulario ?>;
	var fase_tres_id = <?= $fase_tres_id ?>;
	var fase_cuatro_id = <?= (empty($fase_cuatro_id) ? 0: $fase_cuatro_id) ?>;
	var fase_cinco_id = <?= (empty($fase_cinco_id) ? 0: $fase_cinco_id) ?>;

	$("#select__fase_cuatro").change(function() {
		var id = $(this).val();
		if (id != "") {
			cargarFormularioCampos(4, id, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		} else {
			cargarFormularioCampos(3, id_formulario, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		}
	});

	$("#select__fase_cinco").change(function() {
		var id = $(this).val();
		if (id != "") {
			cargarFormularioCampos(5, id, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		} else {
			cargarFormularioCampos(4, id_formulario, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		}
	});
	
	$('input[type=number]').keypress(function(e) {
		if($(this).attr("id") == 'fase_3_fase_id_5_msnm_metros'){
              if($(this).val().length > 3){
                return false;
            }
        }
        
		if($(this).attr("id") == 'fase_3_fase_id_5_altura_de_edificio_metros'){
              if($(this).val().length > 2){
                return false;
            }
        }
	});

	$('input[type=number]').keyup(function(e) {
		if (e.originalEvent.keyCode === 69) {
			$(this).val('');
		}
	});

	<?php
	if ($refresh_uno) {
	?>
	if (is_active_id > 0) {
		$("#select__fase_cuatro").change();
	}
	<?php
	}
	?>
});
</script>

	<?php
	$column_number = 0;
	if (count($columna) > 0) {
		$attributes = ['id' => 'frm_tabla', 'class' => 'formulario', 'style' => 'margin-left: 1em;height: 400px; overflow-y: auto;' ];
		echo form_open(base_url() . 'locales/registro/' . 'agregar_local', $attributes);
	?>
	<?php foreach ($columna as $row): ?>
		<?php
		$column_number++;
		if ($column_number > 2) {
			$column_number = 1;
		}
		?>
		<div class="ml_10" style="width: <?= ($row['iIdTipoCampo'] != 7) ? "320px":"97%" ?>;display: inline-block; vertical-align: top;">
			<?php if ($row['iIdTipoCampo'] == 2): ?>
				<label class="label w320 lh_20 mb_2"><?= $row['vNombre'] ?>:</label>
				<textarea id="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" class="al bordercaja w265 fl lh_15 mb_7 h_80"
					<?php if ($row['cObligatorio'] == 1): ?>
						validar="ok"
					<?php endif; ?>
				>
				</textarea>

				<?php if ($row['cObligatorio'] == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($row['iIdTipoCampo'] == 1 || $row['iIdTipoCampo'] == 6): ?>
				<label class="label w320 lh_20 mb_2"><?= $row['vNombre'] ?>:</label>
				<input id="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" type="<?= ($row['cNumerico'] == 1) ? 'number': 'text' ?>" class="bordercaja w265 fl lh_15 mb_7 <?php if ($row['iIdTipoCampo'] == 6) echo "calendario" ?> <?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>"
					<?php if ($row['cNumerico'] == 1): ?>
						pattern="\d*" step="1"
					<?php endif; ?>
					<?php if ($row['cObligatorio'] == 1): ?>
						validar="ok"
					<?php endif; ?>
						value=""
					<?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_codigo_de_local'): ?>
					<?php endif;?>
					
					<?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_ubigeo'): ?>
					disabled
					<?php endif; ?>
				/>

				<?php if ($row['cObligatorio'] == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>

				<?php if ($row['iIdTipoCampo'] == 6): ?>
					<script type="text/javascript">
					$("#<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>").datepicker({
						dateFormat: 'dd/mm/yy',
						defaultDate: "+1w",
						changeMonth: true,
						numberOfMonths: 1,
						changeYear: true
					});
					</script>
				<?php endif; ?>
			<?php endif; ?>

		<?php if ($row['iIdTipoCampo'] == 7): ?>
		<?php $row['iIdDetalleFormulario'] = 1 ?>
			<?php $file_documento = $this->registro->buscar_documento_first([$row['iIdDetalleFormulario'], $row['locales_formulario_fase'], $row['locales_formulario_fase_id'], '']); ?>
		<label class="label w<?= (empty($isDocumento)) ? '180': '118' ?> lh_20 mb_2"><?= $row['vNombre'] ?>:</label>
				<?php $column_number = 2;?>
		<?php if (!empty($file_documento->vDocumento)) { ?>

		<input type="file" id="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" class="dn" onChange="selectFile(this, '<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>', <?= $row['iIdDetalleFormulario'] ?>)" />

		<label for="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>"
			class="fl ml_20 lh_15 mb_7 <?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>"
			id="label_<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>"
			style="overflow: auto;width: 250px;"
			title="<?= $file_documento->vDocumento ?>"
		>
			<?= $file_documento->vDocumento ?>
		</label>

		<?php } else { ?>

		<input id="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" type="file" class="bordercaja fl lh_15 mb_7 <?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>" onChange="selectFile(this, '<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>', <?= $row['iIdDetalleFormulario'] ?>)"
		
		<?php if ($row['cObligatorio'] == 1): ?>
		validar="ok"
		<?php endif; ?>
		
		<?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_codigo_de_local'): ?>
		readonly="readonly"
		<?php endif;?>
		/>

		<label for="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>"
			class="dn fl ml_20 lh_15 mb_7 <?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>"
			id="label_<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>"
			style="overflow: auto;width: 250px;"
			title=""
		></label>

		<?php } ?>
		
		<?php if ($row['cObligatorio'] == 1): ?>
		<span class="fl ml_10 rojo">(*)</span>
		<?php endif; ?>

		<div>
			<div id="option_<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" class="<?= empty($file_documento->vDocumento) ? 'dn': '' ?> fl ml_20 mb_10">
			    <select class="select__menu" onclick="clickUploadDocument(this)"
onchange="opcionSelectFile(this, <?= $row['iIdDetalleFormulario'] ?>, '<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>', <?= $row['iIdDetalleFormulario'] ?>)" data-file-name="<?= urlencode($file_documento->vDocumento) ?>">
			      <option value="">Opción<option>
			    <?php if (!empty($file_documento->vDocumento)) { ?>
			      <option value="1">Ver</option>
			    <?php } ?>
			      <?php if(in_array(3, $opciones)):?>
			     <?php if (empty($file_documento->vDocumento)) { ?>
			      <option value="5">Subir</option>
			     <?php } ?>
			    <?php if (!empty($file_documento->vDocumento)) { ?>
			      <option value="2">Actualizar</option>
			    <?php } ?>
			      <?php endif; ?>
			    <?php if (!empty($file_documento->vDocumento)) { ?>
			      <option value="3">Descargar</option>
			      <?php if(in_array(4, $opciones)): ?>
			      <option value="4">Eliminar</option>
			      <?php endif; ?>
			    <?php } ?>
			    </select>
			</div>
			<div id="date_update_<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" class="<?= empty($file_documento->vDocumento) ? 'dn': '' ?> fl ml_20 mb_10">
				<input type="text" value="<?= !empty($file_documento->vDocumento) ? date('d/m/Y h:m:s a', strtotime($file_documento->dModificacion)): '' ?>" disabled style="width: 11em;position: absolute;" />
			</div>
		</div>

		<?php endif; ?>

			<?php if ($row['iIdTipoCampo'] == 3): ?>
				<label class="label w180 lh_20 mb_2"><?= $row['vNombre'] ?>:</label>
				<select name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" id="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" class="bordercaja w265 fl lh_15 mb_7"
					<?php if ($row['cObligatorio'] == 1): ?>
						validar="ok"
					<?php endif; ?>

					<?php if ($row['campo'] == 'departamento'): ?>
					onChange="recuperar_select_controller_id_ubigeo_inicio(this.value, '<?= base_url() . 'locales/registro/recuperar_provincia_departamento' ?>', '<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' .  $row['locales_formulario_fase_id'] . '_provincia'  ?>','<?= 'fase_' .  $row['locales_formulario_fase'] . '_fase_id_' .  $row['locales_formulario_fase_id'] . '_departamento'  ?>');"
					<?php endif;?>
					
					<?php if ($row['campo'] == 'provincia'):?>
					onChange="recuperar_select_controller_id_ubigeo_inicio(this.value, '<?= base_url() . 'locales/registro/recuperar_distrito_provincia'?>', '<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' .  $row['locales_formulario_fase_id']	 . '_distrito'?>','<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' .  $row['locales_formulario_fase_id'] . '_provincia'  ?>');"
					<?php endif;?>


					<?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_distrito'): ?>
						onchange="recuperar_ubigeo()"
					<?php endif; ?>
				>
					<option value="0">[ --Seleccionar-- ]</option>
					<?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] != 'fase_3_fase_id_2_provincia' && 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] != 'fase_3_fase_id_2_distrito'): ?>
						<?php $tabla = $this->registro->get_tabla('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo']);?>

						<?php if (empty($tabla)): ?>
							No existen registros
						<?php endif; ?>

						<?php foreach($tabla as $row_tabla): ?>
							<option value="<?= $row_tabla->id ?>"
								<?php if ('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] == 'fase_3_fase_id_2_departamento'): ?>
									vCodigo="<?= $row_tabla->vCodigo ?>"
								<?php endif;?>
							>
								<?= $row_tabla->vNombre ?>
							</option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>

				<?php if ($row['cObligatorio'] == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($row['iIdTipoCampo'] == 5): ?>
				<label class="w150 fl lh_15 mb_7"><?= $row['vNombre'] ?>:</label>
				<?php if ($row['cObligatorio'] == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>
				<div class="clear"></div>

				<?php $tabla = $this->registro->get_tabla('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo']);?>
				
				<?php if (empty($tabla)): ?>
					No existen registros
				<?php endif; ?>

				<?php foreach($tabla as $row_tabla): ?>
					<input id="<?= $row_tabla->id . '_fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" type="radio"
						<?php if ($row['cObligatorio'] == 1): ?>
							required
							validar="ok"
						<?php endif; ?>
							value="<?= $row_tabla->id ?>"
					/>

					<label for="<?= $row_tabla->id . '_fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>"><?= $row_tabla->vNombre ?></label>
					<br>

				<?php endforeach; ?>

				<br />
			<?php endif; ?>

			<?php if ($row['iIdTipoCampo'] == 4): ?>
				<label class="w150 fl lh_15 mb_7"><?= $row['vNombre'] ?>:</label>
				<?php if ($row['cObligatorio'] == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>
				<div class="clear"></div>

				<?php $tabla = $this->registro->get_tabla('fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo']); ?>

				<?php if (empty($tabla)): ?>
					No existen registros
				<?php endif; ?>

				<?php foreach($tabla as $row_tabla): ?>
					<input id="<?= $row_tabla->id . '_fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>[]" type="checkbox"
						<?php if ($row['cObligatorio'] == 1): ?>
							required
							validar="ok"
						<?php endif; ?>
							value="<?= $row_tabla->id ?>"
					/>

					<label for="<?= $row_tabla->id . '_fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>" name="<?= 'fase_' . $row['locales_formulario_fase'] . '_fase_id_' . $row['locales_formulario_fase_id'] . '_' . $row['campo'] ?>"><?= $row_tabla->vNombre ?></label>
					<br>

			<?php endforeach; ?>
		<?php endif; ?>
	</div>
		<?php
		if ($column_number === 2) {
		?>
			<div class="clear"></div>
		<?php
		}
		?>
		<?php endforeach;?>
		<div class="clear"></div>
	</div>

	<div class="clear"></div>
	<div class="text_oblig ml_20">
		Los campos en (*) son obligatorios.
	</div>

	<div class="clear"></div>
	<?= form_close() ?>

	<div class="fl w280 ml_100">
		<?php if (in_array(2, $opciones)): ?>
			<input type="button" value="Guardar" class="btn fl" onClick="guardar_serialize('frm_tabla', true, fase, fase_id)" />
		<?php endif; ?>

		<input type="button" name="" value="Cancelar" class="btn fl ml_10" onclick="dialogo_zebra_confirmacion('¿Desea cancelar el Registro de Local y perder los datos registrados?', 'question', 'Alerta de Registro de Local', 412, '<?= base_url() . 'locales/registro/busqueda' ?>')">
	</div>

	<?php
	}
	?>

	<div class="clear mb_30"></div>
</div>
<script>
    $(document).ready(function(){
        
        jQuery.sumaTotal = function(){
            var alt1 = $('#fase_3_fase_id_2_altura_de_edificio_metros').val();
            var alt2 = $('#fase_3_fase_id_2_altura_de_estructura_metros').val();
            
            if(alt1 != '' && alt2 != ''){
                $('#fase_3_fase_id_2_altura_total').val('');
                var total = parseFloat(alt1) + parseFloat(alt2);
                $('#fase_3_fase_id_2_altura_total').val(total);
            }
        }
        
        $('#fase_3_fase_id_2_altura_de_edificio_metros').blur(function(){
            console.log(1);
            $.sumaTotal();
        });
        $('#fase_3_fase_id_2_altura_de_estructura_metros').blur(function(){
            $.sumaTotal();
        });

        
    });
</script>
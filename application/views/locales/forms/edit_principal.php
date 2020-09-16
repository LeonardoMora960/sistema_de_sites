
<script>
fase = <?= $fase ?>;
fase_id = <?= $fase_id ?>;
formulario_data = <?= json_encode($columna) ?>;
  var auxDepartamento = $("#fase_3_fase_id_2_departamento").val();
  var auxProvincia    = $("#fase_3_fase_id_2_provincia").val();
  var auxDistrito     = $("#fase_3_fase_id_2_distrito").val();
    
    
</script>
<?php  
	$nombreSitio = 'fase_3_fase_id_2_nombre_del_sitio';
	$nombreSitio = $nombre_sitio->$nombreSitio;
?>
<div id="resultado_impresion" style="width: 59.5em;">
	<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?= base_url() . 'public/images/logo_telefonica.png' ?>" />
	<div class="clear"></div>
	
	<div class="titleLocalReg">
		<div class ="col-md-9" style="margin-left: 1em">
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
				if (
					$is_campos_uno == 0 &&
					((int) $this->registro->buscar_campo_first([4, $fase->id])->total > 0 || !empty($fase_cinco))
				) {
					$is_active_id = $fase->id;
					$is_active_uno = true;
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
		?></div>
		<div class="title_site col-md-3"><?=$nombreSitio?></div>
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

			cargarEditFormularioCampos(4, id, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		} else {
			cargarEditFormularioCampos(3, id_formulario, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		}
	});

	$("#select__fase_cinco").change(function() {
		var id = $(this).val();
		if (id != "") {
			cargarEditFormularioCampos(5, id, fase_tres_id, fase_cuatro_id, fase_cinco_id);
		} else {
			cargarEditFormularioCampos(4, id_formulario, fase_tres_id, fase_cuatro_id, fase_cinco_id);
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
			$(this).val('')
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
	<div class="fr">
		<?php if (in_array(5, $opciones)): ?>
		<a class="imprimir" href="javascript:void(0)" onclick="imprimir()">Imprimir / PDF</a>
		<?php endif; ?>
	</div>

	<div class="clear"></div>

	<?php
		$attributes = ['id' => 'frm_tabla', 'class' => 'formulario', 'style' => 'margin-left: 1em;height: 400px; overflow-y: auto;'];
		echo form_open(base_url() . 'locales/registro/' . 'agregar_local', $attributes);
	?>
	<input type="hidden" id="iIdLocal" name="iIdLocal" value="<?= $iIdLocal ?>" />
		<?php
		$column_number = 0;
		foreach ($columna as $key => $row):
			$campo = 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo;
			$column_number++;
			if ($column_number > 2) {
				$column_number = 1;
			}
		?>
		<div class="ml_10" style="width: <?= ($row->iIdTipoCampo != 7) ? "320px" : "97%" ?>;display: inline-block; vertical-align: top; <?= ($row->iIdTipoCampo == 7) ? 'padding-bottom:15px;padding-top:15px' : ''?>">
		
		<?php if ($row->iIdTipoCampo == 2): ?>
		<label class="label w<?= (empty($row->iIdTipoCampo != 7)) ? '320': '320' ?> lh_20 mb_2"><?= $row->vNombre ?>:</label>
		<textarea id="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" class="al bordercaja w265 fl lh_15 mb_7 h_80"

		<?php if ($row->cNumerico == 1): ?>
			pattern="\d*" step="1"
		<?php endif; ?>

		<?php if($row->cObligatorio == 1):?>
		validar="ok"
		<?php endif; ?>
		><?= $local->$campo ?>
		</textarea>
		
		<?php if ($row->cObligatorio == 1): ?>
		<span class="fl ml_10 rojo">(*)</span>
		<?php endif; ?>
		<?php endif; ?>
		
		<?php if ($row->iIdTipoCampo == 1 || $row->iIdTipoCampo == 6): ?>
		<label class="label w<?= ($row->iIdTipoCampo != 7) ? '320': '118' ?> lh_20 mb_2"><?= $row->vNombre ?>:</label>
		<input id="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" type="<?= ($row->cNumerico == 1) ? 'number': 'text' ?>" class="bordercaja w265 fl lh_15 mb_7 <?php if ($row->iIdTipoCampo == 6) echo "calendario" ?> <?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?> "
		
		<?php if ($row->cObligatorio == 1): ?>
		validar="ok"
		<?php endif; ?>
		
		value="<?php echo $local->$campo?>"

		<?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_ubigeo'): ?>
		disabled
		<?php endif; ?>
		
		<?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_codigo_de_local'): ?>
		readonly="readonly"
		<?php endif;?>
		/>
		
		<?php if ($row->cObligatorio == 1): ?>
		    <span class="fl ml_10 rojo">(*)</span>
		<?php endif; ?>


		<?php if ($row->iIdTipoCampo == 6): ?>
		<script type="text/javascript">
		$( "#<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>").datepicker({
			dateFormat: 'dd/mm/yy',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			changeYear: true
		});
		</script>
		<?php endif; ?>
		<?php endif; ?>

		<?php if ($row->iIdTipoCampo == 7): ?>
			<?php $file_documento = $this->registro->buscar_documento_first([$row->iIdDetalleFormulario, $row->locales_formulario_fase, $row->locales_formulario_fase_id, $iIdLocal]); ?>
			

		    <label class="label w<?= ($row->iIdTipoCampo != 7) ? '320': '118' ?> lh_20 mb_2"><?= $row->vNombre ?>:</label>
		        <?php $column_number = 2;?>
		        <?php if (!empty($file_documento->vDocumento)) { ?>
    
	    	    <input type="file" id="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" class="dn" onChange="selectFile(this, '<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>', <?= $row->iIdDetalleFormulario ?>)" />

		        <label for="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>"
			        class="fl ml_20 lh_15 mb_7 <?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>"
    			    id="label_<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>"
			        style="word-break: break-word;width: 220px;margin-top:5px"
			        title="<?= $file_documento->vDocumento ?>"
		        >
			    <?= $file_documento->vDocumento ?>
		    </label>
		<?php } else { ?>

		<input id="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" type="file" class="bordercaja fl lh_15 mb_7 <?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>" onChange="selectFile(this, '<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>', <?= $row->iIdDetalleFormulario ?>)"
		
		<?php if ($row->cObligatorio == 1): ?>
		validar="ok"
		<?php endif; ?>
		
		<?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_codigo_de_local'): ?>
		readonly="readonly"
		<?php endif; ?>
		/>

		<label for="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>"
			class="dn ml_20 fl lh_15 mb_7 <?php if ('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo == 'fase_3_fase_id_2_codigo_de_local') echo "caja_gris" ?>"
			id="label_<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>"
			style="overflow: auto;width: 250px;"
			title="<?= empty($file_documento->vDocumento) ? '': $file_documento->vDocumento ?>"
		>
			<?= empty($file_documento->vDocumento) ? '': $file_documento->vDocumento ?>
		</label>

		<?php } ?>
		
		<?php if ($row->cObligatorio == 1): ?>
		<span class="fl ml_10 rojo">(*)</span>
		<?php endif; ?>

		<div style="display:inline">
			<div id="option_<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" class="<?= empty($file_documento->vDocumento) ? 'dn': '' ?> fl ml_20 mb_10">
			    <select class="select__menu" onclick="clickUploadDocument(this)" onchange="opcionSelectFile(this, <?= $row->iIdDetalleFormulario ?>, '<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>', <?= $row->iIdDetalleFormulario ?>)" data-file-name="<?= urlencode($file_documento->vDocumento) ?>">
			      <option value="">Opción</option>
			    <?php if (!empty($file_documento->vDocumento)) { ?>
			      <option value="1">Ver</option>
			    <?php } ?>
			      <?php if(in_array(3, $opciones)):?>
			     <?php if (empty($file_documento->vDocumento)) { ?>
			      <option value="5">Subir</option>
			     <?php } ?>
			    <?php
			    if (!empty($file_documento->vDocumento)) {
			    ?>
			      <option value="2">Actualizar</option>
			    <?php
				}
				?>
			    <?php endif; ?>
			    <?php
			    if (!empty($file_documento->vDocumento)) {
			    ?>
			      <option value="3">Descargar</option>
			      <?php
			      if (in_array(4, $opciones)) {
			      ?>
			      <option value="4">Eliminar</option>
			      <?php
			      }
			    ?>
			    <?php
				}
				?>
			    </select>
			</div>
			<img src="../../../public/images/252.gif" id="upload_<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" class="dn">
			<div id="date_update_<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" class="<?= empty($file_documento->vDocumento) ? 'dn' : '' ?>" >
				<input type="text" value="<?= !empty($file_documento->vDocumento) ? date('d/m/Y h:m:s a', strtotime($file_documento->dModificacion)): '' ?>" disabled style="width: 11em; margin-left:10px;" class="mb_10" />

				<?php 
					$alertData = isset($alertas[$row->iIdDetalleFormulario]) ? $alertas[$row->iIdDetalleFormulario] : null;
					if($row->alert_expiration == 1 && $row->iIdTipoCampo == 7 ):?>
						<i class="create-alert rtooltip gg-alarm" id="fase_alert_<?=$row->iIdDetalleFormulario?>" alertcampo="<?=$row->iIdDetalleFormulario?>"
							style="display:inline-flex; margin-left: 10px;">
							  <span class="rtooltiptext" id="<?=$row->iIdDetalleFormulario?>_tooltip" >Defina una fecha de vencimiento</span>
						</i>
						<?php if($alertData != null):?>
							<script>console.log("<?=$alertData->alert_date?>")</script>	
							<input type="hidden" id="<?=$row->iIdDetalleFormulario?>_alert_date"
								value="<?=$alertData->alert_date?>">			
							<input type="hidden" id="<?=$row->iIdDetalleFormulario?>_id_id_alert"
								value="<?=$alertData->alert_id?>">
							<input type="hidden" id="<?=$row->iIdDetalleFormulario?>_alert_days"
								value="<?=$alertData->alert_days?>">
						<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php endif; ?>
		
		<?php if ($row->iIdTipoCampo == 3): ?>
		<label class="label w<?= ($row->iIdTipoCampo != 7) ? '320': '118' ?> lh_20 mb_2"><?= $row->vNombre ?>:</label>
		<select name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" id="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" class="bordercaja w265 fl lh_15 mb_7"
			<?php if ($row->cObligatorio == 1): ?>
			validar="ok"
			<?php endif; ?>
			<?php if ($row->campo == 'departamento'): ?>
			onChange="recuperar_select_controller_id_ubigeo_inicio(this.value, '<?= base_url() . 'locales/registro/recuperar_provincia_departamento' ?>', '<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_provincia'  ?>','<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_departamento'  ?>','<?= $local->fase_3_fase_id_2_provincia?>');"
			<?php endif;?>
			
			<?php if ($row->campo == 'provincia'):?>
			onChange="recuperar_select_controller_id_ubigeo_inicio(this.value, '<?= base_url() . 'locales/registro/recuperar_distrito_provincia'?>', '<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id	 . '_distrito'?>','<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_provincia'  ?>','<?= $local->fase_3_fase_id_2_distrito?>');"
			<?php endif;?>
			<?php if ($row->campo == 'distrito'):	?>
			onchange="recuperar_ubigeo()"
			<?php endif;?>
			>
			<option value="0">[ --Seleccionar-- ]</option>
			<?php $tabla = $this->registro->get_tabla('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo); ?>
			<?php foreach ($tabla as $row_tabla): ?>
			<option value="<?= $row_tabla->id ?>" <?php if ($row_tabla->id == $local->$campo) echo "selected='selected'"; ?>
				<?php if($row->campo == 'departamento' || $row->campo == 'distrito' 
					  || $row->campo == 'provincia' ): ?>
				vCodigo = "<?= $row_tabla->vCodigo ?>" 
				<?php endif;?>
				
			><?= $row_tabla->vNombre ?></option>
			<?php endforeach; ?>
		</select>
		
		<?php if($row->cObligatorio == 1):?>
		<span class="fl ml_10 rojo">(*)</span>
		<?php endif; ?>
		<?php endif; ?>

		<?php if($row->alert_expiration == 1 && $row->iIdTipoCampo != 7 ):
				$alertData = isset($alertas[$row->iIdDetalleFormulario]) ? $alertas[$row->iIdDetalleFormulario] : null;
					?>
				<i class="create-alert <?=$column_number == 2 ? 'r' : 'v'?>tooltip gg-alarm" id="fase_alert_<?=$row->iIdDetalleFormulario?>" alertcampo="<?=$row->iIdDetalleFormulario?>"
					style="display:inline-flex; margin-left: 10px;">
					<span class="<?=$column_number == 2 ? 'r' : 'v'?>tooltiptext" id="<?=$row->iIdDetalleFormulario?>_tooltip" >Defina una fecha de vencimiento</span>
				</i>
				<?php if($alertData != null):?>			
					<input  type="hidden" id="<?=$row->iIdDetalleFormulario?>_alert_date"
							value="<?=$alertData->alert_date?>">
					<input type="hidden" id="<?=$row->iIdDetalleFormulario?>_id_id_alert"
								value="<?=$alertData->alert_id?>">
					<input type="hidden" id="<?=$row->iIdDetalleFormulario?>_alert_days"
							value="<?=$alertData->alert_days?>">
				<?php endif; ?>
		<?php endif; ?>

		<?php if ($row->iIdTipoCampo == 5): ?>
				<label class="w150 fl lh_15 mb_7"><?= $row->vNombre ?>:</label>
				<?php if ($row->cObligatorio == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>
				<div class="clear"></div>

				<?php $tabla = $this->registro->get_tabla('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo); ?>
				<?php foreach($tabla as $row_tabla): ?>
					<input id="<?= $row_tabla->id . '_fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" type="radio"
						<?php if ($row->cObligatorio == 1): ?>
							required
							validar="ok"
						<?php endif; ?>
							value="<?= $row_tabla->id ?>"
							<?php if ($row_tabla->id == $local->$campo) echo "checked"; ?>
					/>

					<label for="<?= $row_tabla->id . '_fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>"><?= $row_tabla->vNombre ?></label>
					<br>

			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ($row->iIdTipoCampo == 4): ?>
				<label class="w150 fl lh_15 mb_7"><?= $row->vNombre ?>:</label>
				<?php if ($row->cObligatorio == 1): ?>
					<span class="fl ml_10 rojo">(*)</span>
				<?php endif; ?>
				<div class="clear"></div>

				<?php $tabla = $this->registro->get_tabla('fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo);?>
				<?php foreach($tabla as $row_tabla): ?>
					<input id="<?= $row_tabla->id . '_fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>[]" type="checkbox"
						<?php if ($row->cObligatorio == 1): ?>
							required
							validar="ok"
						<?php endif; ?>
							value="<?= $row_tabla->id ?>"
							<?php if (in_array($row_tabla->id, explode(', ', $local->$campo))) echo "checked"; ?>
					/>

					<label for="<?= $row_tabla->id . '_fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>" name="<?= 'fase_' . $row->locales_formulario_fase . '_fase_id_' . $row->locales_formulario_fase_id . '_' . $row->campo ?>"><?= $row_tabla->vNombre ?></label>

					<br>

			<?php endforeach; ?>
		<?php endif; ?>
	</div>
		<?php
		if ($column_number === 2) {
		?>
			<div class="clear" style="width: 100%;"></div>
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
</div>

<div class="fl w250 ml_100">
    <script>console.log(<?= json_encode($opciones) ?>);</script>
	<?php if (in_array(3, $opciones)): ?>
	<input type="button" value="Guardar" class="btn fl" id="btnSave" onClick="guardar_serialize('frm_tabla')" />
	<?php endif; ?>
	<input type="button" name="" value="Cancelar" id="btnCancel" class="btn fl ml_10" onclick="dialogo_zebra_confirmacion('¿Desea cancelar el Registro de Local y perder los datos ingresados?', 'question', 'Alerta de Registro de Local', 412, '<?= base_url() . 'locales/registro/busqueda' ?>')" />
</div>

<script>

 $(function() {
    var dialog, form,
      dias_anticipacion = $("#dias_anticipacion"),
      dateAlertTime 	= $("#fecha_alerta");

    function addEditAlerta() {
      var valid = true;
      if (valid) {
      }
      return valid;
    }

    var id_alert_form;
    var date_expired = null;
    var days_anticipate, date_now;
    var campos_vencidos = []; 
    
    $(".create-alert").each(function(){
    	date_now = new Date();
    	date_anticipate = new Date();
    	id_alert_form = $(this).attr("alertcampo");
    	date_expired 	= null;
    	days_anticipate = null;
    	if(id_alert_form){
    		date_expired 	= new Date($("#"+id_alert_form+"_alert_date").val());
    		days_anticipate	= $("#"+id_alert_form+"_alert_days").val();
			date_anticipate = date_expired.setDate(date_expired.getDate() - days_anticipate);

    		date_expired 	= new Date($("#"+id_alert_form+"_alert_date").val());
			date_expired = date_expired.setDate(date_expired.getDate());
			
            if($("#"+id_alert_form+"_alert_date").val()){
    		    $("#"+id_alert_form+"_tooltip").html("La alerta ya se encuentra cofigurada");
    		}
            
			if(Date.now() > date_anticipate){
				$("#"+id_alert_form+"_tooltip").html("El campo esta por vencer");
				$("#"+id_alert_form+"_tooltip").css("background","#dede0b");
				$("#"+id_alert_form+"_tooltip").css("color","black");
				$("#"+id_alert_form+"_tooltip").addClass("campo_por_vencer");
 				$(this).addClass('i_por_vencer');
    		}
    		
    		if (Date.now() > date_expired){
    		    campos_vencidos.push(formulario_data[id_alert_form]['vNombre']);
 				$("#"+id_alert_form+"_tooltip").html("El campo ha vencido");
 				$("#"+id_alert_form+"_tooltip").addClass('campo_vencido');
 				$(this).addClass('i_vencido');
 				$(this).removeClass('i_por_vencer');
 				$("#"+id_alert_form+"_tooltip").removeClass("campo_por_vencer");
    		}
    	}
    });
    
    var mensaje_campos_vencidos = '';
    if(campos_vencidos.length == 1){
        mensaje_campos_vencidos = 'Ha vencido el campo:<br>- '
    }else if(campos_vencidos.length > 1){
        mensaje_campos_vencidos = 'Han vencido los siguientes campos:<br>- '
    }
    
    if(campos_vencidos.length > 0){
        $.Zebra_Dialog(mensaje_campos_vencidos+campos_vencidos.join().replace(",","<br>- "), {
                'type':  'warning',
                'title':    false,
                'width':    300,
                'buttons': [{caption:'Aceptar', callback: function() { 
    
                }}],
                'overlay_opacity': 0.5
            });
    
            $('.ZebraDialog_Buttons').css('width','80px');
    }

    
    console.log(campos_vencidos);
 	
    dialog = $("#dialog-form").dialog({
      autoOpen: false,
      height: 230,
      width: 365,
      modal: true,
      buttons: {
        "Guardar": 
        {
        	click: function () {
        		days_ant = $("#dias_anticipacion").val();
        		date_exp = $("#fecha_alerta").val();
        		vid_formulario = $("#id_formulario_alert").val();
        		id_alert = $("#id_alert_form").val();

        		if(date_exp){
        			date_expi = new Date(date_exp);
        			date_expi = date_expi.setDate(date_expi.getDate());
        		}else{
        		    
					new $.Zebra_Dialog("Debe indicar una fecha vencimiento",
					    {
					        auto_close: 7000,
					        buttons: false,
					        modal: false,
					        position: ["right - 20", "top + 50"]
					    }
					);

        			return false;
        		}

        		if(!days_ant){
					new $.Zebra_Dialog("Debe indicar los dias de anticipación",
					    {
					        auto_close: 7000,
					        buttons: false,
					        modal: false,
					        position: ["right - 20", "top + 50"]
					    }
					);

        			return false;
				}

				if(date_expi < Date.now()){
					new $.Zebra_Dialog("La fecha de vencimiento debe ser mayor a hoy",
					    {
					        auto_close: 8000,
					        buttons: false,
					        modal: false,
					        position: ["right - 20", "top + 50"]
					    }
					);

        			return false;
				}

				precarga('block');
				$.post("<?= base_url() . 'locales/registro/add_or_update_alert' ?>",{days_ant :days_ant, date_exp : date_exp, vid_formulario : vid_formulario, iIdLocal : iIdLocal, id_alert : id_alert},function(data){
						console.log(data);
						if(data){
						   $.Zebra_Dialog('Se Guardo Satisfactoriamente', {
                        		'type':  'confirmation',
                        		'title':    false,
                        		'width':    300,
                        		'buttons': [{caption:'Aceptar', callback: function() { 
                        		    var f_cinco = $("#select__fase_cinco").val();
                        		    var f_cuatro = $("#select__fase_cuatro").val();
                        		    var id_formulario = <?= $id_formulario ?>;
                                    var fase_tres_id = <?= $fase_tres_id ?>;
                                    var fase_cuatro_id = <?= (empty($fase_cuatro_id) ? 0: $fase_cuatro_id) ?>;
                                    var fase_cinco_id = <?= (empty($fase_cinco_id) ? 0: $fase_cinco_id) ?>;
                                    console.log('1:',fase_cinco_id, '2:', fase_cuatro_id,'3:', fase_tres_id, '4:', f_cuatro, '5:', f_cinco);
                        		        if(f_cuatro) {
                        		            if(f_cinco){
			                                    cargarEditFormularioCampos(5, f_cinco, fase_tres_id, fase_cuatro_id, fase_cinco_id);
                        		            }else{
			                                    cargarEditFormularioCampos(4, f_cuatro, fase_tres_id, fase_cuatro_id, fase_cinco_id);
                        		            }
                                		}else{
                                             cargarEditFormularioCampos(fase,fase_id);
                                		}
                                  	    dialog.dialog( "close" );
                        		}}],
                        		'overlay_opacity': 0.5
                        	});
						}else{
							dialogo_zebra("Error Al Grabar Registro",'error','Alerta de alarmas de vencimiento',300,'');
						}

						$("#AjaxLoading").css("display","none");
						precarga('none');
				});
        	},
            text: 'Guardar',
    	},
        "Cancelar": 
        {
        	click: function () {
          		dialog.dialog( "close" );
        	},
            text: 'Cancelar',
    	},
      },
      close: function() {
      }
    });


    $(".ui-dialog-buttonset").css('float', 'none');
    
    $(".ui-dialog-buttonpane").css('text-align', 'center');
    
    form = dialog.find( "form" ).submit( function( event ) {
      event.preventDefault();
      addEditAlerta();
    });
 	var fecha_alerta_expired;
 	var fdays, fmonths, fyear, fhours, fminutes;
    $( ".create-alert" ).click(function() {
    	id_alert_form = $(this).attr("alertcampo");
    	$("#id_formulario_alert").val(id_alert_form);
    	$("#id_alert_form").val($("#"+id_alert_form+"_id_id_alert").val());
    	fecha_alerta_expired = new Date($("#"+id_alert_form+"_alert_date").val());
    	console.log(fecha_alerta_expired);
    	fdays 	= fecha_alerta_expired.getDate();
    	fmonths = fecha_alerta_expired.getMonth();
    	fmonths = fmonths +1;
    	fyear 	= fecha_alerta_expired.getFullYear();
    	fhours 		= fecha_alerta_expired.getHours();
    	fminutes 	= fecha_alerta_expired.getMinutes();
    	fdays 	= fdays > 9 ? fdays : "0"+fdays;
    	fmonths = fmonths > 9 ? fmonths : "0"+fmonths;
    	fhours  = fhours > 9 ? fhours : "0"+fhours;
    	fminutes = fminutes > 9 ? fminutes : "0"+fminutes;
    	fecha_alerta_expired = fyear +'-'+fmonths+'-'+fdays+'T'+fhours+':'+fminutes;
    	console.log(fecha_alerta_expired);
    	$("#dias_anticipacion").val($("#"+id_alert_form+"_alert_days").val());
    	$("#fecha_alerta").val(fecha_alerta_expired);
    	dialog.dialog("open");
    });
    
    $("#fase_3_fase_id_2_departamento").val(auxDepartamento).change();
    
    jQuery.orderDate = function(date){
        date = date.split('/');
        date = date[2] + '/' + date[1] + '/' +  date[0];
        return date;
        
    }
    
    jQuery.orderDateLt = function(date){
        date = date.split('-');
        date = date[2] + '/' + date[1] + '/' +  date[0];
        return date;
        
    }
    
    jQuery.formatDate = function(newDate){
        const offset = newDate.getTimezoneOffset();
        newDate = new Date(newDate.getTime() + (offset*60*1000));
        newDate = newDate.toISOString().split('T')[0];
        return $.orderDateLt(newDate);
    }
    
    $("#fase_3_fase_id_14_plazo_contrato__vigencia_anos").blur(function(){
        var addYear = $('#fase_3_fase_id_14_plazo_contrato__vigencia_anos').val();
        var fechaInicio = $.orderDate($("#fase_3_fase_id_14_fecha_inicio_contrato").val());
        var fecha = new Date(fechaInicio);
        fecha.setFullYear(fecha.getFullYear() + parseInt(addYear != '' ? addYear : 0 ));
        $('#fase_3_fase_id_14__fecha_fin_contrato').val($.formatDate(fecha));
    });
    
    $('#fase_3_fase_id_14_fecha_inicio_contrato').change(function(){
        var addYear = $('#fase_3_fase_id_14_plazo_contrato__vigencia_anos').val();
        var fechaInicio = $.orderDate($(this).val());
        var fecha = new Date(fechaInicio);
        fecha.setFullYear(fecha.getFullYear() + parseInt(addYear != '' ? addYear : 0 ));
        $('#fase_3_fase_id_14__fecha_fin_contrato').val($.formatDate(fecha));
    })
  } );
  $(document).ready(function(){
 $('#frm_tabla').prepend(`<div style="display:none" id="myProgress">
  <div id="myBar">10%</div>
</div>`);   
});
</script>
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
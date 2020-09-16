<div>
	<div class="fr">
		<?php if(in_array(5,$opciones)):?>
		<a class="imprimir" href="javascript:void(0)" onclick="imprimir()">Imprimir / PDF</a>
		<?php endif;?>
	</div>
	
	<div class="clear"></div>
	
	<label class="label w100p lh_20 mb_10 mt_20 fs_14">
		Importe los documentos correspondientes al local de
		<span style="font-style:italic">"<?= $local->fase_3_fase_id_2_nombre_del_sitio?>"</span>
		<a href="javascript:void(0)" class="ml_20 color_005E7B" onclick="$('#div_agregar_documento').show()">Hacer clic aqui</a>
	</label>
	
	<div class="clear mb_20"></div>
	
	<div id="div_agregar_documento">
		<input type="button" value="Buscar Documentos" class="w170 btn fl" onclick="fun_AjaxUpload_documento(this)"/>
		
		<a href="javascript:void(0)" class="fr mr_20 color_005E7B" onclick="$('#div_agregar_documento').hide()">Cerrar x</a>
		
		<div class="clear mb_20"></div>
		
		<div id="resultado_imagenes" class="fl formulario">
			
			<fieldset class="w430 fl" id="resultado_documentos" style="min-height:80px">
				
				<legend align="left" class="bold">Documentos Nuevos a importar :</legend>
				
			</fieldset>
			
			<div class="fl ml_40 mt_15">
				
				<?php
					$attributes = array('id' => 'frm_documento','class' => 'formulario');
					echo form_open(base_url().'locales/registro/' . 'agregar_documento', $attributes);
				?>
				
				<label class="label w80 mb_2">Asignar Categor&iacute;a</label>
				<select name="iIdCategoria" id="iIdCategoria" class="bordercaja w150 fl lh_15 mb_7" validar="ok">
					<option value="0">[--Seleccionar--]</option>
					<?php foreach($categoria as $row): ?>
					<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
					<?php endforeach ?>
				</select>
				<?php if(in_array(2,$opciones)):?>
				<a href="javascript:void(0)" class="agregar fl ml_10" onclick="agregar_registro(350,'locales/registro/categoria','frm_categoria')"></a>
				<?php endif;?>
				<input type='hidden' name='iIdLocal' id="iIdLocal" value='<?php echo $iIdLocal?>' class='bordercaja'/>
				<input type='hidden' name='codigo_de_local' id="codigo_de_local" value='<?= $local->fase_3_fase_id_2_codigo_de_local ?>' class='bordercaja'/>
				
				<?php echo form_close(); ?>
				
			</div>
			
		</div>
		
		<div class="clear"></div>
		
		<div class="fr w200 mt_20">
			<?php if(in_array(2,$opciones)):?>
			<input id="button_agregar" type="submit" value="Importar" class="btn" onclick="guardar_serialize_array('frm_documento')">
			<?php endif;?>
			<input type="submit" name="" value="Cancelar" class="btn" onclick="dialogo_zebra_confirmacion('¿desea cancelar el Registro de Documentos y perder los datos ingresados?','question','Alerta de Registro de Documentos',412,'<?php echo base_url().'locales/registro/busqueda'?>')">
		</div>
		
	</div>
	
	<div class="clear mb_20"></div>
	
	<div class="titleLocalReg mt_0 fl">Lista de documentos</div>
	
	<div class="clear mb_10"></div>
	
	<?php
		$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
		echo form_open(base_url().'locales/registro/' . 'buscar_documento_all', $attributes);
		
	?>
	
	<input type="hidden" name="iIdLocal" id="iIdLocal" value="<?php echo $iIdLocal?>" />
	<input type='hidden' name='codigo_de_local' id="codigo_de_local" value='<?= $local->fase_3_fase_id_2_codigo_de_local?>' class='bordercaja'/>
	
	<label class="label w230 lh_20 mb_2 mt_10">Buscar por Tipo de documento :</label>
	<select name="iIdCategoriaBusqueda" id="iIdCategoriaBusqueda" class="bordercaja w150 fl lh_15 mb_7 mt_10" validar="ok">
		<option value="0">Todos</option>
		<?php foreach($categoria as $row): ?>
		<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
		<?php endforeach ?>
	</select>
	
	<?php echo form_close();?>
	
	<input type="submit" value="Buscar" class="btn ml_30" onclick="Buscar()">
	
	<div class="clear mb_5"></div>
	
	<div id="resultado_impresion">
		
		<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
		<div class="clear"></div>
		
		<div class="title_cabecera titleLocalReg dn">Documentos del Local <?= $local->fase_3_fase_id_2_nombre_del_sitio ?></div>
		
		<div class="clear mb_20"></div>
		
		<div id="resultado_busqueda" class="fl formulario">
			
			
		</div>
		
	</div>
	
	<div class="clear mb_80"></div>
</div>

<script type="text/javascript">
recuperar_iIdDocumento();
</script>
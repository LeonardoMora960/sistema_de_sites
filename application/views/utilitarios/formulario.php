<?php 
$opciones = explode(',',$opciones);
?>

<div class="content">
    <div class="topCont" style="height:100px!important">
    	<div class="titulo">Administraci&oacute;n de Formularios</div>
    </div>
    <div class="contenido formulario" style="min-height:400px;margin-top:152px">
		
		<?php
			$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
			echo form_open(base_url().'utilitarios/administracion_formulario/' . 'buscar_detalleformulario_all', $attributes);
			
		?>
		
		<label class="label w100p lh_20 mb_10">1. Seleccione el tipo de formulario que desea administrar.</label>
		
		<label class="label w140 lh_20 mb_2 ml_20">Formulario:</label>
		
		<select name="iIdFormulario" id="iIdFormulario" class="bordercaja w240 fl lh_15 mb_7" validar="ok" onchange="Buscar();limpieza('frm_formulario')">
			<?php foreach($formulario as $row): ?>
			<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
			<?php endforeach ?>
		</select>

		<?php echo form_close();?>
		
		<div class="clear mb_10"></div>
		<div id="resultado_select_fase_dos"></div>
		<div class="clear mb_10"></div>
		<div id="box_registers_campos" class="dn">
			<label class="label w100p lh_20 mb_10">Agregue, Edite o elimine  los campos del formulario</label>
			
			<?php
				$attributes = array('id' => 'frm_formulario','class' => 'formulario');
				echo form_open(base_url().'utilitarios/administracion_formulario/' . 'agregar_detalleformulario', $attributes);
				
			?>
			<input type="hidden" name="iIdDetalleFormulario" id="iIdDetalleFormulario"  value="" />
			
			<label class="label w140 lh_20 mb_2 ml_20">Nombre del campo  :</label>
			<input id="vNombre" name="vNombre" type="text" class="bordercaja w240 fl lh_15 mb_7" validar="ok" value=""/>
			
			
			<input type="checkbox" id="cObligatorio" name="cObligatorio" class="w10 fl mt_3 ml_20" value="1"/>
			<label class="ml_5 label w170 lh_20 mb_2">El campo es obligatorio</label>	
			
			<label class="label w60 lh_20 mb_2 ml_30">Estado:</label>
			<select name="eEstado" id="eEstado" class="bordercaja w100 fl lh_15 mb_7" validar="ok">
				<option value="1">Activo</option>
				<option value="2">Inactivo</option>
			</select>
			
			<div class="clear"></div>
			
			<label class="label w140 lh_20 mb_2 ml_20">Tipo de campo:</label>
			
			<select name="iIdTipoCampo" id="iIdTipoCampo" class="bordercaja w240 fl lh_15 mb_7" validar="ok">
				<option value="0">[--Seleccione--]</option>
				<?php foreach($tipocampo as $row): ?>
				<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
				<?php endforeach ?>
			</select>
			
			<input type="checkbox" id="cNumerico" name="cNumerico" class="w10 fl mt_3 ml_20" value="1"/>
			<label class="ml_5 label w170 lh_20 mb_2">El campo es de tipo numerico</label>	
			
			<label class="label w60 lh_20 mb_2 ml_30">Posici&oacute;n:</label>
			<input id="iOrden" name="iOrden" type="text" class="bordercaja w100 fl lh_15 mb_7" validar="ok" value=""/>

			<div class="clear"></div>

			<label class="label w140 lh_20 mb_2 ml_20"></label>
			<label class="bordercaja w240 fl lh_15 mb_7"></label>

			<input type="checkbox" id="alert_expiration" name="alert_expiration" class="w10 fl mt_3 ml_20" value="1"/>
			<label class="ml_5 label w170 lh_20 mb_2">El campo tiene alerta</label>	
			

			<?php echo form_close(); ?>
			
			<div class="clear mb_20"></div>
			
			<div class="fl w300">
				<?php if (in_array(2, $opciones)): ?>
	        	<input type="button" value="Guardar" class="btn fl" onClick="guardar_serialize('frm_formulario')" id="btn__campo_niveles">
				<?php endif; ?>
				<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="limpieza('frm_formulario')">
			</div>
			<div class="clear mb_30"></div>

			<div id="filter_formulario">
				<div class="titleLocalReg mt_0 fl">Lista de campos en el formulario de  Locales - Datos principales</div>
				<div class="fl mt_10">
					<label class="label w140 lh_20 mb_2 ml_20">Nombre del campo:</label>
					<input id="vNombreBusqueda" name="vNombreBusqueda" type="text" class="bordercaja w240 fl lh_15 mb_7" value="" />
				</div>
				<div class="fl w300 ml_60">
					<input type="button" value="Buscar" class="btn fl" onClick="Buscar()">
					<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="limpieza('frm_formulario')">
				</div>
			</div>

			<div class="clear mb_20"></div>
			<div id="resultado_busqueda">
				<table class="classtabla w100p">
					<thead>
						<th>Item</th>
						<th>Formulario</th>
						<th>Nombre del campo</th>
						<th>Tipo de campo</th>
						<th>El campo es obligatorio</th>
						<th>El campo es numerico</th>
					    <th>El campo tiene alerta</th>
						<th>Posici&oacute;n</th>
						<th>Estado</th>
						<th>Opci&oacute;n</th>
					</thead>
					<tbody></tbody>
				</table>
				
			</div>
			<div class="clear pb_20"></div>
		</div>
	</div>
</div>


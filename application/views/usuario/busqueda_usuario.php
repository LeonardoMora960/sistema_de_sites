<?php
$opciones = explode(',',$opciones);
?>
<div class="content">
    <div class="topCont" style="height:100px!important;position:fixed;top:75px">
    	<div class="titulo_usuario">B&uacute;squeda de Usuarios</div>
    </div>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:152px">
		
		<div class="clear mb_10"></div>
			
		<div class="titleLocalReg mt_0 fl">Datos de b&uacute;squeda</div>
		
		<div class="clear mb_10"></div>
		
		<?php
			$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
			echo form_open(base_url().'usuario/registro_usuario/' . 'buscar_usuario_all', $attributes);
			
		?>
		
		<div class="fl w350">
		
			<label class="label w120 lh_20 mb_2">Nombre :</label>
			<input id="nombre" name="nombre" type="text" class="bordercaja w220 fl lh_15 mb_7" value=""/>
			<div class="clear"></div>
			<label class="label w120 lh_20 mb_2">DNI:</label>
			<input id="dni" name="dni" type="text" class="bordercaja w220 fl lh_15 mb_7" value=""/>
			<label class="label w120 lh_20 mb_2">Tipo de usuario:</label>
			<select name="tipo_de_usuario" id="tipo_de_usuario" class="bordercaja w220 fl lh_15 mb_7">
				<option value="0">Todos</option>
				<?php foreach($tipo_de_usuario as $row): ?>
				<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
				<?php endforeach ?>
			</select>
			<label class="label w120 lh_20 mb_2">Area:</label>
			<select name="area" id="area" class="bordercaja w220 fl lh_15 mb_7">
				<option value="0">Todos</option>
				<?php foreach($area as $row): ?>
				<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
				<?php endforeach ?>
			</select>
		
		</div>
		
		<div class="fl w280 ml_80">
		
			<label class="label w250 lh_15 mb_7"><u>Fecha de expiraci&oacute;n :</u></label>	
			<label class="label w60 lh_20 mb_2">Desde :</label>
			<input id="fecha_de_expiracion_desde" name="fecha_de_expiracion_desde" type="text" class="calendario bordercaja w180 fl lh_15 mb_7" value=""/>
			<label class="label w60 lh_20 mb_2">Hasta :</label>
			<input id="fecha_de_expiracion_hasta" name="fecha_de_expiracion_hasta" type="text" class="calendario bordercaja w180 fl lh_15 mb_7" value=""/>
			<label class="label w60 lh_20 mb_2">Estado:</label>
			<select name="eEstado" id="eEstado" class="bordercaja w180 fl lh_15 mb_7">
				<option value="0">Todos</option>
				<option value="1">Activo</option>
				<option value="2">Inactivo</option>
			</select>
		</div>
		
		<?php echo form_close();?>
		
		<div class="clear mb_20"></div>
		
		<div class="fl w300 ml_280">
        	<input type="button" value="Buscar" class="btn fl" onClick="Buscar()">
			<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="limpieza('frm_busqueda')">
		</div>
		
		<div class="clear mb_30"></div>
		
        <div class="titleLocalReg mt_0 fl">Resultado de b&uacute;squeda</div>
		
        <div class="clear mb_10"></div>
        
		<div class="fr">
		<?php if(in_array(5,$opciones)):?>
		<a class="imprimir" href="javascript:void(0)" onclick="imprimir()">Imprimir / PDF</a>
		<?php endif;?>
		
		<div class="clear"></div>
		
		<div id="resultado_impresion">
		
		<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
		<div class="clear"></div>
		
		<div class="title_cabecera titleLocalReg dn">B&uacute;squeda de Usuarios</div>
		
		<div class="clear mb_20"></div>
			   
			<div id="resultado_busqueda" class="scrollable_new mt_20">
		   
				<table class="classtabla w100p">
					<thead>
						<th>Item</th>
						<th>Nombre y apellidos</th>
						<th>DNI</th>
						<th>Area</th>
						<th>Tipo de usuario</th>
						<th>Usuario</th>
						<th>Fecha de expiraci&oacute;n</th>
						<th>Estado</th>
						<th>Opci&oacute;n</th>
					</thead>
					<tbody>
					   
					</tbody>
				</table>
				
			</div>
		
		</div>
			  	
		<div class="clear pb_20"></div>
		 
    </div>	
			   
</div>


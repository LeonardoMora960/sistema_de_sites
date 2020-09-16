<?php
$opciones = explode(',',$opciones);
?>
<div class="content">
    <div class="topCont" style="height:100px!important;position:fixed;top:75px">
    	<div class="titulo_usuario">Log de Seguridad</div>
    </div>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:152px">
		
		<div class="clear mb_10"></div>
			
		<div class="titleLocalReg mt_0 fl">Datos de b&uacute;squeda</div>
		
		<div class="clear mb_10"></div>
		
		<?php
			$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
			echo form_open(base_url().'usuario/registro_usuario/' . 'buscar_log_all', $attributes);
			
		?>
		<input type="hidden" name="iIdUsuario" id="iIdUsuario" value="" />
		<div class="fl w600">
		
		<label class="label w130 lh_20 mb_2">Nombre y apeliidos :</label>
		<input id="nombre" name="nombre" type="text" class="bordercaja w180 fl lh_15 mb_7" validar="ok" value=""/>
		
		<label class="label w60 lh_20 mb_2 ml_40">Usuario :</label>
		<input id="usuario" name="usuario" type="text" class="bordercaja w160 fl lh_15 mb_7" validar="ok" value=""/>
		
		<div class="clear"></div>
		
		<label class="label w130 lh_20 mb_2">DNI:</label>
		<input id="dni" name="dni" type="text" class="bordercaja w180 fl lh_15 mb_7" validar="ok" value=""/>
		
		<label class="label w60 lh_20 mb_2 ml_40">Evento:</label>
		<select name="iIdEvento" id="iIdEvento" class="bordercaja w160 fl lh_15 mb_7" validar="ok">
			<option value="0">Todos</option>
			<?php foreach($evento as $row): ?>
			<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
			<?php endforeach ?>
		</select>
		
		</div>
		
		<div class="fl w210">
        	<input type="button" value="Buscar" class="btn fl" onClick="Buscar()">
			<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="limpieza('frm_busqueda')">
		</div>
		
		<?php echo form_close();?>
		
		
		<div class="clear mb_30"></div>
		
        <div class="titleLocalReg mt_0 fl">Resultado de b&uacute;squeda</div>
		
        <div class="clear mb_10"></div>
		
		<div class="fr">
		<?php if(in_array(5,$opciones)):?>
		<a class="imprimir" href="javascript:void(0)" onclick="imprimir()">Imprimir / PDF</a>
		<?php endif;?>
		</div>
		
		<div class="clear"></div>
		
		<div id="resultado_impresion">
		
		<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
		<div class="clear"></div>
		
		<div class="title_cabecera titleLocalReg dn">Log de Seguridad</div>
		
		<div class="clear mb_20"></div>
		
			<div id="resultado_busqueda">
		   
				<table class="classtabla w100p">
					<thead>
						<th>Item</th>
						<th>Nombre y apellidos</th>
						<th>DNI</th>
						<th>Tipo de usuario</th>
						<th>Usuario</th>
						<th>IP</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Evento</th>
						<th>Estado</th>
					</thead>
					<tbody>
					   
					</tbody>
				</table>
				
			</div>
	  	
		</div>
		
		<div class="clear pb_20"></div>
		 
    </div>	
			   
</div>


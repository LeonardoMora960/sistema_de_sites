<?php
$opciones = explode(',',$opciones);
?>
<div class="content">
    <div class="topCont" style="height:100px!important;position:fixed;top:75px">
    	<div class="titulo_usuario">Permisos de usuario</div>
    </div>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:152px">
		
		<div class="clear mb_10"></div>
			
		<div class="titleLocalReg mt_0 fl">Datos de b&uacute;squeda</div>
		
		<div class="clear mb_10"></div>
		
		<?php
			$attributes = array('id' => 'frm_permiso','class' => 'formulario');
			echo form_open(base_url().'usuario/registro_usuario/' . 'agregar_permiso', $attributes);
		?>
		
		<?php echo form_close();?>
		
		<?php
			$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
			echo form_open(base_url().'usuario/registro_usuario/' . 'buscar_permiso_all', $attributes);
		?>
		<input type="hidden" name="iIdUsuario" id="iIdUsuario" value="<?php echo $NiIdUsuario?>" validar="ok" />
		<div class="fl w600">
		
		<label class="label w130 lh_20 mb_2">Nombre y apellidos :</label>
		<input id="nombre" name="nombre" type="text" class="bordercaja w180 fl lh_15 mb_7" value="<?php if(isset($usuario_datos->nombre))echo $usuario_datos->nombre?>"/>
		
		<label class="label w60 lh_20 mb_2 ml_40">Usuario :</label>
		<input id="usuario" name="usuario" type="text" class="bordercaja w160 fl lh_15 mb_7" value="<?php if(isset($usuario_datos->usuario))echo $usuario_datos->usuario?>"/>
		
		<div class="clear"></div>
		
		<label class="label w130 lh_20 mb_2">DNI:</label>
		<input id="dni" name="dni" type="text" class="bordercaja w180 fl lh_15 mb_7" value="<?php if(isset($usuario_datos->dni))echo $usuario_datos->dni?>"/>
		
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
		
		<div class="title_cabecera titleLocalReg dn">Permisos de Usuario</div>
		
		<div class="clear mb_10"></div>
		       
			<div id="resultado_busqueda" class="formulario">
		   
			
			</div>
	  	
		</div>
		
		<div class="clear mb_30"></div>
		
		<div class="fr w210">
			<?php if(in_array(2,$opciones) || in_array(3,$opciones)):?>
			<input type="button" value="Guardar" class="btn fl" onClick="guardar_serialize_array('frm_permiso')">
			<?php endif;?>
			<input type="button" name="" value="Cancelar" class="btn fl ml_10" onclick="dialogo_zebra_confirmacion('¿desea cancelar el Registro de Permisos de Usuario y perder los datos ingresados?','question','Alerta de Registro de Permisos de Usuario',412,'<?php echo base_url().'usuario/registro_usuario/permiso_usuario'?>')">
		</div>
		
		
		<div class="clear pb_20"></div>
		 
    </div>	
			   
</div>

<script type="text/javascript">
<?php if($NiIdUsuario > 0):?>
Buscar();
<?php endif;?>
</script>

<style type="text/css" media="screen">
.ZebraDialog {
	´top: 0 !important;
}
</style>
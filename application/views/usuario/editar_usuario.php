<?php 
$opciones = explode(',',$opciones);
?>
<div class="content">
    <div class="topCont" style="height:100px!important">
    	<div class="titulo">Registro de Usuarios</div>
    </div>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:152px">
	
		<label class="label w100p lh_20 mb_10">Registre a los usuarios que usarán el portal de administración de Locales.</label>
    	
		<div class="clear mb_20"></div>
		
		<?php
			$attributes = array('id' => 'frm_tabla','class' => 'formulario');
			echo form_open(base_url().'usuario/registro_usuario/' . 'agregar_usuario', $attributes);
			
		?>
        	<input type="hidden" id="iIdUsuario" name="iIdUsuario" value="<?php echo $edit_iIdUsuario?>" />
			<div class="w380 fl ml_20">
            	
				<div class="titleLocalReg w350 fl mt_0">Datos Personales</div>
				
				<?php foreach($columna1 as $key=>$row):
						$campo = $row['campo'];
				?>
				
				<?php if($row['iIdTipoCampo'] == 1|| $row['iIdTipoCampo'] == 2 || $row['iIdTipoCampo'] == 6):?>
				<?php if($row['iIdTipoCampo'] == "6")
				{
					$calendario = "calendario";
				} else {
					$calendario = "";
				} 
				
				if($row['cObligatorio'] == 1){
					$ok = "validar='ok'";
				}else{
					$ok = "";
				}
				
				?>
				
				
				<label class="label w140 lh_20 mb_2"><?php echo $row['vNombre']?>:</label>
				<input id="<?= $row['campo']?>" name="<?= $row['campo']?>" type="text" 
				class="bordercaja w200 fl lh_15 mb_7 <?php $calendario; ?>" <?=$ok?> value="<?= $usuario[0][strtolower($row['campo'])]?>" >

					<?php if($row['cObligatorio'] == 1):?>
					<span class="fl ml_10 rojo">(*)</span>
					<?php endif; ?>
					
					<?php if($row['iIdTipoCampo'] == 6):?>
						<script type="text/javascript">	
							$( "#<?php echo $row->campo?>").datepicker({ 
								dateFormat: 'dd/mm/yy',
								defaultDate: "+1w",
								changeMonth: true,
								numberOfMonths: 1,
								changeYear: true
							});
						</script>
					<?php endif; ?>	
					 
								
				<?php endif; ?>
				
				<?php if($row['iIdTipoCampo'] == 3):?>
												
				<label class="label w140 lh_20 mb_2"><?php echo $row['vNombre']?>:</label>
				
				<select name="<?php echo $row['campo']?>" id="<?= $row['campo']?>" class="bordercaja w200 fl lh_15 mb_7" 
					
					<?php if($row['cObligatorio'] == 1):?>
					validar="ok" 
					<?php endif; ?>
					
					>
					<option value="0">[ --Seleccionar-- ]</option>
					<?php $tabla = $this->usuario->get_tabla($row['campo']);?>
					<?php if($tabla):?>
					<?php foreach($tabla as $row_tabla): ?>
						<option value="<?php echo $row_tabla->id ?>" <?php if($row_tabla->id == $usuario[0][strtolower($row['campo'])])echo "selected='selected'";?>><?php echo $row_tabla->vNombre ?></option>
					<?php endforeach ?>
					<?php endif; ?>
				</select>
					
					<?php if($row['cObligatorio'] == 1):?>
					<span class="fl ml_10 rojo">(*)</span>
					<?php endif; ?>
					
			   <?php endif; ?>
					
				<div class="clear"></div>
			
				<?php endforeach;?>
				
			</div>
			
			<div class="w380 fr ml_20">
            	
				<div class="titleLocalReg w350 fl mt_0">Datos de usuario</div>
				
				<?php foreach($columna2 as $key=>$row):
						$campo = $row['campo'];
				?>
				
				<?php if($row['iIdTipoCampo'] == 1|| $row['iIdTipoCampo'] == 2 || $row['iIdTipoCampo'] == 6):?>
				
				<label class="label w140 lh_20 mb_2"><?php echo $row['vNombre']?>:</label>
				<input id="<?php echo $row['campo']?>" name="<?php echo $row['campo']?>" type="text" class="bordercaja w200 fl lh_15 mb_7 <?php if($row['iIdTipoCampo'] == 6)echo "calendario"?>" 
					
					<?php if($row['cObligatorio'] == 1):?>
					validar="ok" 
					<?php endif; ?>
					
					value="<?php echo $usuario[0][strtolower($row['campo'])]?>"/>
					
					<?php if($row['cObligatorio'] == 1):?>
					<span class="fl ml_10 rojo">(*)</span>
					<?php endif; ?>
							
					<?php if($row['iIdTipoCampo'] == 6):?>
					<script type="text/javascript">	
						$( "#<?php echo $row['campo']?>").datepicker({ 
							dateFormat: 'dd/mm/yy',
							defaultDate: "+1w",
							changeMonth: true,
							numberOfMonths: 1,
							changeYear: true
						});
					</script>
					<?php endif; ?>
							
				<?php endif; ?>
				
				<?php if($row['iIdTipoCampo'] == 3):?>
												
				<label class="label w140 lh_20 mb_2"><?php echo $row['vNombre']?>:</label>
				
				<select name="<?php echo $row['campo']?>" id="<?php echo $row['campo']?>" class="bordercaja w200 fl lh_15 mb_7" 
					
					<?php if($row['cObligatorio'] == 1):?>
					validar="ok" 
					<?php endif; ?>
					
					>
					<option value="0">[ --Seleccionar-- ]</option>
					<?php $tabla = $this->usuario->get_tabla($row['campo']);?>
					<?php if($tabla):?>
					<?php foreach($tabla as $row_tabla): ?>
						<option value="<?php echo $row_tabla->id ?>" <?php if($row_tabla->id == $usuario[0][strtolower($row['campo'])])echo "selected='selected'";?>><?php echo $row_tabla->vNombre ?></option>
					<?php endforeach ?>
					<?php endif; ?>
				</select>
					
					<?php if($row['cObligatorio'] == 1):?>
					<span class="fl ml_10 rojo">(*)</span>
					<?php endif; ?>
					
			   <?php endif; ?>
					
				<div class="clear"></div>
			
				<?php endforeach;?>
				
				<label class="label w140 lh_20 mb_2">Estado:</label>
				<select name="eEstado" id="eEstado" class="bordercaja w200 fl lh_15 mb_7" validar="ok">
					<option value="1" <?php if($usuario[0]['eEstado'] == 'activo')echo "selected='selected'";?>>Activo</option>
					<option value="2" <?php if($usuario[0]['eEstado'] == 'inactivo')echo "selected='selected'";?>>Inactivo</option>
				</select>
				<span class="fl ml_10 rojo">(*)</span>
				
			</div>
			
				
            <div class="clear"></div>
            <div class="text_oblig">
                Los campos en (*) son obligatorios .
            </div>
            <div class="clear"></div>
			
		  <?php echo form_close();?>
		    
			<div class="fr w250">
				<?php if(in_array(3,$opciones)):?>
				<input type="button" value="Guardar" class="btn fl" onClick="guardar_serialize('frm_tabla')">
				<?php endif;?>
				<input type="button" name="" value="Cancelar" class="btn fl ml_10" onclick="dialogo_zebra_confirmacion('¿desea cancelar el Registro de Usuario y perder los datos editados?','question','Alerta de Registro de Usuario',412,'<?php echo base_url().'usuario/registro_usuario/busqueda_usuario'?>')">
			</div>
			
        <div class="clear mb_30"></div>
    </div>
	
    <div class="clear"></div>
	
</div>
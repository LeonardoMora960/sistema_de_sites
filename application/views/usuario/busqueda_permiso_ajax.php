<?php
$opciones_permiso = explode(',',$opciones_permiso);
?>
<?php if(in_array(2,$opciones_permiso) || in_array(3,$opciones_permiso)):?>
<a href="javascript:void(0)" onclick="agregar_registro(750,'usuario/registro_usuario/permiso_campo','frm_permiso_campo')" class="fr mb_15" style="color:#00536E">Administrar Columna Local</a>
<?php endif;?>
<table class="classtabla w100p" style="border:0px">
<thead>

	<tr>
	<td colspan="2"></td>
	<td colspan="7" style="background-color:#007EA2;color:#FFFFFF; font-weight:bold">Opciones</td>
	</tr>
	<tr style="background-color:#007EA2">
    <td style="color:#FFFFFF; font-weight:bold">M&oacute;dulo</td>
	<td style="color:#FFFFFF; font-weight:bold">Sub M&oacute;dulo</td>
	<?php foreach($opciones as $row_opciones):?>
		<td style="color:#FFFFFF; font-weight:bold"><?php echo $row_opciones->vNombre?></td>
	<?php endforeach;?>
	</tr>
</thead>
    <tbody>
		
	<?php foreach($permisos as $row_permisos):?>
		<tr class="fila" iIdSubModulo="<?php echo $row_permisos->iIdSubModulo?>">
		<td style="border-left:1px solid #CCCCCC"><?php echo $row_permisos->modulo?></td>
		<td><?php echo $row_permisos->submodulo?></td>
		
      <?php 
	  $permiso = explode(',',$row_permisos->permiso);
	  foreach($opciones as $key_opciones=>$row_opciones):
	  		$check = "disabled='disabled'";
			$iIdDetalleSubModulo = $this->usuario->validar_detalle_submodulo($row_permisos->iIdSubModulo,$row_opciones->id);
			if($iIdDetalleSubModulo || ($row_permisos->iIdSubModulo == 1 && $row_opciones->id == 4))$check = "";
	  ?>
        <td>
		<input type="checkbox" name="<?php echo $row_opciones->id?>" class="w10 mt_3 <?php if($key_opciones == 0)echo "visualizar"?>" <?php if(isset($permiso[$key_opciones]) && $permiso[$key_opciones] == 1 && $check == '')echo "checked='checked'";?> value="1" 
			<?php echo $check?>
			<?php if($key_opciones != 0):?>
				onchange="agregar_check_visualizar(this)"
			<?php endif;?>
		/>
		</td>
      <?php endforeach;?>
	  
	<?php endforeach;?>
	  
  </tbody>
</table>
<div class="clearfix"></div>
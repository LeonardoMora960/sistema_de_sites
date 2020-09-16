<?php
$opciones_permiso = explode(',',$opciones_permiso);
$opciones_registro_usuario = explode(',',$opciones_registro_usuario);
?>
<table class="classtabla w100p">
<thead>
    <th>Item</th>
	
	<?php foreach($detalleformulario as $row_detalleformulario):
			$campo = strtolower($row_detalleformulario->campo);
	?>
		<th class="<?php echo 'cabecera_'.$campo?>"><a href="javascript:void(0)" onclick="Buscar('','',this)" style="color:#FFFFFF"><?php echo $row_detalleformulario->vNombre?></a></th>
	<?php endforeach;?>
	
	<!--<th>Nombre y apellidos</th>
	<th>DNI</th>
	<th>Area</th>
	<th>Tipo de usuario</th>
	<th>Usuario</th>
	<th>Fecha de expiraci&oacute;n</th>
	<th>Estado</th>-->
	
	<?php if(in_array(1,$opciones_registro_usuario) && in_array(1,$opciones_permiso)):?>
	<th><div class="w120">Opci&oacute;n</div></th>
	<?php endif;?>
</thead>
    <tbody>
      <?php
	  
	  	
      $hasta=0;
       if(!empty($resultado)){
          $j=(($page-1)*$limit)+1;
          $hasta=($limit*$page<$total)?$limit*$page:$total;
          for($desde=($page-1)*$limit;$desde<$hasta;$desde++){
			
      ?>     
      <tr>
        <td><?php echo $j?></td>
		
		<?php foreach($detalleformulario as $row_detalleformulario):
				$campo = strtolower($row_detalleformulario->campo);
				$vNombre = $resultado[$desde]->$campo;
				if($row_detalleformulario->iIdTipoCampo == 3):
					if($resultado[$desde]->$campo > 0)$vNombre = $this->usuario->get_vNombre_tabla_by_id($campo,$resultado[$desde]->$campo);
				endif;
		?>
			<td class="<?php echo $campo?>"><?php echo $vNombre?></td>
		<?php endforeach;?>
		
		<?php if(in_array(1,$opciones_registro_usuario) && in_array(1,$opciones_permiso)):?>
		<td>
		<?php if(in_array(1,$opciones_registro_usuario)):?>
		<a href="<?php echo base_url().'usuario/registro_usuario/ver_usuario/'.$resultado[$desde]->iIdUsuario?>">Editar</a>
		<?php endif;?>
		
		<?php if(in_array(1,$opciones_registro_usuario) && in_array(1,$opciones_permiso)):?>
		&nbsp;&nbsp;|&nbsp;
		<?php endif;?>
		
		<?php if(in_array(1,$opciones_permiso)):?>
		<a href="<?php echo base_url().'usuario/registro_usuario/permiso_usuario/'.$resultado[$desde]->iIdUsuario?>">Dar permiso</a>
		<?php endif;?>
		
		</td>
		<?php endif;?>
      </tr>
      <?php
     $j++;
    }
}else{
?>
      <tr>
  <td colspan="14" style="border-left:1px solid #797979">
    <b>No hay resultado de busqueda</b>
  </td>
 </tr>
<?php
}
?>
    </tbody>
</table>
<div class="clearfix"></div>
<div class="ac pagination">
  <?php
   echo Paginador($page,$total,$limit,'Buscar','1');
?>
</div>
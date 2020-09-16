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
      <?php
	  
	  	
      $hasta=0;
       if(!empty($resultado)){
          $j=(($page-1)*$limit)+1;
          $hasta=($limit*$page<$total)?$limit*$page:$total;
          for($desde=($page-1)*$limit;$desde<$hasta;$desde++){
			
      ?>     
      <tr>
        <td><?php echo $j?></td>
        <td><?php echo $resultado[$desde]->nombre.' '.$resultado[$desde]->apellidos?></td>
        <td><?php echo $resultado[$desde]->dni?></td>
        <td><?php echo $resultado[$desde]->tipo_de_usuario?></td>
		<td><?php echo $resultado[$desde]->usuario?></td>
		<td><?php echo $resultado[$desde]->vIp?></td>
		<td><?php echo $resultado[$desde]->dFecha_Log?></td>
		<td><?php echo $resultado[$desde]->hora_log?></td>
		<td><?php echo $resultado[$desde]->evento?></td>
		<td><?php echo $resultado[$desde]->estado?></td>
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
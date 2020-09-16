<?php 
$opciones = explode(',',$opciones);
?>
<table class="classtabla w100p">
<thead>
    <th>Item</th>
	<th>Categoria</th>
	<th>Estado</th>
	<th>Opci&oacute;n</th>
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
        <td><?php echo $j;?></td>
        <td class="vNombre"><?php echo $resultado[$desde]->vNombre?></td>
        <td class="eEstado"><?php echo $resultado[$desde]->eEstado?></td>
        <td>
		<?php if(in_array(3,$opciones)):?>
		<a class="verdetalle" href="javascript:void(0)" onclick="get_registro(this,<?php echo $resultado[$desde]->id?>)">Editar</a>
		<?php endif;?>
		<?php if(in_array(3,$opciones) && in_array(4,$opciones)):?>
			&nbsp;&nbsp;|&nbsp;
		<?php endif;?>
		<?php if(in_array(4,$opciones)):?>
		<a class="verdetalle" href="javascript:void(0)" onclick="eliminar_categoria(<?php echo $resultado[$desde]->id?>)">Eliminar</a>
		<?php endif;?>
		</td>
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
<?php
$opciones = explode(',',$opciones);
if(!empty($resultado)) {
?>
<script>console.log("<?= $tabla ?>");</script>
<table class="classtabla w100p">
  <thead>
    <th>Item</th>
    <th>C&oacute;digo</th>
    <th>Nombre o descripci&oacute;n</th>
    <th>Estado</th>
    <th>Opci&oacute;n</th>
  </thead>
  <tbody>
    <?php
    $hasta=0;
    $j=(($page-1)*$limit)+1;
    $hasta=($limit*$page<$total)?$limit*$page:$total;
    for($desde=($page-1)*$limit;$desde<$hasta;$desde++){
    ?>
    <tr>
      <td><?php echo $j;?></td>
      <td class="vCodigo"><?php echo $resultado[$desde]->vCodigo?></td>
      <td class="vNombre"><?php echo $resultado[$desde]->vNombre?></td>
      <td class="eEstado"><?php echo $resultado[$desde]->eEstado?></td>
      <td>
        <?php if(in_array(3,$opciones)):?>
        <a class="verdetalle" href="javascript:void(0)" onclick="get_registro(this, <?= $resultado[$desde]->id ?>, '<?= $tabla ?>')">Editar</a>
        <?php endif;?>
        <?php if(in_array(3,$opciones) && in_array(4,$opciones)):?>
        &nbsp;&nbsp;|&nbsp;
        <?php endif;?>
        <?php if(in_array(4,$opciones)):?>
        <a class="verdetalle" href="javascript:void(0)" onclick="eliminar_registro(<?= $resultado[$desde]->id ?>, '<?= $tabla ?>')">Eliminar</a>
        <?php endif;?>
      </td>
    </tr>
    <?php
    $j++;
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
<?php
} else {
?>
<tr>
  <td colspan="14" style="border-left:1px solid #797979">
    <b>No hay resultado de busqueda</b>
  </td>
</tr>
<?php
}
?>
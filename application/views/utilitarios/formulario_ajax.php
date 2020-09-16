<?php
$opciones = explode(',',$opciones);
?>
<script>console.log(<?=json_encode($resultado)?>)</script>
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
    <?php if(in_array(3,$opciones)):?>
    <th>Opci&oacute;n</th>
    <?php endif;?>
  </thead>
  <tbody>
    <?php
      
      $ids_sin_editar = array("3","4","5");
        
    $hasta=0;
    if(!empty($resultado)){
    $j=(($page-1)*$limit)+1;
    $hasta=($limit*$page<$total)?$limit*$page:$total;
    for($desde=($page-1)*$limit;$desde<$hasta;$desde++){
          
            $cObligatorio   = "No";
              $cNumerico    = "---";
          if($resultado[$desde]->cObligatorio == 1)$cObligatorio = "Si";
          if($resultado[$desde]->cNumerico == 1)$cNumerico = "Si";
    ?>
    <tr iIdFormulario="<?php echo $resultado[$desde]->iIdFormulario?>" iIdTipoCampo="<?php echo $resultado[$desde]->iIdTipoCampo?>" iOrden="<?php echo $resultado[$desde]->iOrden?>" cObligatorio="<?php echo $resultado[$desde]->cObligatorio?>" cNumerico="<?php echo $resultado[$desde]->cNumerico?>" alert_expiration="<?php echo $resultado[$desde]->alert_expiration?>">
      <td><?php echo $j;?></td>
      <td><?php echo $resultado[$desde]->formulario?></td>
      <td class="vNombre"><?php echo $resultado[$desde]->vNombre?></td>
      <td><?php echo $resultado[$desde]->tipocampo?></td>
      <td><?php echo $cObligatorio?></td>
      <td><?php echo $cNumerico?></td>
      <td><?php echo $resultado[$desde]->alert_expiration?></td>
      <td><?php echo $resultado[$desde]->iOrden?></td>
      <td class="eEstado"><?php echo $resultado[$desde]->eEstado?></td>
      <?php if(in_array(3,$opciones)):?>
      <td><a class="verdetalle" href="javascript:void(0)"
        <?php if(!in_array($resultado[$desde]->iIdDetalleFormulario,$ids_sin_editar)):?>
        onclick="get_registro(this,<?php echo $resultado[$desde]->iIdDetalleFormulario?>)"
        <?php else:?>
        onclick="dialogo_zebra('Este campo no se puede editar','warning','',300,'')"
        <?php endif;?>
      >Editar</a>
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
echo Paginador($page, $total, $limit, 'Buscar', '1', $fase, $fase_id);
?>
</div>
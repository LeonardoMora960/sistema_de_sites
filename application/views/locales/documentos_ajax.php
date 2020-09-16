<?php  	
$opciones = explode(',',$opciones);
$hasta=0;
	if(!empty($resultado)){
		$j=(($page-1)*$limit)+1;
		$hasta=($limit*$page<$total)?$limit*$page:$total;
		for($desde=($page-1)*$limit;$desde<$hasta;$desde++):
?>	
		<fieldset class="w818 fl mt_15" style="border-bottom:0px;border-left:0px;border-right:0px;padding-left:0px">
			<legend align="left" class="bold"><?php echo $resultado[$desde]->categoria?><span class="ml_20 pointer" onclick="open_detalle(this)" abierto='1'>V</span></legend>
		</fieldset>	 
		<div>
	<?php 
	  	$vDocumento = explode(',',$resultado[$desde]->vDocumento);
		$iIdDetalleDocumento = explode(',',$resultado[$desde]->iIdDetalleDocumento);
			foreach($vDocumento as $key=>$row):
			$ext = '';
			$icono_img = '';
			$ext = explode('.',$row);
			if($ext[1] == 'doc' || $ext[1] == 'docx') $icono_img = 'u149_normal.png';
			elseif($ext[1] == 'xls' || $ext[1] == 'xlsx') $icono_img = 'u493_normal.png';
			elseif($ext[1] == 'pdf') $icono_img = 'u46_normal.png';
			else $icono_img = 'u56_normal.png';
	?>
		<div class="fl ml_20 w550 mb_10">
			<img class='fl' src='<?php echo base_url().'public/images/'.$icono_img?>' width='16' height='16' />
			<input type='text' name='vDocumento' value='<?php echo $row?>' class='bordercaja al w250 lh_20 mb_2 ml_10' validar='ok' style='background-color:transparent;border:0px'/>
			<div class='fr'>
				<a class="fl col_999999" target="_blank" href="<?php echo base_url().'public/images/documento/'.$row?>">Ver</a>
				<?php if(in_array(3,$opciones)):?>
				<a class="fl ml_20 col_999999" href="javascript:void(0)" onclick="fun_AjaxUpload_documento_proceso(this, <?php echo $iIdDetalleDocumento[$key] ?>)">Actualizar</a>
				<?php endif;?>
				<a class="fl ml_20 col_999999" href="<?php echo base_url().'public/images/documento/'.$row?>">Descargar</a>
				<?php if(in_array(4,$opciones)):?>
				<a class="fl ml_20 col_999999" href="javascript:void(0)" onclick="eliminar_registro(<?php echo $iIdDetalleDocumento[$key]?>)">Eliminar</a>
				<?php endif;?>
			</div>
		</div>
      <?php
	  		endforeach;
			
		?>
		</div>	
		<?php
     		$j++;
    	endfor;
		
	}else{
?>
    <b>No hay resultado de busqueda</b>
<?php
}
?>

<div class="clearfix"></div>
<div class="ac pagination">
  <?php
   echo Paginador($page,$total,$limit,'Buscar','1');
?>
</div>
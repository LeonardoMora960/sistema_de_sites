<?php
//print_r($datos);
$opciones_registro_local = explode(',',$opciones_registro_local);
$opciones_documento = explode(',',$opciones_documento);
//$cabecera_principal = array('1','2','3','4','5','7');
$cabecera_principal = array('fase_3_fase_id_2_codigo_de_sitio',
                            'fase_3_fase_id_2_nombre_del_sitio', 
                            'fase_3_fase_id_2_departamento', 
                            'fase_3_fase_id_2_provincia', 
                            'fase_3_fase_id_2_distrito',
                            'fase_3_fase_id_2_latitud', 
                            'fase_3_fase_id_2_longitud', 
                            'fase_3_fase_id_2_tipo_de_sitio', 
                            'fase_3_fase_id_2_tipo_propiedad', 
                            'fase_3_fase_id_2_direccion_sitio', 
                            'fase_3_fase_id_2_estado'
                            );
?> 
<script>console.log(<?=json_encode($detalleformulario)?>)</script>
<div class="fl mb_3"><a href="javascript:void(0)" style="color:#00536E;"><?php echo "Resultados de busqueda : ".$total.' registro'?></a></div>
<div class="clear"></div>
<div class="fl">

<table class="classtabla" id="tabla1" style="width: 100%;margin-bottom:20px">
    <thead>
		<tr class="cabecera" style="height:40px">
		<td style="height:26px;width:10px">Selc.</td>
		<?php foreach($cabecera_principal as $cabecera):
		        $row_detalleformulario = $detalleformulario[$cabecera];
				$campo = strtolower($row_detalleformulario->campo);

				if(in_array($campo, $cabecera_principal)):
				$width = "style='width:60px'";
				if($row_detalleformulario->iIdDetalleFormulario == 315)$width = "style='width:60px'";
				if($row_detalleformulario->iIdDetalleFormulario == 316)$width = "style='width:120px'";
				if($row_detalleformulario->iIdDetalleFormulario == 318)$width = "style='width:75px'";
				if($row_detalleformulario->iIdDetalleFormulario == 319)$width = "style='width:75px'";
		?>
			<td class="<?php echo 'cabecera_'.$campo?>" <?php echo $width?>><a href="javascript:void(0)" onclick="Buscar('','',this)" style="color:#FFFFFF"><?php echo $row_detalleformulario->vNombre?></a></td>
		<?php endif;?>
		<?php endforeach;?>
		<?php if(in_array(1,$opciones_documento)):?>
	        <td style='width:45px'>Ingresar</td>
	    <?php endif;?>
		</tr>
		<tr>
			<td></td>
		    <?php foreach($cabecera_principal as $cabecera):
		        $row_detalleformulario = $detalleformulario[$cabecera];
					$campo = strtolower($row_detalleformulario->campo);
					if(in_array($campo, $cabecera_principal)):

			?>

			<td>
				<?php if($row_detalleformulario->iIdTipoCampo == 1|| $row_detalleformulario->iIdTipoCampo == 2 || $row_detalleformulario->iIdTipoCampo == 6):?>
					<input type="text" name="<?php echo $campo?>" class="w100p fs_8" onKeyPress="if (event.keyCode == 13) {Buscar();}" value="<?php if(isset($datos[$campo]))echo $datos[$campo]?>"/>
				<?php endif; ?>
				<?php if($row_detalleformulario->iIdTipoCampo == 3):?>
					<select name="<?php echo $campo?>" id="<?php echo $campo?>" class="w100p" 
						<?php if($campo == 'fase_3_fase_id_2_departamento'):?>
							onChange="recuperar_select_controller_id_ubigeo(this.value,'<?php echo base_url().'locales/registro/recuperar_provincia_departamento'?>','fase_3_fase_id_2_provincia');Buscar();"
						<?php endif;?>
						
						<?php if($campo == 'fase_3_fase_id_2_provincia'):?>
							onChange="recuperar_select_controller_id_ubigeo(this.value,'<?php echo base_url().'locales/registro/recuperar_distrito_provincia'?>','fase_3_fase_id_2_distrito');Buscar();"
						<?php endif;?>
				        
				        <?php if($campo != 'fase_3_fase_id_2_provincia' && $campo != 'fase_3_fase_id_2_departamento'):?>
							onChange="Buscar();"
						<?php endif;?>
						>
						
						<option value="0"> --- </option>
						<?php if($campo != 'fase_3_fase_id_2_provincia' && $campo != 'fase_3_fase_id_2_distrito'): ?>
						<?php $tabla = $this->registro->get_tabla($campo);?>
						<?php foreach($tabla as $row_tabla): ?>
							<option value="<?php echo $row_tabla->id ?>"
							<?php if(isset($datos[$campo]) && $row_tabla->id == $datos[$campo]) echo "selected='selected'";?>
							
							<?php if($campo == 'fase_3_fase_id_2_departamento'):?>
								vCodigo="<?php echo $row_tabla->vCodigo ?>"
							<?php endif;?>
							
							><?php echo $row_tabla->vNombre ?></option>
						<?php endforeach; ?>
						<?php endif; ?>
						
					</select>
			   <?php endif; ?>
			   
			   <script type="text/javascript">
					<?php if($campo == 'fase_3_fase_id_2_provincia' && !empty($datos['fase_3_fase_id_2_departamento']) && $datos['fase_3_fase_id_2_departamento'] > 0):
						$valor_provincia = 0;
						if($datos[$campo] > 0)$valor_provincia = $datos[$campo];
					?>
					recuperar_select_controller_id_ubigeo(<?php echo $datos['fase_3_fase_id_2_departamento']?>,'<?php echo base_url().'locales/registro/recuperar_provincia_departamento'?>','fase_3_fase_id_2_provincia',<?php echo $valor_provincia?>);
					<?php endif;?>
					<?php if($campo == 'fase_3_fase_id_2_distrito' && $datos['fase_3_fase_id_2_provincia'] > 0):
						$valor_distrito = 0;
						if($datos[$campo] > 0)$valor_distrito = $datos[$campo];
					?>
					recuperar_select_controller_id_ubigeo(<?php echo $datos['fase_3_fase_id_2_provincia']?>,'<?php echo base_url().'locales/registro/recuperar_distrito_provincia'?>','fase_3_fase_id_2_distrito',<?php echo $valor_distrito?>);
					<?php endif;?>
					
					$('#tabla1 .fila').each(function(){
						var id_fila = $(this).attr('id');
						if($(this).height() > $("#tabla2 #"+id_fila).height()){
							$("#tabla2 #"+id_fila).height($(this).height())
						}else{
							$(this).height($("#tabla2 #"+id_fila).height())
						}
					});
					
					$('.comparar').each(function(){
						var iIdLocal = $(this).attr('id').replace('comparar_','');
						$('#cComparar_'+iIdLocal).attr('checked',true);
					});
				</script>

			</td>
			<?php endif;?>
			<?php endforeach;?>
			<td></td>
		</tr>
	</thead>
    <tbody>
<?php
      $hasta=0;
       if(!empty($resultado)){
          $j=(($page-1)*$limit)+1;
          $hasta=($limit*$page<$total)?$limit*$page:$total;
          for($desde=($page-1)*$limit;$desde<$hasta;$desde++){
			
      ?>
		<tr id="fila_<?php echo $resultado[$desde]->iIdLocal?>"
	  <?php if(in_array(1,$opciones_registro_local)):?>
	  ondblclick="window.open('<?php echo base_url().'locales/registro/ver_local/'.$resultado[$desde]->iIdLocal?>','_blank')"
	  <?php endif;?>
	  class="fila" >
        <td align="center">
		<input type="checkbox" id="cComparar_<?php echo $resultado[$desde]->iIdLocal?>" name="cComparar" class="w12" value="1" onchange="validar_comparar(this)"/>
		</td>
		<?php 
		    foreach($cabecera_principal as $cabecera):
		        $row_detalleformulario = $detalleformulario[$cabecera];
				$campo = strtolower($row_detalleformulario->campo);

				/******************/
				if(in_array($campo, $cabecera_principal)):
				$vNombre = $resultado[$desde]->$campo;
				if($row_detalleformulario->iIdTipoCampo == 3):
					if($resultado[$desde]->$campo > 0)$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$resultado[$desde]->$campo);
				endif;
		?>
			<td class="<?php echo $campo?>"><?php echo $vNombre?></td>
		<?php endif;?>
		<?php endforeach;?>
		<?php if(in_array(1,$opciones_documento)):?>
		    <td> 
		        <a href="<?php echo base_url().'locales/registro/ver_local/'.$resultado[$desde]->iIdLocal?>">Ver</a>
		</td>
		<?php endif;?>
      </tr>
      <?php }}?>
	</tbody>
</table>

</div>

<div class="ac pagination">
  <?php
   echo Paginador($page,$total,$limit,'Buscar','1');
?>
</div>
<div class="ac">
<a href="javascript:void(0)" style="color:#00536E;"><?php echo ((($page-1)*$limit) + 1).' de '.$hasta?></a>
</div>

<script type="text/javascript">
$('#tabla1 .fila').each(function(){
	var id_fila = $(this).attr('id');
	if($(this).height() > $("#tabla2 #"+id_fila).height()){
		$("#tabla2 #"+id_fila).height($(this).height())
	}else{
		$(this).height($("#tabla2 #"+id_fila).height())
	}
});
			
</script>
<?php 
$opciones_comparar = explode(',',$opciones_comparar);
?>
<a href="javascript:void(0)" onclick="Buscar()" class="fr" style="color:#00536E"><< Ver resultado anterior</a>
<div class="clear mb_10"></div>		
<div class="titleLocalReg mt_0 fl w100p">Comparaci&oacute;n de locales</div>
<div class="fr" id="div_opciones_busqueda">
	<?php if(in_array(5,$opciones_comparar)):?>
	<a class="imprimir" href="javascript:void(0)" onclick="imprimir_comparar()">Imprimir / PDF</a>
	<?php endif;?>
</div>
<div class="clear mb_0"></div>

<div id="resultado_impresion_comparar">
		
<img width="200" id="logo_impresion_busqueda_comparar" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
<div class="clear"></div>

<div class="title_cabecera_comparar titleLocalReg dn">Comparaci&oacute;n de locales</div>

<div class="clear mb_10"></div>
		
<table class="classtabla w100p" border="0" style="border:0px">
<thead>
    <th width="40%" style="background:none;border:0px;color:#000000"></th>
	<?php foreach($detalle_local as $row_local):?>
	<th class="fs_14" width="30%" style="background:none;border:0px;color:#000000;text-align:left">
		<img class='fl' src='<?php echo base_url()?>public/images/u56_normal.png'/>
		<label class='fl w90 lh_20 mb_2 ml_7'><?php echo $row_local['local'];?></label>
	</th>
	<?php endforeach;?>
</thead>
    <tbody>
	
	<?php foreach($campos as $row_campos):?>
		<tr>
		<td class="fs_13" align="left" style="border:0px;border-bottom:1px dashed #CCCCCC;color:#00536E;padding-bottom:5px;margin-bottom:10px;text-align:left"><?php echo $row_campos->vNombre;?></td>
		<?php foreach($detalle_local as $row_local):
				$campo = strtolower($row_campos->campo);
				
				if($row_campos->locales_formulario_fase):
					$fase = 'fase_'.$row_campos->locales_formulario_fase;
				else:
					$fase = '';
				endif;

				if($row_campos->locales_formulario_fase_id):
					$faseid = '_fase_id_'.$row_campos->locales_formulario_fase_id.'_';
				else:
					$faseid = '';
				endif;
				$campo = $fase . $faseid . $campo;
				$vNombre = $this->registro->get_campo_by_id($campo,$row_local['iIdLocal']);
				if($row_campos->iIdTipoCampo == 3):
					if($row_campos->campo > 0):
						$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$row_campos->campo);
					else: $vNombre = '';

					endif;
				endif;
		?>
		<td class="fs_13" style="border:0px;border-bottom:1px dashed #CCCCCC;text-align:left"><?php echo $vNombre;?></td>
		<?php endforeach;?>
		
		</tr>
	<?php endforeach;?>
    </tbody>
</table>

<div class="clear mb_40"></div>

</div>

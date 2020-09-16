<div class="content">
    <?php 
	$pagina["tab"]="imagenes";
	//$pagina["page"]="registro";
	$this->load->view('template/tabs',$pagina);
	$opciones = explode(',',$opciones);
	?>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:192px">
		
		<div class="fr">
		<?php if(in_array(5,$opciones)):?>
		<a class="imprimir" href="javascript:void(0)" onclick="imprimir()">Imprimir / PDF</a>
		<?php endif;?>
		</div>
		
		<div class="clear"></div>
					
		<label class="label w800 lh_20 mb_10 mt_20 fs_14">
			Importe las imagenes correspondientes al local de 
			<span style="font-style:italic">"<?php echo $local->fase_3_fase_id_2_nombre_del_sitio?>"</span>
		</label>
		
            <input type="hidden" name="parent_id" value="">
            <input type="hidden" name="modulo" value="Locales - Datos Principales">
            
            <div class="clear mb_20"></div>

			<input type="button" value="Buscar Imagen" class="w140 btn fl" onclick="fun_AjaxUpload_galeria(this)"/>
			
			<div id="resultado_impresion">
		
			<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
			<div class="clear"></div>
			
			<div class="title_cabecera titleLocalReg">Imagenes del Local <?php echo $local->fase_3_fase_id_2_nombre_del_sitio?></div>
			
			<div class="clear mb_20"></div>
			
			<?php
				$attributes = array('id' => 'frm_detalleimagen','class' => 'formulario');
				echo form_open(base_url().'locales/registro/' . 'agregar_detalleimagen', $attributes);
				
			?>
				<input type='hidden' name='iIdLocal' id="iIdLocal" value='<?php echo $iIdLocal?>' class='bordercaja'/>
			<?php echo form_close(); ?>
										
			<div id="resultado_imagenes" class="fl w830">
				
			<?php 
			
				$newRow = "";
	
				foreach($detalleimagen as $row):
				
				$newRow .= "<div class='galeria h_64 bkg_C9C9C9 w100p relativo'>";
				$newRow .= "<img class='fl' src='".base_url()."public/images/galeria/".$row->vimagen."' width='321' height='203' />";
				$newRow .= "<input type='hidden' name='vimagen' value='".$row->vimagen."' class='bordercaja' validar='ok' />";
				if(in_array(3,$opciones)):
				$newRow .= "<a class='edit_img pointer' onclick='fun_AjaxUpload_galeria_update(this)'></a>";
				endif;
				if(in_array(4,$opciones)):
				$newRow .= "<a class='delete_img pointer' onclick='remove_img(this)'></a>";
				endif;
				$newRow .= "<div class='fl ml_70'>";
				$newRow .= "<label class='w100 fl'>Comentario :</label>";
				$newRow .= "<textarea rows='3' name='vDescripcion' class='w310 h_100 fl fs_12'>".$row->vDescripcion."</textarea>";
				$newRow .= "</div>";
				$newRow .= "<div class='clear mb_10'></div>";
				$newRow .= "</div>";
				
				endforeach;
				
				echo $newRow;
			
			?>
				
			</div>

		</div>
			
		<div class="clear"></div>
		<input type="submit" name="" value="Cancelar" class="btn right" onclick="dialogo_zebra_confirmacion('¿desea cancelar el Registro de Im&acute;genes y perder los datos ingresados?','question','Alerta de Registro de Im&acute;genes',412,'<?php echo base_url().'locales/registro/busqueda'?>')">
		<?php if(in_array(2,$opciones)):?>
		<input type="submit" value="Guardar" class="btn right" onclick="guardar_serialize_array_imagen('frm_detalleimagen')">
		<?php endif;?>	
        <div class="clear"></div>
		
    </div>
	
    <div class="clear"></div>
</div>

<script type="text/javascript">
var opciones = <?php echo json_encode($opciones)?>;
</script>
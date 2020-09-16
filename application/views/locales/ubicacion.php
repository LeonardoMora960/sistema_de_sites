
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyD6z-h7nfacrYpsuHU1aFmHQuaRIeNwQA0&sensor=false"></script> 

<style> 
#map { 
	margin-top:10px;
    width:810px; 
    height:490px; 
	border:1px solid #C4C4C4;
} 

@-moz-document url-prefix() {
    #map{
        height:500px; 
    }
}

</style>

<div class="content">
    <?php 
	$pagina["tab"]="ubicacion";
	//$pagina["page"]="registro";
	$this->load->view('template/tabs_normal', $pagina);
	?>
	<script>console.log(<?=json_encode($ubicacion)?>)</script>
    <div class="contenido formulario" style="min-height:400px;">
		<?php
		if (!empty($ubicacion->fase_3_fase_id_2_latitud)) {
		?>
		<div class="clear"></div>
		
		<!--<label class="label w100p lh_20 mb_10 mt_20 fs_14">
			Ingrese las coordenas o el link de google para asignar la ubicaci&oacute;n del Local
			<span style="font-style:italic">"<?php //echo $local->fase_3_fase_id_2_nombre_del_sitio?>"</span>
		</label>
		<div class="clear mb_20"></div>-->
		
		<!--<input type='hidden' name='iIdLocal' id="iIdLocal" value='<?php //echo $iIdLocal?>' class='bordercaja'/>
		
		<div class="w350 fl ml_20" style="border-right:1px solid #D2D2D2">
        	    	
			<div class="w350 fl mb_20">Coordenadas del Local</div>
		
			<label class="label w90 lh_20 mb_2 ml_50">Latitud:</label>
			-->
			<input id="latitud" name="latitud" type="hidden" class="bordercaja w170 fl lh_15 mb_7" validar="ok" value="<?php echo $ubicacion->fase_3_fase_id_2_latitud ?>"/>
			<!--			
			<label class="label w90 lh_20 mb_2 ml_50">Longitud:</label>
			-->
			<input id="longitud" name="longitud" type="hidden" class="bordercaja w170 fl lh_15 mb_7" validar="ok" value="<?php echo $ubicacion->fase_3_fase_id_2_longitud ?>"/>
		<!--
		</div>
			
		<div class="w380 fl ml_40">
			
			<div class="w350 fl mb_20">Link de ubicaci&oacute;n</div>
			
			<input id="vLinkUbicacion" type="text" class="bordercaja w340 fl lh_15 mb_7" value=""/>
		
		</div>-->
		
		
		<div class="clear mb_20"></div>
		
		<!--<div class="fl w300 ml_280">
        	<input type="button" value="Buscar" class="btn fl" onClick="initialize()">
			<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="">
		</div>-->
		
		<div class="clear mb_30"></div>
		
		<div id="resultado_impresion">
		
			<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
			<div class="clear"></div>
		
        	<div class="w810 titleLocalReg mt_0 fl">Ubicaci&oacute;n en google maps  <span class="fs_11 normal">(Vista previa)</span></div>
		
        	<div class="clear mb_10"></div>

			<div class="clear"></div>

	   		<div id="map"></div>
	  	
		</div>
		
		<div class="clear mb_20"></div>
		
		<!--<div class="fr w260">
        	<input type="button" value="Guardar Ubicaci&oacute;n" class="w150 btn fl" onClick="guardar_serialize('frm_local')">
			<input type="button" name="" value="Cancelar" class="btn fl ml_10" onclick="dialogo_zebra_confirmacion('&iquest; desea cancelar el Registro de Ubicaci&oacute;n y perder los datos ingresados?','question','Alerta de Registro de Ubicaci&oacute;n',412,'<?php //echo base_url().'locales/registro/busqueda'?>')">
		</div>-->		
		<?php
		} else {
		?>
		<p>Longitud y latitud no definidas</p>
		<?php
		}
		?>
		<div class="clear pb_20"></div>
		
    </div>
</div>


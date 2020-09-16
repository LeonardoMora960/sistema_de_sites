<style type="text/css">
.scrollable_new{height:300px!important;width:auto;overflow-y:scroll;overflow:-moz-scrollbars-vertical;left:0px}
</style>

<?php 
$opciones = explode(',',$opciones);
?>
<div class="content">
    <div class="topCont" style="height:100px!important">
    	<div class="titulo">Importaci&oacute;n masiva de documentos</div>
    </div>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:152px" class="formulario">
		
		<label class="label w100p lh_20 mb_20">Busque los documentos , seleccione el tipo de documento y luego Importe :</label>
		
		<?php if(in_array(6,$opciones)):?>
		<div class="btn w150 fl">		
			<div class="dfileupload mt_10 ml_15">
				<span>Buscar Documentos</span>
				<input type="file"  multiple="multiple" id="archivos" name="archivos" class="upload"/>
			</div>
		</div>
		<input type="button" value="Subir Documentos" class="w150 btn fl ml_20" onclick="SubirFotos()"/>
		<?php endif;?>
		<div class="clear mb_20"></div>
		<input type="hidden" name="mensage" id="mensage" value=""/>
		<div class="clear mb_20"></div>
		
		<fieldset class="w800 fl pt_10 scrollable_new" id="resultado_documentos" style="min-height:250px">
                
			<legend align="left">&nbsp;&nbsp;&nbsp;Documentos Nuevos a importar :&nbsp;&nbsp;</legend>
				
		</fieldset>
		
		<?php
			$attributes = array('id' => 'frm_importacion_masiva','class' => 'formulario');
			echo form_open(base_url().'utilitarios/administracion_formulario/' . 'agregar_masivo', $attributes);
			
		?>
		
		<div class="clear mb_20"></div>
		
		<label class="label w140 lh_20 mb_2 ml_20">Asignar a :</label>
		
		<select name="iIdCategoria" id="iIdCategoria" class="bordercaja w150 fl lh_15 mb_7" validar="ok">
			<?php foreach($categoria as $row): ?>
			<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
			<?php endforeach ?>
		</select>

		<?php echo form_close();?>
		
		<div class="clear mb_20"></div>
		
		<div class="fl w300">
			<?php if(in_array(6,$opciones)):?>
        	<input type="button" id="button_agregar" value="Importar" class="btn fl" onClick="guardar_serialize_array('frm_importacion_masiva')">
			<?php endif;?>
			<input type="button" name="" value="Cancelar" class="btn fl ml_10" onclick="dialogo_zebra_confirmacion('&iquest; desea cancelar la Importaci&oacute;n Masiva de Documentos y perder los datos ingresados?','question','Alerta de Importaci&oacute;n Masiva de Documentos',412,'<?php echo base_url().'utilitarios/administracion_formulario/importacion_masiva'?>')">
		</div>
	  	
		<div class="clear pb_30"></div>
		 
    </div>	
		
			   



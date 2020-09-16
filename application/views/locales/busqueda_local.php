<style type="text/css">
.scrollable_new{width:280px!important;height:auto;overflow-x:scroll;overflow:-moz-scrollbars-horizontal;left:0px}
.classtabla tbody tr td{height:15px!important;}
section{
	min-height: 400px;
}
footer{
	width:1150px;
}
.topCont{
position:static
}
/*
.pagination{
	width:400px
}
*/
</style>
<?php
$opciones = explode(',',$opciones);
$opciones_comparar = explode(',',$opciones_comparar);
?>
<div class="content" style="width:1150px;">
	<div class="fr w140 mr_20 relativo dn">
		
		<div class="w100 pl_10 pr_10 pt_10 pb_10 borde_plomo absoluto" style="top:-125px;right:160px;background:#FFFFFF!important">
			<div class="titleLocalReg mt_0 fl w120 fs_11" style="border:0px;margin-bottom:0px">Comparaci&oacute;n de locales</div>
			
			<div style="min-height:70px" id="resultado_comparar">
				
			</div>
			
		</div>
	</div>
	
	<?php
		$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
			echo form_open(base_url().'locales/registro/' . 'buscar_local_all', $attributes);
	?>
	
	<div class="topCont" style="height:100px!important;width:1150px">
		<div class="titulo_busqueda w250 fl fs_20">B&uacute;squeda de Sitios</div>
		
		<div class="fr w580">
			<div class="fr w500 mt_10">
				<?php /*
				<input type="checkbox" id="cDocumento" name="cDocumento" class="w12 fl mt_3" value="1"/>
				<label class="label w160 lh_20 mb_2 ml_5">Locales con documentos</label>
				<select name="iIdCategoria" id="iIdCategoria" class="bordercaja w180 fl lh_12" validar="ok">
					<option value="0">[--Seleccionar--]</option>
					<?php foreach($categoria as $row): ?>
					<option value="<?php echo $row->id ?>"><?php echo $row->vNombre ?></option>
					<?php endforeach ?>
				</select>
				<div class="clear"></div>
				<input type="checkbox" id="cUbicacion" name="cUbicacion" class="w12 fl mt_3" value="1"/>
				<label class="ml_5 label w160 lh_20 mb_2">Locales con ubicaci&oacute;n</label>
				<div class="clear"></div>
				<input type="checkbox" id="cImagen" name="cImagen" class="w12 fl mt_3" value="1"/>
				<label class="ml_5 label w160 lh_20 mb_2">Locales con Imagenes</label>
				*/?>
				<br>
				<br>
				<br>
				<div class="fr w280 mr_20">
					<?php /*
					<input type="button" value="Buscar" class="btn fl fs_11 w80" onClick="Buscar()" style="height:20px;">
					<input type="button" name="" value="Limpiar" class="btn fl ml_10 fs_11 w70" onclick="limpieza('frm_busqueda')" style="height:20px;">
					*/ ?>
					<?php if(in_array(1,$opciones_comparar)):?>
					<input type="button" value="Comparar Locales" class="btn fr ml_10 w110 fs_11" onClick="Comparar()" style="height:20px;">
					<?php endif;?>
				</div>
				
			</div>
			
			<div class="clear mb_5"></div>
			
			<div class="fr mr_20" id="div_opciones_busqueda">
				<?php /*
				<a class="formato fs_11" style="text-decoration:underline" href="javascript:void(0)"
					
				onclick="exportar_excel_local_formato('frm_busqueda')">Descargar Formato Locales</a>
				<?php if(in_array(6,$opciones)):?>
				<a class="excel fs_11" style="text-decoration:underline" href="javascript:void(0)"
					
				onclick="importar_excel_local(this,'frm_busqueda')">Importar lista de locales</a>
				<?php endif;?> 
				*/ ?>
				<?php if(in_array(5,$opciones)):?>
				<a class="imprimir fs_11" href="javascript:void(0)" onclick="imprimir()">Imprimir</a>
				<?php endif;?>
				<?php if(in_array(7,$opciones)):?>
				<a class="excel fs_11" href="javascript:void(0)" onclick="exportar_excel_local_busqueda
					
				('frm_busqueda')">Exportar a Excel</a>
				<?php endif;?>
			</div>
			
		</div>
		
		
		<div class="clear"></div>
		
	</div>
	
	<div class="contenido formulario" style="min-height:400px; width:1130px">
		
		<input type="hidden" name="campo" id="campo" value="iIdLocal" />
		<input type="hidden" name="asc" id="asc" value="ASC" />
		
		<input type="hidden" name="vNombreArchivo" id="vNombreArchivo" value="ASC" />
		
		<div id="resultado_impresion">
			
			<img width="200" id="logo_impresion_busqueda" style="float:right;display:none" src="<?php echo base_url().'public/images/logo_telefonica.png'?>" />
			<div class="clear"></div>
			
			<div class="title_cabecera titleLocalReg dn">B&uacute;squeda de Locales</div>
			
			<div id="resultado_busqueda">
			</div>
			
		</div>
		
		<?php echo form_close();?>
		
		<div class="clear pb_10"></div>
		
	</div>
	
</div>
<?php 
$opciones = explode(',',$opciones);
?>
<div class="content">
    <div class="topCont" style="height:100px!important">
    	<div class="titulo">Mantenimiento de Datos</div>
    </div>
	
	<div class="clear"></div>
	
    <div class="contenido formulario" style="min-height:400px;margin-top:152px">
		
		<div class="fl" style="width:210px">
			<?php foreach($detalleformulario as $row): ?>
			<a class="<?php if($iIdDetalleFormulario == $row->id)echo "titleoption_active"; else echo "titleoption";?> mt_0 fl w200" href="<?php echo base_url().'utilitarios/mantenimiento_datos/ver_mantenimiento_dato/'.$row->id ?>"><?php echo $row->vNombre ?></a>
			<?php endforeach ?>
			<a class="titleoption_active mt_0 fl w200" href="<?php echo base_url().'utilitarios/mantenimiento_datos/ver_categoria'?>">Categoria</a>
		</div>
		
		<div class="fl" style="width:600px;">
			
		<?php
			$attributes = array('id' => 'frm_busqueda','class' => 'formulario');
			echo form_open(base_url().'utilitarios/mantenimiento_datos/' . 'buscar_categoria_all', $attributes);
			
		?>
		
		<label class="label w100p lh_20 mb_10">Busque los documentos , selccione el tipo de documento y luego Importe :</label>

		<?php echo form_close();?>
		
		<div class="clear mb_20"></div>
		
        <div class="titleLocalReg mt_0 fl w600">Categoria</div>
		
        <div class="clear mb_10"></div>
		
		<?php
			$attributes = array('id' => 'frm_tabla','class' => 'formulario');
			echo form_open(base_url().'utilitarios/mantenimiento_datos/' . 'agregar_categoria', $attributes);
			
		?>
		
		<input type="hidden" name="id" id="id"  value="" />
		
		<label class="label w150 lh_20 mb_2 ml_20">Categoria:</label>
		<input id="vNombre" name="vNombre" type="text" class="bordercaja w238 fl lh_15 mb_7" validar="ok" value=""/>
		<span class="fl ml_10 rojo">(*)</span>
		<div class="clear"></div>
		
		<label class="label w150 lh_20 mb_2 ml_20">Estado:</label>
		<select name="eEstado" id="eEstado" class="bordercaja w238 fl lh_15 mb_7" validar="ok">
			<option value="1">Activo</option>
			<option value="2">Inactivo</option>
		</select>
		<span class="fl ml_10 rojo">(*)</span>
		<?php echo form_close();?>
		
		<div class="clear mb_20"></div>
		
		<div class="fr w300">
			<?php if(in_array(2,$opciones)):?>
        	<input type="button" value="Guardar" class="btn fl" onClick="guardar_serialize('frm_tabla')">
			<?php endif;?>
			<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="limpieza('frm_tabla')">
		</div>
		
		<div class="clear mb_20"></div>
               
	   	<div id="resultado_busqueda">
	   
			<table class="classtabla w100p">
				<thead>
					<th>Item</th>
					<th>C&oacute;digo</th>
					<th>Nombre o descripci&oacute;n</th>
					<th>Estado</th>
					<th>Opci&oacute;n</th>
				</thead>
				<tbody>
				   
				</tbody>
			</table>
			
	   	</div>
	  	
		</div>
		
		<div class="clear pb_20"></div>
		 
    </div>
	
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
function adicionar_form(){
	var serializedformdata;
	serializedformdata = '';
	return serializedformdata;
}
</script>
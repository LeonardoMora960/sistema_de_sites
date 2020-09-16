<div class="topCont" style="position:static">
	<div class="titulo">Registro Locales</div>
		<div id="tap">
			<?php $tab_name = isset($tab_name) ? $tab_name : 'datos principales';?>
			<div class="box <?php if(strcmp($tab,"registro")==0)echo'active';?> ">
				<a href="<?php if(isset($iIdLocal) && $iIdLocal > 0) echo base_url().'locales/registro/ver_local/'.$iIdLocal; else echo base_url().'locales/registro' ?>" style="text-decoration:none">
				<img src="<?php echo base_url(); ?>public/images/datos.png" id="ico_datos">
				<span>Datos principales</span>
				</a>
			</div>
			
			<?php foreach($tabs as $row_tabs):?>
				<div class="space"></div>
				<div class="box <?php if(strtolower($row_tabs->submodulo) == $tab_name)echo'active';?>">
					<a href="<?php if(isset($iIdLocal) && $iIdLocal > 0)echo base_url().$row_tabs->vRutaPag.'/'.$iIdLocal; else echo "javascript:void(0)"; ?>" style="text-decoration:none">
					<img src="<?php echo base_url().$row_tabs->vRutaImg; ?>" id="<?php echo $row_tabs->iIdImg?>">
					<span><?php echo $row_tabs->submodulo?></span>
					</a>
				</div>
				
			<?php endforeach;?>
			
			<div class="spaceEnd"></div>
		</div>
</div>
<div id="welcome" class="content formulario">
	<div class="fl fs_20 bold mt_20" style="font-family:headline;color:#005E7B;padding: 5px 40px;">Mapa del Sitio</div>
	<div class="clear mb_10"></div>
    <ul style="padding: 5px 85px;" class="fl">					
		<?php foreach($modulo as $row_modulo):?>
			<li>
				<a href="javascript:void(0)" class="fl tdn color_005E7B mt_5 mb_5"><?php echo $row_modulo->modulo?></a>
				<div class="clear"></div>
				<ul class="ml_20">
			<?php 
				$submodulo = $this->administracion->get_permiso_submodulo($iIdUsuario,$row_modulo->iIdModulo);
				foreach($submodulo as $row_submodulo):
			?>
					<li><a class="fl tdn color_005E7B mt_5 mb_5" href="<?php echo base_url().$row_submodulo->vRutaPag?>"><?php echo $row_submodulo->submodulo?></a></li>
			<?php endforeach;?>	
				</ul>
				<div class="clear"></div>
			</li>
		<?php endforeach;?>
	</ul>
	
</div>
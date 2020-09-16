<div class="content">
<?php
$pagina['tab'] = 'registro';
$this->load->view('template/tabs', $pagina);
$opciones = explode(',', $opciones);
?>
	<div class="clear"></div>
	<div class="contenido formulario" style="min-height:400px;margin-top:192px">
		<div class="row">
			<div class="col-md-2">
				<div class="menu__formulario--accordion" style="margin-left: -1.5em;">
					<?php
					$id_fase_uno = 0;
					$id_principal = 0;
					foreach($menu_items as $menu_item) {
						if ($id_principal == 0) {
							$id_principal = $menu_item->id_fase_tres;
						}
						if ($id_fase_uno != 0 && $id_fase_uno != $menu_item->id) {
					?>
							</ul>
						</div>
					<?php
						}
						if ($id_fase_uno != $menu_item->id) {
							$id_fase_uno = $menu_item->id;
					?>
						<h3><?= $menu_item->nombre ?></h3>
						<div>
							<ul class="menu__formulario_accordion">
								<li onClick="cargarFormularioCampos(3, <?= $menu_item->id_fase_tres ?>)"><?= $menu_item->nombre_fase_tres ?></li>
					<?php
						} else {
					?>
								<li onClick="cargarFormularioCampos(3, <?= $menu_item->id_fase_tres ?>)"><?= $menu_item->nombre_fase_tres ?></li>
					<?php
						}
					}
					?>
							</ul>
						</div>
				</div>
			</div>
			<div class="col-md-10">
				<div id="box__formulario--campos"></div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
cargarFormularioCampos(3, <?= $id_principal ?>);
</script>
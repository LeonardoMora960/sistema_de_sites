<div class="titleLocalReg mt_0 fl">Lista de campos en el formulario de  Locales</div>
<div class="fl mt_10">
	<label class="label w140 lh_20 mb_2 ml_20">Nombre del campo:</label>
	<input id="vNombreBusqueda" name="vNombreBusqueda" type="text" class="bordercaja w240 fl lh_15 mb_7" value="" />
</div>
<div class="fl w300 ml_60">
	<input type="button" value="Buscar" class="btn fl" onClick="<?= (empty($function_formulario)) ? 'Buscar()': $function_formulario ?>">
	<input type="button" name="" value="Limpiar" class="btn fl ml_10" onclick="limpieza('frm_formulario')">
</div>
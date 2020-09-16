

<style type="text/css">
form{
	font-size:11px;
	/*margin-top:12px*/
}
</style>

<form name="frm_categoria" id="frm_categoria" method='post' class="formulario" action="<?php echo base_url()?>locales/registro/agregar_categoria">

<img class="fl" src="<?php echo base_url().'public/images/u158_normal.png'?>" />
<div class="title_frm fl w200 mt_10 ml_10">Agregar Nueva Categor&iacute;a</div>

<div class="clear mb_15"></div>

<label class="label w120 lh_20 mb_2 ml_15">Nombre Categória:</label>
<input id="vNombre" name="vNombre" type="text" class="bordercaja w170 fl lh_15 mb_7" validar="ok" value=""/>

<div class="clear mb_5"></div>

<div class="fila_mantenedor">
	    <span id="mensaje_mantenedor"></span>
</div>

</form>

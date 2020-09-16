<!DOCTYPE html>
<html lang="es">
<head><meta charset="gb18030">

<!--<base href="<?php //echo base_url() ?>">-->
<title>SISTEMA ADMINISTRACION DE SITIOS<?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/main.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/paginacion.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/dialog/zebra_dialog.css" type="text/css">

<link href='https://css.gg/alarm.css' rel='stylesheet'>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



<script type="text/javascript" src="<?php echo base_url(); ?>public/js/impresion/jquery-1.6.4.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/impresion/jquery.jqprint.js"></script>

<!--<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-1.7.2.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/AjaxUpload.2.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/general.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-ui-1.10.0.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/zebra_dialog.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/datepicker_es.js"></script>

<script type="text/javascript">
	   var gurl="<?php echo base_url();?>";
</script>

<?php
if (isset($jw_jsoptional) && !empty($jw_jsoptional)) {
	echo $jw_jsoptional;
}
?>

<script type="text/javascript">

function loadprov(dpto){
	$.ajax({
		type:'POST',
		url: "<?php echo base_url(); ?>locales/registro_locales/codprov/"+dpto,
		success: function(data){
			$("#selectos4").html(data);
		}
	});
}

function loaddist(dpto, prov){
	$.ajax({
		type:'POST',
		url: "<?php echo base_url(); ?>locales/registro_locales/coddist/"+dpto+"/"+prov,
		success: function(data){
			$("#selectos5").html(data);
		}
	});
}

</script>

</head>

<body>

<div id="AjaxLoading" style="position:fixed;top:380px;left:617px;display:none;z-index:1000px">
  <img src="<?php echo base_url()?>public/images/252.gif" />
</div>

    <!-- header top bar -->
    <div id="top">
        <div class="topMain">
            <div class="tLeft">
                Bienvenido : <?php echo $NombreUsuario?>
            </div>
            <div class="tRight">
                <a href="<?php echo base_url() ?>login/logout">
                    Cerrar sesión
                </a>
            </div>
        </div>
    </div>

    <header>
        <!-- haeder bar help -->
		
		<div class="clear">&nbsp;</div>
		
        <div id="header" style="height:40px">
            <div class="hLeft" style="height:40px;width:680px">
                <!-- TITLE -->
                <!--<div class="titulo">Administración de Locales</div>-->
                <!-- MENU MAIN -->
                <div class="menu">
                    <a href="<?php echo base_url().'home' ?>" class="home"></a>
                    <ul class="nav" style="margin:0px">
					
						<?php foreach($modulo as $row_modulo):?>
							<li>
								<a href="#" class="n1"><?php echo $row_modulo->modulo?></a>
								<ul>
							<?php 
								$submodulo = $this->administracion->get_permiso_submodulo($iIdUsuario,$row_modulo->iIdModulo);
								foreach($submodulo as $row_submodulo):
							?>
									<li><a href="<?php echo base_url().$row_submodulo->vRutaPag?>"><?php echo $row_submodulo->submodulo?></a></li>
							<?php endforeach;?>	
								</ul>
                            
                        	</li>
						
						<?php endforeach;?>
						
                    </ul>
                </div>
            </div>
            <div class="hRight" style="top:0px;height:40px;width:250px">
                <!-- LOGOTIPO -->
                <a href="<?php echo base_url(); ?>" class="logo" style="top:5px">
                    <img src="<?php echo base_url(); ?>public/images/logo.png" width="130px">
                </a>
            </div>
        </div>

    </header>

    <section>
            
            
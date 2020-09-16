<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<!--<base href="<?php //echo base_url() ?>">-->
<title>SISTEMA ADMINISTRACION DE SITIOS - <?php echo $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/main.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/paginacion.css" type="text/css">


<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/dialog/zebra_dialog.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>public/js/impresion/jquery-1.6.4.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/impresion/jquery.jqprint.js"></script>


<!--<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-1.7.2.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/AjaxUpload.2.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/general.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>public/js/zebra_dialog.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/datepicker_es.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-ui-1.10.0.custom.js"></script>

<link href='https://css.gg/alarm.css' rel='stylesheet'>


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
    <div id="top" style="position:fixed">
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
        <!--<div class="barhelpx">-->
		
            <!--<div class="manual">
                <a href="#">Descargar Manual</a>
            </div>
            <div class="stLine">|</div>
            <div class="pregunta">
                <a href="<?php //echo base_url() ?>help">Ayuda</a>
            </div>-->
        <!--</div>-->
		<div class="clear">&nbsp;</div>
		
		<?php $top = 36;
		
		if(path_of_controller() == 'home'):?>
		<div class="titulo w100p" style="height:60px;line-height:60px;top:36px;position:fixed;font-family:headline;font-size: 23px;font-style: normal;font-weight: 900;text-decoration: none;color: #2581C4;     width: 930px!important; background: #fff">Administración de Sitios
		    <img src="<?php echo base_url(); ?>public/images/logo.png" style="float: right;height: 90px;width: auto;margin-top: -10px;" width="130px">
		</div>
		<?php 
			$top+=60;
		endif;?>
		
        <div id="header" style="height:40px;top:<?php echo $top?>px;position:fixed;background:#00425A;z-index:10">
            <div class="hLeft" style="height:40px;width:930px">
                <!-- TITLE -->
                <!-- MENU MAIN -->
                <div class="menu">
                    <a href="<?php echo base_url().'home' ?>" class="home"></a>
                    <ul class="nav" style="margin:0px;">
						<?php foreach($modulo as $row_modulo):?>
							<li style="z-index:99999">
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
						
                        <li>
                            <a target="_blank" href="<?php echo base_url().'archivo/manual/Manual_Telefonica_locales.pdf'?>" class="n1" style="width:180px;background-image:none;padding-bottom:7px">Descargar Manual</a>                        
                        </li>
						
						
                    </ul
                    <?php if(path_of_controller() != 'home'):?>
                        <!-- LOGOTIPO -->
                        <a href="<?php echo base_url(); ?>" class="logo" style="float: right">
                            <img src="<?php echo base_url(); ?>public/images/logo.png" style="    height: 80px;width: auto;margin-top: -15px;">
                        </a>
                    <?php endif;?>
                </div>
            </div>
			
			<div class="clear"></div>
			
        </div>

    </header>

    <section>
            
            
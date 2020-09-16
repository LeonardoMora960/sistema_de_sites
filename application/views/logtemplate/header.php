<?php  
    $month = date("m");

    switch ($month) {
        case 1:
            $mo = "Enero";
            break;
        case 2:
            $mo = "Febrero";
            break;
        case 3:
            $mo = "Marzo";
            break;
        case 4:
            $mo = "Abril";
            break;
        case 5:
            $mo = "Mayo";
            break;
        case 6:
            $mo = "Junio";
            break;
        case 7:
            $mo = "Jilio";
            break;
        case 8:
            $mo = "Agosto";
            break;
        case 9:
            $mo = "Setiembre";
            break;
        case 10:
            $mo = "Octubre";
            break;
        case 11:
            $mo = "Noviembre";
            break;
        case 12:
            $mo = "Diciembre";
            break;
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sistema Administración de Sitios</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/dialog/zebra_dialog.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/impresion/jquery-1.6.4.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/general.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/ingreso/ingreso.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/zebra_dialog.js"></script>
<script type="text/javascript">

var gurl="<?php echo base_url();?>";

function validarMail(mail){
    var ab = mail.indexOf("@");
    var pt = mail.lastIndexOf(".");
    if (pt<1 || pt<ab+2 || pt+2>=mail.length)
    {
        $('#check').html('<img src="<?php echo base_url(); ?>public/images/cross-circle.png">');
		
    }else{
        $('#check').html('<img src="<?php echo base_url(); ?>public/images/check.png">');
		$("#ingresar").removeAttr('disabled');
		$('.error').hide('slow');
		$("#enviar").removeAttr('disabled');
    }
}
</script>
</head>
<body onKeypress="if (event.keyCode == 13) {acceder();}">
	<div id="main_login">
    	<header>
        	<div class="top">
            	<div class="hLeft">
                	<a href="#" class="logo" style="">
                    	<img src="<?php echo base_url(); ?>public/images/logo-white.png" style="width: 170px;margin-top: 26px;">
                        <span>Teléfonica</span>
                    </a>
                </div>
                <div class="hRight">
                	<div class="fecha">
                        <?php echo date('d'). " de " .$mo. " del ". date("Y"); ?>
                    </div>
                    <div class="titulo" style="font-size: 25px;">
						Sistema de Administración de Sitios
                    </div>
                </div>
            </div>
        </header>
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
<title>Login - Teléfonica Soluciones</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/dialog/zebra_dialog.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/impresion/jquery-1.6.4.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/general.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/ingreso/ingreso.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/zebra_dialog.js"></script>
<script type="text/javascript">var gurl="<?php echo base_url();?>";</script>
</head>
<body onKeypress="if (event.keyCode == 13) {enviar_clave();}">
	<div id="main_login">
    	<header>
        	<div class="top">
            	<div class="hLeft">
                	<a href="#" class="logo">
                    	<img src="<?php echo base_url(); ?>public/images/logo.png">
                        <span>Teléfonica</span>
                    </a>
                </div>
                <div class="hRight">
                	<div class="fecha">
                        <?php echo date('d'). " de " .$mo. " del ". date("Y"); ?>
                    </div>
                    <div class="titulo">
						Administracion de Locales
                    </div>
                </div>
            </div>
        </header>
		
<section>
	<div class="sLeft">
    	<!--<img src="">-->
		&nbsp;
    </div>
    <div class="sRight">
    	<div class="formLogin">
            <?php //echo form_open("login/sendclave", array('id'=>'loginIn')); ?>
			<form name="loginIn" id="loginIn" method="post" class="formulario mt_20 arial">
                <table cellpadding="0" cellspacing="0" border="0" width="440">
                  <tbody>
                        <tr>
                            <td height="60" colspan="3" valign="top"><span class="tituloForm">Recuperación de contraseña</span></td>
                        </tr>
                        <tr>
                              <td width="160" height="34">
                              <span class="labelLogin">Correo coorporativo  :</span>
                              </td>
                                <td width="250">
                                    <input name="usuario" id="usuario" type="text" placeholder="Ingresar Correo Asociado" onKeyPress="validarMail($('#usuario').val())">
                              </td>
                              <td align="center" id="check">
                              </td>
                    	</tr>
                        <tr>
                          <td height="50"></td>
                            <td height="30" align="right" valign="middle">
                                <button type="button" class="btn" id="enviar_clave" name_frm="loginIn" controlador="login/sendclave/">ENVIAR</button>
								<button type="button" class="btn" onclick="location.href='<?php echo base_url().'login'?>'">REGRESAR</button>
                            </td>
                            <td></td>
                    </tr>
                        <tr>
                            <td height="50" colspan="3">
                              <span class="exito">Se envíara a su correo un email para la restauración de su contraseña Gracias.</span>                                    </td>
                        </tr>
                        
                  </tbody>
                </table>
          </form>
        </div>
    </div>
</section>


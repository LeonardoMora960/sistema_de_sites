<section>
	<div class="sLeft">
        <div class="formLogin">
            
            <?php //echo form_open('process', array('id'=>'loginIn', 'name'=>'loginIn')); ?>
			
			<form name="loginIn" id="loginIn" method="post" class="formulario mt_20 arial">
			
                <table cellpadding="0" cellspacing="0" border="0" width="440">
                  <tbody>
                        <tr>
                            <td height="60" colspan="3" valign="top"><span class="tituloForm">Ingreso al Sistema</span></td>
                        </tr>
                        <tr>
                          <td width="160" height="34">
                          <span class="labelLogin">Usuario  :</span>
                          </td>
                            <td width="250">
								<!-- onblur="validarMail($('#email').val())" -->
                                <input name="usuario" id="usuario" type="text" placeholder="Ingresar Correo Asociado" onblur="validarMail($('#usuario').val())">
                          </td>
                          <td align="center" >
                            	
                          </td>
                    </tr>
                        <tr>
                          <td width="160" height="34">
                          	<span class="labelLogin">Contraseña :</span>
                          </td>
                           <td>
                                <input name="contrasena" type="password" id="contrasena" placeholder="Ingresar Contraseña">
                          </td>
                          <td align="center">
                          </td>
                    </tr>
                        <tr>
                            <td height="50"></td>
                            <td>
                                <span class="olvido">
                                <?php echo $error; ?>
                                <!--<em>¿Olvidó su contraseña? <a href="<?php //echo base_url(); ?>recuperar-password" class="olvideClave">Clic aquí</a></em>-->
								</span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="30">
                                <button type="button" class="btn" id="ingresar" name_frm="loginIn" controlador="login/process/">INGRESAR</button>
                                <button type="reset" class="btn">LIMPIAR</button>
                            </td>
                            <td></td>
                        </tr>
                  </tbody>
                </table>
          </form>
        </div>
    </div>
    <div class="sRight">
    	
    </div>
</section>

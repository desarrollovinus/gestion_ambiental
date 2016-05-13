<center>
    <img src="<?php echo base_url(); ?>img/logo.png" />
</center>

<div class="page-header">
	<h4>Inicio de sesión <small>Por favor ingrese su usuario y contraseña para ingresar a la aplicación</small></h4>
</div>

<?php
//Se abre el formulario 
echo form_open('sesion/validar');

//Se abre un fieldset
// echo form_fieldset('Iniciar sesi&oacute;n');
?>

<input type="text" id="usuario" name="usuario" class="span12" placeholder="Nombre de usuario"/>
<span class="usuario"></span>
<br>
<input type="password" id="password" name="password" class="span12" placeholder="Contraseña"/>
<span class="password"></span>
<br>

<div class="form-actions">
    <input type="submit" class="btn btn-primary btn-block" value="Ingresar"/>
</div>
<?php
//Se cierra el formulario
echo form_close();
?>
<script>
    //Cuando el DOM este listo
    $(document).ready(function(){
        //Se establece el foco del formulario
        $('#usuario').focus();
        
        /*
         * Estos son los campos a validar. False: obligatorios
         */
        val_usuario = false;
        val_password = false;
        
        //Cuando se presione el boton del formulario
        $("form").submit(function(){
            //Se valida que los campos no esten vacios
            var usuario = $.trim($("#usuario").val());
            var password = $.trim($('#password').val());

            //Nombre de usuario
            if(usuario.length == 0){
                val_usuario = false;
                $(".usuario").removeClass("exito");
                $(".usuario").addClass("error");
                $(".usuario").html('<i class="icon-remove-sign"></i><br>El nombre de usuario es obligatorio.');
            }else{
                val_usuario = true;
                $(".usuario").removeClass("error");
                $(".usuario").html('<i class="icon-ok-sign"></i>');
            }//Fin nombre de usuario

            if(password.length < 4){
                val_password = false;
                $(".password").removeClass("exito");
                $(".password").addClass("error");
                $(".password").html('<i class="icon-remove-sign"></i><br>La contrase&ntilde;a debe ser m&iacute;nimo de cuatro caracteres');
            }else{
                val_password = true;
                $(".password").removeClass("error");
                $(".password").html('<i class="icon-ok-sign"></i>');
            }//Fin password

            //Se obtiene el atributo action del formulario
            var url = $(this).attr("action");
                        
            //Se valida que todos los campos superen las validaciones
            if((val_usuario == false || val_password == false)){
                //Se muestra el mensaje de error
                // $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede iniciar sesi&oacute;n.\n\
                // Debe digitar nombre de usuario y contrase&ntilde;a.</div>');
            }else{
                //Se almacenan los datos en formato JSON
                var datos = {
                    usuario: $('#usuario').val(),
                    password: $('#password').val()
                };//fin datos
                //se realiza la peticion tipo ajax
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: datos,
                    success: function(msg){
                        //Si el mensaje que llega es true
                        if(msg == 'true'){
                            //Se redirecciona al inicio
                            location.href = "<?php echo site_url(''); ?>";
                        }else if(msg == 'false'){
                            //Se deja en la sesion
                            location.href = "<?php echo site_url('sesion'); ?>";
                        }
                    }//Fin success
                });//Fin ajax
            }
            return false;
        });//Fin form
    });//Fin document.ready
</script>
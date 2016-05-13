<div id="form">
    <?php echo form_fieldset('Crear usuario'); ?>
    <table>
        <tr>
            <td>
                <input type="text" id="nombres" name="nombres" class="input-large" placeholder="Nombres*" />
                <span class="nombres"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" id="apellidos" name="apellidos" class="input-large" placeholder="Apellidos*"/>
                <span class="apellidos"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" id="documento" name="documento" class="input-large" placeholder="N&uacute;mero de documento*"/>
                <span class="documento"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" id="usuario" name="usuario" class="input-large" placeholder="Nombre de usuario*"/>
                <span class="nombre_usuario"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" id="password" name="password" class="input-large" placeholder="Contrase&ntilde;a*"/>
                <span class="password"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" id="password2" name="password2" class="input-large" placeholder="Repita la contrase&ntilde;a*"/>
                <span class="password2"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" id="email" name="email" class="input-large" placeholder="Correo electr&oacute;nico"/>
                <span class="email"></span>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" id="telefono" name="telefono" class="input-large" placeholder="Tel&eacute;fono"/>
                <span class="telefono"></span>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <input type="button" id="guardar" class="btn btn-primary" value="Guardar"/>
        <input type="button" class="btn" value="Cancelar" onClick="history.back()"/>
    </div>
    <?php echo form_fieldset_close(); ?>
</div>
<script>
    //Cuando el DOM este listo
    $(document).ready(function(){
        //Se establece el foco del formulario
        $('#nombres').focus();
        
        /*
         * Estos son los campos a validar. False: obligatorios
         */
        val_nombres = false;
        val_apellidos = false;
        val_documento = false;
        val_usuario = false;
        val_password = false;
        val_password2 = false;
        val_email = true;
        val_telefono = true;

        //Nombres
        $('#nombres').bind('blur', function(){
            var nombres = $.trim($("#nombres").val());
            
            if(nombres.length == 0){
                val_nombres = false;
                $(".nombres").removeClass("exito");
                $(".nombres").addClass("error");
                
            }else{
                val_nombres = true;
                $(".nombres").removeClass("error");
                $(".nombres").html('<i class="icon-ok-sign"></i>');
            }
        });//Fin nombres
        
        //Apellidos
        $('#apellidos').bind('blur', function(){
            var apellidos = $.trim($("#apellidos").val());
            
            if(apellidos.length == 0){
                val_apellidos = false;
                $(".apellidos").removeClass("exito");
                $(".apellidos").addClass("error");
                $(".apellidos").html('<i class="icon-remove-sign"></i>El apellido es obligatorio.');
            }else{
                val_apellidos = true;
                $(".apellidos").removeClass("error");
                $(".apellidos").html('<i class="icon-ok-sign"></i>');
            }
        });//Fin apellidos
        
        //Documento
        $('#documento').bind('blur', function(){
            var documento = $.trim($("#documento").val());
            
            if(documento.length == 0){
                val_documento = false;
                $(".documento").removeClass("exito");
                $(".documento").addClass("error");
                $(".documento").html('<i class="icon-remove-sign"></i>El n&uacute;mero de documento es obligatorio.');
            }else{
                if(tiene_letras(documento)){
                    val_documento = false;
                    $(".documento").removeClass("exito");
                    $(".documento").addClass("error");
                    $(".documento").html('<i class="icon-remove-sign"></i>El n&uacute;mero de documento no puede tener letras.');                    
                }else{
                    val_documento = true;
                    $(".documento").removeClass("error");
                    $(".documento").html('<i class="icon-ok-sign"></i>');
                }
            }
        });//Fin documento
        
        //Nombre de usuario
        $('#usuario').on('keypress', function(){
            /**********/
            var usuario = $.trim($(this).val());
            var datos = {
                nombre_usuario: usuario
            };
            
            $.ajax({
                url: '<?php echo site_url('usuario/validar_ajax'); ?>',
                type: 'POST',
                data: datos,
                success: function(msg){
                    if(usuario.length == 0){
                        val_usuario = false;
                        $(".nombre_usuario").removeClass("exito");
                        $(".nombre_usuario").addClass("error");
                        $(".nombre_usuario").html('<i class="icon-remove-sign"></i>El nombre de usuario es obligatorio.');
                    }else{
                        if(msg == 'true'){
                            val_usuario = false;
                            $(".nombre_usuario").removeClass("exito");
                            $(".nombre_usuario").addClass("error");
                            $(".nombre_usuario").html('<i class="icon-remove-sign"></i>El usuario ' + usuario + ' ya se encuentra registrado.');
                        }else{
                            val_usuario = true;
                            $(".nombre_usuario").removeClass("error");
                            $(".nombre_usuario").addClass("exito");
                            $(".nombre_usuario").html('<i class="icon-ok-sign"></i>El usuario ' + usuario + ' est&aacute; disponible.');
                        }
                    }
                }
            });
        });//Fin nombre de usuario
        
        //Password
        $('#password').bind('blur', function(){
            var password = $.trim($(this).val());
            if(password.length < 4){
                val_password = false;
                $(".password").removeClass("exito");
                $(".password").addClass("error");
                $(".password").html('<i class="icon-remove-sign"></i>La contrase&ntilde;a debe ser m&iacute;nimo de cuatro caracteres');
            }else{
                val_password = true;
                $(".password").removeClass("error");
                $(".password").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin password
        
        //password2
        $('#password2').bind('blur', function(){
            var password = $.trim($('#password').val());
            var password2 = $.trim($(this).val());
            
            if(password2.length == 0){
                val_password2 = false;
                $(".password2").addClass("error");
                $(".password2").html('<i class="icon-remove-sign"></i>Repita la contrase&ntilde;a');
            }else{
                if(password2 != password){
                    val_password2 = false;
                    $(".password2").removeClass("exito");
                    $(".password2").addClass("error");
                    $(".password2").html('<i class="icon-remove-sign"></i>Las contrase&ntilde;as no coinciden');
                }else{
                    val_password2 = true;
                    $(".password2").removeClass("error");
                    $(".password2").html('<i class="icon-ok-sign"></i>');
                }
            }
        })//Fin password2
        
        //email
        $('#email').bind('blur', function(){
            var email = $.trim($('#email').val());
            if(email.length >= 0){
                val_email = true;
                $(".email").removeClass("error");
                $(".email").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin email
        
        //Telefono
        $('#telefono').bind('blur', function(){
            var telefono = $.trim($(this).val());
                
            if(tiene_letras(telefono)){
                val_telefono = false;
                $(".telefono").removeClass("exito");
                $(".telefono").addClass("error");
                $(".telefono").html('<i class="icon-remove-sign"></i>El n&uacute;mero de tel&eacute;fono no puede tener letras.');                    
            }else{
                val_telefono = true;
                $(".telefono").removeClass("error");
                $(".telefono").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin telefono
        
        $('#guardar').click(function(){
            //Se valida que todos los campos superen las validaciones
            if(
                val_nombres == false || 
                val_apellidos == false || 
                val_documento == false || 
                val_usuario == false || 
                val_password == false || 
                val_password2 == false || 
                val_email == false || 
                val_telefono == false
            ){
                //Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede guardar el usuario.\n\
                Verifique que los campos obligatorios esten aun llenos.</div>');
            }else{
                //Si el formulario esta listo, envia por post los datos y procesa la informacion
                $.post(
                    '<?php echo site_url('usuario/crear'); ?>',
                    {
                        //Variables que se envian por post
                        documento: $.trim($("#documento").val()),
                        nombres: $.trim($("#nombres").val()),
                        apellidos: $.trim($("#apellidos").val()),
                        usuario: $.trim($("#usuario").val()),
                        password: $.trim($("#password").val()),
                        email: $.trim($("#email").val()),
                        telefono: $.trim($("#telefono").val())
                    },
                    function(msg){
                        //Si la respuesta que viene del php es true
                        if(msg == 'true'){
                            //Se redirecciona
                            location.href = "<?php echo site_url('inicio'); ?>";
                        }else{
                            
                        }
                    }
                );//Fin post
            }//Fin if
        })//Fin guardar
    });//Fin document.ready
</script>
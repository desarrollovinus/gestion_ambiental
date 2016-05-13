<?php
//Se consultan los usuarios con acceso a la aplicación
$usuarios = $this->permisos_model->cargar_usuarios();
?>

<ul class="nav nav-list">
	<li class="nav-header">Administración</li>
    <?php if (isset($acceso[26])) { ?>
	<li>
		<a id="auditoria" href="#">Auditoría</a>
	</li>
    <?php } ?>
    <?php if (isset($acceso[27])) { ?>
	<li>
		<a id="permisos" href="#">Permisos</a>
	</li>
    <?php } ?>
    <!-- Cuando se de clic en permisos, se mostrará el select -->
    <li id="div_usuario" class="ocultar">
        <select id="usuario" class="span12">
            <option value="">Seleccione un usuario</option>
            <?php
            //Recorrido de usuarios
            foreach ($usuarios as $usuario) {
                ?>
                <option value="<?php echo $usuario->Pk_Id_Usuario; ?>"><?php echo $usuario->Nombres." ".$usuario->Apellidos; ?></option>    
                <?php } ?>
        </select>
    </li>
    
    <li class="divider"></li>
</ul>

<script type="text/javascript">
	//Cuando el DOM este listo
    $(document).ready(function(){
    	//Auditoria
    	$("#auditoria").on('click', function(){
    		//Se carga las auditorias
    		$("#vista").load("<?php  echo site_url('administracion/auditoria'); ?>");
    	});//Fin auditoria

    	//Cuando se da clic en permisos
    	$("#permisos").on('click', function(){
            // Se muestra el select con los usuarios
            $("#div_usuario").slideDown('slow');
    	});//Fin usuarios

        // Cuando se selecciona un usuario
        $("#usuario").on("change", function(){
            //Si selecciona un usuario
            if ($(this).val() != "") {
                //Se carga la vista delos permisos para ese usuario
                $("#vista").load("<?php  echo site_url('administracion/permisos'); ?>", {id_usuario: $(this).val()});        
            };
        })
    });//Fin document.ready
</script>

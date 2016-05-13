<?php $usuarios = $this->usuario_model->listar($this->config->item('id_aplicacion')); ?>
<div class="administracion">
	<?php
	$cont = 1;
	foreach ($usuarios as $usuario){
	?>
	<div class="box-header cabecera">
		<div class="numero"><?php echo $cont; ?></div>
		<div class="usuario"><?php echo $usuario->Nombres.' '.$usuario->Apellidos; ?></div>
		<div class="fecha">
			<div class="numero"></div>
			<div class="numero">
				<a title="Ver Historial" href="#">
					<i class="icon-tasks"></i>
				</a>
			</div>
			<div class="numero">
				<a id="permisos" title="Permisos" href="javascript:cargar_permisos(<?php echo $usuario->Pk_Id_Usuario; ?>)">
					<i class="icon-asterisk"></i>
				</a>
			</div>
			<a title="Ver historial" href="#">
				<i class="icon-eye-open"></i>
			</a>
		</div>
	</div>
	<div id="usuario<?php echo $usuario->Pk_Id_Usuario; ?>" class="box-content cuerpo ocultar"></div>
	<?php
	$cont++;
	}//Fin foreach
	?>
</div>
<script type="text/javascript">
	function cargar_permisos(id_usuario) {
		//Se carga los usuarios
	    $("#usuario" + id_usuario).load("<?php echo site_url('administracion/permisos'); ?>", {id: 555}).slideToggle();
	}

	//Cuando el DOM este listo
    $(document).ready(function(){
    	
    });//Fin document.ready
</script>
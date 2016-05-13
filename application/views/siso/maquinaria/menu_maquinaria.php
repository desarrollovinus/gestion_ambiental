<!--Validar permiso-->
<?php if (isset($acceso[69])) { ?>
	<button class="btn btn-primary btn-block" type="button" id="crear" >Crear</button>
<?php } ?>

<!--Validar permiso-->
<?php if (isset($acceso[71])) { ?>
	<button class="btn btn-primary btn-block" type="button" id="consultar" >Consultar</button>
<?php } ?>

<!--Validar permiso-->
<?php //if (isset($acceso[71])) { ?>
	<button class="btn btn-primary btn-block" type="button" id="hallazgos" >Hallazgos</button>
<?php //} ?>

<script type="text/javascript">
	$(document).ready(function(){
		// Crear inspección de maquinaria
		$("#crear").on("click", function(){
			// Redireccionar
			location.href = '<?php echo site_url("siso/inpeccion_maquinaria"); ?>';
		});

		// Consulta de inspecciones de maquinaria
		$("#consultar").on("click", function(){
			// Redireccionar
			location.href = '<?php echo site_url("siso/maquinaria"); ?>';
		});

		// Consulta de hallazgos
		$("#hallazgos").on("click", function(){
			// Redireccionar
			location.href = '<?php echo site_url("siso/hallazgos_inspeccion_maquinaria"); ?>';
		});
	});
</script>
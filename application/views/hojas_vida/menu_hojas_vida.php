<?php $fechas = $this->hoja_vida_model->listar_fechas(); ?>

<!--Validar permiso-->
<?php if (isset($acceso[57])) { ?>
	<button class="btn btn-primary btn-block" type="button" id="crear" >Crear</button>
<?php } ?>

<!--Validar permiso-->
<?php if (isset($acceso[59])) { ?>
	<button class="btn btn-primary btn-block" type="button" id="consultar" >Consultar</button>
<?php } ?>

<!--Validar permiso-->
<?php if (isset($acceso[67])) { ?>
	<button class="btn btn-primary btn-block" type="button" id="crear_capacitacion" >Crear capacitación</button>
<?php } ?>

<!--Validar permiso-->
<?php if (isset($acceso[63])) { ?>
	<button id="btn_generar" class="btn btn-primary btn-block" type="button">Generar reporte semanal</button>
<?php } ?>

<!--Validar permiso-->
<?php if (isset($acceso[64]) || isset($acceso[66])) { ?>
	<p></p>
	<h4>Imprimir reporte:</h4>

	<select id="select_reporte" class="select_lateral">
		<option value="">Seleccione...</option>
		<?php if (isset($acceso[66])) { ?>
			<option value="0">Consolidado total</option>
		<?php } ?>
		<?php if (isset($acceso[64])) { ?>
			<?php foreach ($fechas as $fecha) { ?>
				<option value="<?php echo $fecha->Fecha; ?>">Vinculados <?php echo $fecha->Fecha; ?></option>
			<?php } ?>
		<?php } ?>
	</select>
<?php } ?>

<script type="text/javascript">
	$("#crear").on("click", function(){
		location.href = '<?php echo site_url("hoja_vida/crear"); ?>';
	});

	$("#consultar").on("click", function(){
		location.href = '<?php echo site_url("hoja_vida"); ?>';
	});

	$("#crear_capacitacion").on("click", function(){
		location.href = '<?php echo site_url("hoja_vida/crear_capacitacion"); ?>';
	});
	
	//Reporte de hojas de vida
	$("#select_reporte").on("change", function(){
		//Si se selecciona algún válido
		if ($(this).val() != "") {
			//Se ejecuta el reporte, filtrando la característica seleccionada
			location.href = '<?php echo site_url("reporte/hojas_vida/"); ?>' + "/" + $(this).val();

		};

		return false;
	});//Reporte de hojas de vida
</script>
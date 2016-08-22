<div class="row-fluid">
	<!--Validar permiso-->
	<?php if (isset($acceso[76])) { ?>
		<div class="span6">
		 	<div class="box-header"><h2>Informe mensual de capacitaciones</h2></div>
		    <div class="box-content">
				<div class="mensaje_capacitaciones"></div>
				<div class="controls">
					<!-- Año -->
	    			<select id="anio_capacitacion" class="span6">
	    				<option value="0">Año</option>
						<?php foreach ($this->reporte_model->listar_anios_capacitaciones() as $anio_capacitacion) { ?>
							<option value="<?php echo $anio_capacitacion->Anio; ?>"><?php echo $anio_capacitacion->Anio; ?></option>
						<?php } ?>
	    			</select>

					<!-- Mes -->
	    			<select id="mes_capacitacion" class="span6">
	    				<option value="0">Mes</option>
						<?php foreach ($this->solicitud_model->listar_meses() as $mes) { ?>
							<option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
						<?php } ?>
	    			</select>

	    			<!-- Clic -->
		    		<button id="btn_capacitaciones" class="btn btn-large btn-block btn-success btn-primary" type="button">Generar</button>
	    		</div>
	    	</div>
		</div>
	<?php } ?>
</div>

<div class="row-fluid">
	<!--Validar permiso-->
	<?php if (isset($acceso[28])) { ?>
		<div class="span6">
			<div class="box-header"><h2>Plantilla de solicitudes</h2></div>
		    <div class="box-content">
				<button class="btn btn-large btn-block btn-danger btn-primary" type="button" onClick="window.location = 'reporte/solicitud_recepcion'">Generar PDF</button>
		    </div>
		</div>
	<?php } ?>

	<!--Validar permiso-->
	<?php if (isset($acceso[29])) { ?>
		<div class="span6">
			<div class="box-header"><h2>Consolidado total de solicitudes por tramo</h2></div>
		    <div class="box-content">
				<button class="btn btn-large btn-block btn-success btn-primary" type="button" onClick="window.location = 'reporte/consolidado_tramos'">Generar Excel</button>
		    </div>
		</div>
	<?php } ?>
</div>

<div class="row-fluid">
	<!--Validar permiso-->
	<?php if (isset($acceso[30])) { ?>
		<div class="span6">
		 	<div class="box-header"><h2>ICA 0</h2></div>
		    <div class="box-content">
		    	<select id="tramo_ica0" class="span12" ></select>
				<button id="btn_ica0" class="btn btn-large btn-block btn-success btn-primary" type="button" disabled>Generar Excel</button>
		    </div>
		</div>
	<?php } ?>

	<!--Validar permiso-->
	<?php if (isset($acceso[31])) { ?>
		<div class="span6">
		 	<div class="box-header"><h2>Registro Fotográfico Mensual</h2></div>
		    <div class="box-content">
				<div class="mensaje"></div>
				<div class="controls">
					<!-- Área -->
	    			<select id="area" class="span5">
	    				<option value="0">Área</option>
						<?php foreach ($this->reporte_model->listar_areas() as $area) { ?>
							<option value="<?php echo $area->Pk_Id_Area; ?>"><?php echo $area->Nombre; ?></option>
						<?php } ?>
	    			</select>

	    			<!-- Año -->
	    			<select id="anio" class="span3">
	    				<option value="0">Año</option>
						<?php foreach ($this->reporte_model->listar_anios_ica() as $anio) { ?>
							<option value="<?php echo $anio->Anio; ?>"><?php echo $anio->Anio; ?></option>
						<?php } ?>
	    			</select>

	    			<!-- Mes -->
	    			<select id="mes" class="span4">
	    				<option value="0">Mes</option>
						<?php foreach ($this->solicitud_model->listar_meses() as $mes) { ?>
							<option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
						<?php } ?>
	    			</select>

					<!-- Clic -->
		    		<button class="btn btn-large btn-block btn-danger btn-primary" id="btn_registro_fotografico" type="button">Generar PDF</button>
	    		</div>
		    </div>
		</div>
	<?php } ?>
</div>

<div class="row-fluid">
	<!--Validar permiso-->
	<?php if (isset($acceso[75])) { ?>
		<div class="span6">
		 	<div class="box-header"><h2>Consolidado mensual de solicitudes</h2></div>
		    <div class="box-content">
				<div class="mensaje"></div>
				<div class="controls">
	    			<!-- Año -->
	    			<select id="anio_consolidado" class="span6">
	    				<option value="0">Año</option>
						<?php foreach ($this->reporte_model->listar_anios_reporte() as $anio) { ?>
							<option value="<?php echo $anio->Anio; ?>"><?php echo $anio->Anio; ?></option>
						<?php } ?>
	    			</select>

	    			<!-- Mes -->
	    			<select id="mes_consolidado" class="span6">
	    				<option value="0">Mes</option>
						<?php foreach ($this->solicitud_model->listar_meses() as $mes) { ?>
							<option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
						<?php } ?>
	    			</select>

					<!-- Clic -->
		    		<button id="btn_consolidado_solicitudes" class="btn btn-large btn-block btn-success btn-primary" type="button">Generar Excel</button>
	    		</div>
		    </div>
		</div>
	<?php } ?>

	<div class="span6">
	 	<div class="box-header"><h2>Reporte ICA semestral</h2></div>
	    <div class="box-content">
			<!--Validar permiso-->
			<?php if (isset($acceso[31])) { ?>
				<select id="select_ficha_foto" class="span12">
					<option value="">Seleccione una ficha</option>
					<?php foreach ($this->reporte_model->listar_fichas_fotos_1a() as $ficha) { ?>
						<option value="<?php echo $ficha->Pk_Id_Ficha; ?>"><?php echo $ficha->Nombre."(".$ficha->Total." fotos)"; ?></option>
					<?php } ?>
				</select>
    		<?php } ?>
	    </div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		//Solicutud ajax que trae los tramos
		$.ajax({
			url: '<?php echo site_url("ica/cargar_tramos"); ?>',
            dataType: 'JSON',
            success: function(respuesta){
                //Si trae datos
                if(respuesta.length > 0) {
                    //Se agrega un option vacio
                    $("#tramo_ica0").html('').append("<option value=''>Seleccione un tramo</option>");

                    //Se recorren los periodos
                    $.each(respuesta, function(key, val){
                        //Se agrega cada periodo al select
                        $("#tramo_ica0").append("<option value='" + val.Pk_Id_Tramo + "'>" + val.Nombre + "</option>");
                    });//Fin each
                }//Fin if
            }//Fin success
		});

		// De entrada, se pone el área, año y mes actual por defecto en el select de años para el reporte fotográfico del iCA0
		$('#area > option[value="<?php echo $this->session->userdata("Fk_Id_Area"); ?>"]').attr('selected', 'selected');
		// console.log("<?php echo $this->session->userdata('Fk_Id_Area'); ?>");
		$('#anio > option[value="<?php echo date("Y"); ?>"]').attr('selected', 'selected');
		$('#anio_consolidado > option[value="<?php echo date("Y"); ?>"]').attr('selected', 'selected');
		$('#anio_capacitacion > option[value="<?php echo date("Y"); ?>"]').attr('selected', 'selected');
		$('#mes > option[value="<?php echo str_pad(date("m") - 1, 2, 0, STR_PAD_LEFT); ?>"]').attr('selected', 'selected');
		$('#mes_consolidado > option[value="<?php echo str_pad(date("m") - 1, 2, 0, STR_PAD_LEFT); ?>"]').attr('selected', 'selected');
		$('#mes_capacitacion > option[value="<?php echo str_pad(date("m") - 1, 2, 0, STR_PAD_LEFT); ?>"]').attr('selected', 'selected');

		$("#btn_registro_fotografico").on("click", function(){
			// Si no hay alguno de los tres seleccionado
			if ($("#area").val() == 0 || $("#anio").val() == 0 || $("#mes").val() == 0) {
				// Mensaje de error
				$(".mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede generar el reporte.\n\
                Seleccione área, año y mes.</div>');
			} else {
				window.location = "reporte/registro_fotografico/" + $("#area").val() + "/" + $("#anio").val() + "/" + $("#mes").val();
			}
		});

		$("#btn_consolidado_solicitudes").on("click", function(){
			// Si no hay alguno de los dos seleccionado
			if ($("#anio_consolidado").val() == 0 || $("#mes").val() == 0) {
				// Mensaje de error
				$(".mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede generar el reporte.\n\
				Seleccione año y mes.</div>');
			} else {
				window.location = "reporte/recepcion_solicitudes/" + $("#anio_consolidado").val() + "/" + $("#mes_consolidado").val();
			}
		});

		$("#btn_capacitaciones").on("click", function(){
			// Si no hay alguno de los dos seleccionado
			if ($("#anio_capacitacion").val() == 0 || $("#mes_capacitacion").val() == 0) {
				// Mensaje de error
				$(".mensaje_capacitaciones").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede generar el reporte.\n\
				Seleccione año y mes.</div>');
			} else {
				window.location = "reporte/capacitaciones/" + $("#anio_capacitacion").val() + "/" + $("#mes_capacitacion").val() + "/"+ $("#mes_capacitacion option:selected").text();
			}// if
		});

		//Cuando se seleccione un tramo
		$("#tramo_ica0").on("change", function(){
			//Si el tramo es válido
			if ($(this).val()) {
				//Se activa el botón
				$("#btn_ica0").prop("disabled",false);

				//Se agrega el evento clic
				$("#btn_ica0").on("click", function(){
					window.location = 'reporte/ica_0/' + $("#tramo_ica0").val();
 				});
			} else {
				//Se desactiva el botón
				$("#btn_ica0").prop("disabled",true);
			}
		});//Fin change tramo iCA0

		//Cuando se seleccione una ficha
		$("#select_ficha_foto").on("change", function(){
			//Si la ficha es válida
			if ($(this).val() != "") {
				// window.location = 'reporte/ica_0/' + $("#tramo_ica0").val();
				window.open("<?php echo site_url('reporte/registro_fotografico_1a/'); ?>" + "/" + $(this).val());
			}
		});//Fin change ficha iCA0
	});//Fin document.ready
</script>

<!-- Formulario -->
<form action="">
	<div>
		<!-- Nombre de la capacitación -->
		<div class="span12">
			<label for="nombre">Nombre de la capacitación *</label>
	    	<input type="text" id="nombre" class="input-large span12" autofocus />
		</div><!-- Nombre de la capacitación -->
	</div>
	
	<div>
		<div class="span6">
			<label for="descripcion">Descripción</label>
	    	<textarea id="descripcion" class="span12" rows="4"></textarea>
		</div>
		<div class="span6">
			<div class="span12">
				<div class="span6">
					<!--Fecha de inicio-->
	                <label for="fecha_inicio">Fecha de inicio *</label>
	                <div class="input-append date form_datetime">
	                    <input type="text" id="fecha_inicio" name="fecha_inicio" class="span9" readonly>
	                    <span class="add-on"><i class="icon-remove"></i></span>
	                    <span class="add-on"><i class="icon-calendar"></i></span>
	                    <span class="fecha_inicio"></span>
	                </div>
				</div>

				<div class="span6">
					<!--Fecha de finalización-->
	                <label for="fecha_final">Fecha de finalización *</label>
	                <div class="input-append date form_datetime">
	                    <input type="text" id="fecha_final" name="fecha_final" class="span9" readonly>
	                    <span class="add-on"><i class="icon-remove"></i></span>
	                    <span class="add-on"><i class="icon-calendar"></i></span>
	                    <span class="fecha_final"></span>
	                </div>
				</div>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="span12">
			<div class="span5">
	            <label for="horas">Horas en total *</label>
		    	<input type="text" id="horas" class="input-large" />
			</div>

			<div class="span5">
	            <label for="convocados">Total convocados *</label>
		    	<input type="text" id="convocados" class="input-large" />
			</div>

			<div class="span3">
				<!--Botones-->
				<p></p>
			    <input type="submit" class="btn btn-primary btn-block" value="Guardar"/>
			</div>
		</div>
	</div>
</form><!-- Formulario -->

<legend></legend>

<!-- Tabla de capacitaciones -->
<div id="tabla_capacitaciones"></div>

<script type="text/javascript">
	//Cuando el DOM este listo
    $(document).ready(function(){
    	//Cargamos la tabla con las capacitaciones creadas
    	$("#tabla_capacitaciones").load("<?php echo site_url('hoja_vida/listar_capacitaciones'); ?>");

    	//Definición de variables
    	var descripcion = $("#descripcion");
    	var fecha_inicio = $("#fecha_inicio");
    	var fecha_final = $("#fecha_final");
    	var horas = $("#horas");
    	var nombre = $("#nombre");
    	var convocados = $("#convocados");

    	// submit
    	$("form").on("submit", function(){
    		//Se definen los datos a validar como obligatorios
    		datos_obligatorios = new Array(
				fecha_final.val(),
				fecha_final.val(),
				horas.val(),
    			nombre.val(),
    			convocados.val()
			);

			//Se ejecuta la validación
			validacion = validar_campos_vacios(datos_obligatorios);

			//Si no supera la validación
			if (!validacion) {
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede crear la capacitación.\n\
                Verifique que los campos obligatorios (*) estén llenos.</div>');
			}else{
				//Se declara un arreglo con los datos
				datos = {
					'Convocados': convocados.val(),
					'Descripcion': descripcion.val(),
					'Fecha_Inicio': fecha_inicio.val(),
					'Fecha_Final': fecha_final.val(),
					'Fk_Id_Usuario': "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>",
					'Horas': horas.val(),
					'Nombre': nombre.val()
				}; //datos

				//Enviamos los datos vía ajax para guardar
				guardar = enviar_ajax("<?php echo site_url('hoja_vida/guardar_capacitacion'); ?>", {'datos': datos});

				//Si se guarda
				if(guardar == "true"){
					//Cargamos la tabla con las capacitaciones creadas
    				$("#tabla_capacitaciones").load("<?php echo site_url('hoja_vida/listar_capacitaciones'); ?>");

					//Se muestra el mensaje de éxito
	                $(".div_mensaje").html('<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button>La capacitación se guardó correctamente.</div>');
				} // if
			}; // if

    		//Se detiene el formulario
    		return false;
    	}); // submit
    })// document.ready
</script>
<?php
//Se obtiene el id de la hoja de vida
$id_hoja_vida = $this->uri->segment(3);

// Se cargan las capacitaciones disponibles
$capacitaciones = $this->hoja_vida_model->cargar_capacitaciones();
?>
<form>
	<div class="row-fluid">
		<div class="span4">
			<label for="id_capacitacion">Capacitación *</label>
        	<select id="id_capacitacion" class="select_lateral" autofocus>
        		<option value="">Seleccione una capacitación...</option>
        		<?php foreach ($capacitaciones as $capacitacion) { ?>
        			<option value="<?php echo $capacitacion->Pk_Id_Capacitacion; ?>"><?php echo $capacitacion->Nombre; ?></option>	
        		<?php } ?>
        	</select>
		</div>

		<div class="span3">
        	<label for="fecha">Fecha *</label>
            <div class="input-append date form_datetime">
                <input type="text" id="fecha" name="fecha" class="span9" readonly>
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-calendar"></i></span>
                <span class="fecha"></span>
            </div>
		</div>

		<div class="span3">
			<label for="horas">Horas recibidas</label>
	    	<input type="text" id="horas" />
		</div>

		<div class="span2">
			<!-- Botón -->
			<br>
		    <input type="submit" class="btn btn-primary btn-block" value="Guardar"/>
		</div>
	</div>
</form>

<legend></legend>

<!-- Tabla de capacitaciones -->
<div id="tabla_capacitaciones"></div>

<script type="text/javascript">
	//Cuando el DOM este listo
    $(document).ready(function(){
    	//Definición de variables
    	var id_hoja_vida = "<?php echo $id_hoja_vida; ?>"
    	var id_capacitacion = $("#id_capacitacion");
    	var fecha = $("#fecha");
    	var horas = $("#horas");

    	//Cargamos la tabla con las capacitaciones creadas
    	$("#tabla_capacitaciones").load("<?php echo site_url('hoja_vida/listar_capacitaciones_agregadas'); ?>", {'id_hoja_vida': id_hoja_vida});
    	
    	// submit
    	$("form").on("submit", function(){
    		//Se definen los datos a validar como obligatorios
    		datos_obligatorios = new Array(
				id_capacitacion.val(),
				fecha.val(),
				horas.val()
			);

			//Se ejecuta la validación
			validacion = validar_campos_vacios(datos_obligatorios);

			//Si no supera la validación
			if (!validacion) {
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede agregar la capacitación.\n\
                Verifique que los campos obligatorios (*) estén llenos.</div>');
			}else{
				//Se declara un arreglo con los datos
				datos = {
					'Fecha': fecha.val(),
					'Fk_Id_Capacitacion': id_capacitacion.val(),
					'Fk_Id_Hoja_Vida': id_hoja_vida,
					'Fk_Id_Usuario': "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>",
					'Horas': horas.val()
				}; //datos

				//Enviamos los datos vía ajax para guardar
				guardar = enviar_ajax("<?php echo site_url('hoja_vida/guardar_capacitacion_asistencia'); ?>", {'datos': datos});

				//Si se guarda
				if(guardar == "true"){
					//Cargamos la tabla con las capacitaciones creadas
    				$("#tabla_capacitaciones").load("<?php echo site_url('hoja_vida/listar_capacitaciones_agregadas'); ?>", {'id_hoja_vida': id_hoja_vida});

					//Se muestra el mensaje de éxito
	                $(".div_mensaje").html('<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button>La capacitación se agreró correctamente.</div>');
				} // if
			}; // if

    		//Se detiene el formulario
    		return false;
    	}); // submit
    })// document.ready
</script>
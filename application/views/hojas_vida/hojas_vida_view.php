<?php
// Validar contratistas
$validar_contratistas = $this->hoja_vida_model->validar_contratistas_usuario();

// Si tiene marcado como todos los contratistas
if($validar_contratistas == 1){
	// Se cargan todos los subcontratistas
	$subcontratistas = $this->ica_model->cargar_subcontratistas();
} else {
	// Se cargan solo los subcontratistas del usuario
	$subcontratistas = $this->ica_model->cargar_subcontratistas_usuario();	
} // if

//Se cargan los días, meses y años
$dias = $this->solicitud_model->listar_dias();
$meses = $this->solicitud_model->listar_meses();
$anios = $this->solicitud_model->listar_anios();
$anios_actual = $this->solicitud_model->listar_anios_actual();

//Se toma el id de la hoja de vida cuando sea para editar
$id_hoja_vida = $this->uri->segment(3);

if ($id_hoja_vida) {
	//Se ejecuta el modelo que consulta la hoja de vida específica
	$curriculo = $this->hoja_vida_model->listado(array("id_hoja_vida" => $id_hoja_vida));
} // if
?>

<!-- Formulario -->
<form class="form-inline">
	<div class="row-fluid">
		<!-- Columna 1 -->
		<div class="span4 well">
			<!-- Tipo de información -->
			<div class="control-group">
				<div class="checkbox">
					<label>
						<?php if (isset($curriculo->Recibida) && $curriculo->Recibida == "1") { $tipo = "checked"; }else{ $tipo = ""; } ?>
						<input id="recibida" type="checkbox" <?php echo $tipo; ?> >
						Recibida por oficinas de atención (móviles y fijas)
					</label>
				</div>
				<div class="controls">
					<label class="radio span6">
						<?php if (isset($curriculo->Vinculado) && $curriculo->Vinculado == "0") { $tipo = "checked"; }elseif(!isset($curriculo->Vinculado)){ $tipo = ""; }else{ $tipo = ""; } ?>
						<input type="radio" name="tipo_hoja_vida" value="0" <?php echo $tipo; ?>> No vinculado
					</label>
				</div>

				<div class="controls">
					<label class="radio span6">
						<?php if (isset($curriculo->Vinculado) && $curriculo->Vinculado == "1") { $tipo = "checked"; }else{ $tipo = ""; } ?>
						<input type="radio" name="tipo_hoja_vida" value="1" <?php echo $tipo; ?>> Vinculado
					</label>
				</div>
				<legend></legend>
			</div><!-- Tipo de información -->

			<!-- Número de documento -->
			<div class="control-group">
				<label class="control-label" for="documento">Número de documento *</label>
				<div class="controls">
					<?php if (isset($curriculo->Documento)) { $documento = $curriculo->Documento; }else{ $documento = ""; } ?>
					<input type="text" id="documento" class="select_lateral span11" value="<?php echo $documento; ?>" />
					<span class="documento"></span>
				</div>
			</div><!-- Número de documento -->

			<!-- Nombre completo -->
			<div class="control-group">
				<label class="control-label" for="nombres">Nombre completo *</label>
				<div class="controls">
					<?php if (isset($curriculo->Nombres)) { $nombres = $curriculo->Nombres; }else{ $nombres = ""; } ?>
					<input type="text" id="nombres" class="select_lateral" value="<?php echo $nombres; ?>" />
					<span></span>
				</div>
			</div><!-- Nombre completo -->
			
			<!-- Número de teléfono -->
			<div class="control-group">
				<label class="control-label" for="telefono">Número de teléfono *</label>
				<div class="controls">
					<?php if (isset($curriculo->Telefono)) { $telefono = $curriculo->Telefono; }else{ $telefono = ""; } ?>
					<input type="text" id="telefono" class="select_lateral" value="<?php echo $telefono; ?>" />
					<span></span>
				</div>
			</div><!-- Número de teléfono -->
			
			<!-- Fecha de nacimiento -->
			<div class="control-group">
				<label class="control-label" for="dia">Fecha de nacimiento *</label>
				<div class="controls">
					<!-- Día -->
					<select id="dia" class="span3">
						<option value="">Día</option>
						<?php foreach ($dias as $dia) { ?>
							<option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
						<?php } ?>
					</select><!-- Día -->

					<!-- Mes -->
					<select id="mes" class="span5">
						<option value="">Mes</option>
						<?php foreach ($meses as $mes) { ?>
							<option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
						<?php } ?>
					</select><!-- Mes -->

					<!-- Año -->
					<select id="anio" class="span4">
						<option value="">Año</option>
						<?php foreach ($anios as $anio) { ?>
							<option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
						<?php } ?>
					</select><!-- Año -->

					<!-- Edad -->
					<div id="edad" class="select_lateral">
						<span><b>Edad: </b></span>
						<h4></h4>
					</div><!-- Edad -->
				</div>
			</div><!-- Fecha de nacimiento -->
			
			<div class="control-group">
				<div class="span6">
					<!-- Municipio -->
					<div class="control-group">
						<label class="control-label" for="municipio">Municipio *</label>
						<div class="controls">
							<select id="municipio"class="select_lateral">
								<option value="">Seleccione un municipio</option>
								<?php foreach ($municipios as $municipio) { ?>
									<option value="<?php echo $municipio->Pk_Id_Municipio; ?>"><?php echo $municipio->Nombre; ?></option>
								<?php } ?>
							</select>
						</div>
					</div><!-- Municipio -->
				</div>

				<div class="span6">
					<!-- Barrio / vereda -->
					<div class="control-group">
						<label class="control-label" for="sector">Barrio / vereda *</label>
						<div class="controls">
							<select id="sector"class="select_lateral">
								<option value="">Seleccione primero un municipio</option>
							</select>
						</div>
					</div><!-- Barrio / vereda -->
				</div>
			</div>

			<!-- Género -->
			<div class="control-group">
				<label class="control-label" for="genero">Género</label>
				<div class="controls">
					<select id="genero"class="select_lateral">
						<option value="">Seleccione</option>
						<option value="1">Masculino</option>
						<option value="2">Femenino</option>
					</select>
				</div>
			</div><!-- Género -->
		</div><!-- Columna 1 -->

		<!-- Columna 2 -->
		<div class="span4">
			<div class="well">
				<!-- Fecha de vinculación -->
				<div class="control-group">
					<label class="control-label" for="dia_vinculacion">Fecha de vinculación</label>
					<div class="controls">
						<!-- Día -->
						<select id="dia_vinculacion" class="span3">
							<option value="">Día</option>
							<?php foreach ($dias as $dia) { ?>
								<option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
							<?php } ?>
						</select><!-- Día -->

						<!-- Mes -->
						<select id="mes_vinculacion" class="span5">
							<option value="">Mes</option>
							<?php foreach ($meses as $mes) { ?>
								<option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
							<?php } ?>
						</select><!-- Mes -->

						<!-- Año -->
						<select id="anio_vinculacion" class="span4">
							<option value="">Año</option>
							<?php foreach ($anios_actual as $anio) { ?>
								<option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
							<?php } ?>
						</select><!-- Año -->
					</div>
				</div><!-- Fecha de vinculación -->
			
				<!-- Subcontratista -->
				<div class="control-group">
					<label class="control-label" for="subcontratista">Subcontratista</label>
					<div class="controls">
						<select id="subcontratista" class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($subcontratistas as $subcontratista) { ?>
								<option value="<?php echo $subcontratista->Pk_Id_Valor; ?>"><?php echo $subcontratista->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!-- Subcontratista -->

				<!--Tramo -->
				<div class="control-group">
					<label class="control-label" for="tramo">Unidad Funcional</label>
					<div class="controls">
						<select id="tramo"class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($tramos as $tramo) { ?>
								<option value="<?php echo $tramo->Pk_Id_Tramo; ?>"><?php echo $tramo->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!--Tramo -->

				<!-- Frente -->
				<div class="control-group">
					<label class="control-label" for="frente">Frente</label>
					<div class="controls">
						<select id="frente"class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($frentes as $frente) { ?>
								<option value="<?php echo $frente->Pk_Id_Frente; ?>"><?php echo $frente->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!-- Frente -->

				<!-- Nivel de estudios -->
				<div class="control-group">
					<label class="control-label" for="nivel_estudio">Nivel estudios (último completado) *</label>
					<div class="controls">
						<select id="nivel_estudio"class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($niveles_estudio as $nivel_estudio) { ?>
								<option value="<?php echo $nivel_estudio->Pk_Id_Valor; ?>"><?php echo $nivel_estudio->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!-- Nivel de estudios -->

				<!-- Profesión -->
				<div class="control-group">
					<label class="control-label" for="profesion">Profesión *</label>
					<div class="controls">
						<select id="profesion"class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($profesiones as $profesion) { ?>
								<option value="<?php echo $profesion->Pk_Id_Valor; ?>"><?php echo $profesion->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!-- Profesión -->

				<!-- Cargo / Oficio -->
				<div class="control-group">
					<label class="control-label" for="oficio">Cargo / Oficio *</label>
					<div class="controls">
						<select id="oficio"class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($oficios as $oficio) { ?>
								<option value="<?php echo $oficio->Pk_Id_Oficio; ?>"><?php echo $oficio->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!-- Cargo / Oficio -->

				<!-- Labores que ejecuta -->
				<div class="control-group">
					<label class="control-label" for="labores_ejecutadas">Labores que ejecuta</label>
					<div class="controls">
						<select id="labores_ejecutadas" class="select_lateral">
							<option value="">Seleccione...</option>
							<option value="3">Administración</option>
							<option value="1">Obra</option>
							<option value="2">Operaciones</option>
						</select>
					</div>
				</div><!-- Labores que ejecuta -->
			</div>
		</div><!-- Columna 2 -->

		<!-- Columna 3 -->
		<div class="span4">
			<!-- Dirección -->
			<div class="control-group">
				<label class="control-label" for="direccion">Dirección</label>
				<div class="controls">
					<?php if (isset($curriculo->Direccion)) { $direccion = $curriculo->Direccion; }else{ $direccion = ""; } ?>
					<input type="text" id="direccion" class="span12 select_lateral" value="<?php echo $direccion; ?>" />
				</div>
			</div><!-- Dirección -->

			<!-- Ubicación Física -->
			<div class="control-group">
				<label class="control-label" for="ubicacion_fisica">Ubicación Física</label>
				<div class="controls">
					<?php if (isset($curriculo->Ubicacion_Fisica)) { $ubicacion_fisica = $curriculo->Ubicacion_Fisica; }else{ $ubicacion_fisica = ""; } ?>
					<input type="text" id="ubicacion_fisica" class="span12 select_lateral" value="<?php echo $ubicacion_fisica; ?>" />
				</div>
			</div><!-- Ubicación Física -->

			<!-- Miembro programa ACR -->
			<div class="control-group">
				<label class="control-label" for="acr">Miembro ACR</label>
				<div class="controls">
					<select id="acr" class="select_lateral">
						<option value="0">No</option>
						<option value="1">Si</option>
					</select>
				</div>
			</div><!-- Miembro programa ACR -->

			<!-- Observación -->
			<div class="control-group">
				<label class="control-label" for="observaciones">Observaciones</label>
				<div class="controls">
					<textarea id="observaciones" class="span11" rows="16" placeholder="Observaciones" ><?php if (isset($curriculo->Observaciones)) { echo $curriculo->Observaciones; }else{ echo ""; } ?></textarea>
				</div>
			</div><!-- Observación -->
		</div><!-- Columna 3 -->
	</div>
	
	<!-- <p>
		<div class="controls">
			<label class="checkbox">
				<input id="verificada" type="checkbox"> La hoja de vida ha sido verificada y los datos especificados corresponden a la realidad, según la última fecha de modificación <span id="fecha_actualizacion"></span>.
			</label>
		</div>
	</p> -->

	<!--Validar permiso. Si existe hoja de vida y permiso de modificación -->
	<?php if ($id_hoja_vida && isset($acceso[58])) { ?>
		<!-- Si es actualización y tiene el permiso -->
		<button class="btn btn-large btn-block btn-primary" type="submit">Actualizar</button>
	<?php }elseif(!$id_hoja_vida && isset($acceso[57])){ ?>
		<!-- Si es hoja nueva y tiene acceso -->
		<button class="btn btn-large btn-block btn-primary" type="submit">Guardar</button>
	<?php } ?>
</form><!-- Formulario -->

<?php if($id_hoja_vida > 0){ ?>
	<script type="text/javascript">
		//Cuando el DOM esté listo
		$(document).ready(function(){
			//Ponemos los datos por defecto de nacimiento
	        $('#dia > option[value="<?php echo date("d", strtotime($curriculo->Fecha_Nacimiento)); ?>"]').attr('selected', 'selected');
	        $('#mes > option[value="<?php echo date("m", strtotime($curriculo->Fecha_Nacimiento)); ?>"]').attr('selected', 'selected');
	        $('#anio > option[value="<?php echo date("Y", strtotime($curriculo->Fecha_Nacimiento)); ?>"]').attr('selected', 'selected');
			
			// Si la fecha de vinculación está vacía
			if("<?php echo $curriculo->Fecha_Vinculacion; ?>" == "" || "<?php echo $curriculo->Fecha_Vinculacion; ?>" == "0000-00-00"){
	        	$('#dia_vinculacion > option[value=""]').attr('selected', 'selected');
	        	$('#mes_vinculacion > option[value=""]').attr('selected', 'selected');
	        	$('#anio_vinculacion > option[value=""]').attr('selected', 'selected');
				anio_vinculacion = "";
			} else {
	        	$('#dia_vinculacion > option[value="<?php echo date("d", strtotime($curriculo->Fecha_Vinculacion)); ?>"]').attr('selected', 'selected');
	        	$('#mes_vinculacion > option[value="<?php echo date("m", strtotime($curriculo->Fecha_Vinculacion)); ?>"]').attr('selected', 'selected');
	        	$('#anio_vinculacion > option[value="<?php echo date("Y", strtotime($curriculo->Fecha_Vinculacion)); ?>"]').attr('selected', 'selected');
			} // if

	        // Se calcula la edad
			edad = enviar_ajax("<?php echo site_url('hoja_vida/calcular_edad') ?>", {fecha: $("#dia").val() + "-" + $("#mes").val() + "-" + $("#anio").val()});

			//Se imprime la edad
			$("#edad>h4").html(edad + " años");

	        //Datos por defecto de género
	        $('#genero > option[value="<?php echo $curriculo->Id_Genero; ?>"]').attr('selected', 'selected');

	        //Datos por defecto de municipio y sector
	        $('#municipio > option[value="<?php echo $curriculo->Pk_Id_Municipio; ?>"]').attr('selected', 'selected');

	        /**
	         * Carga de sectores
	         */
	    	sectores = enviar_ajax_json("<?php echo site_url('solicitud/cargar_sectores2'); ?>", {municipio: $("#municipio").val()});

	    	//Si llegaron datos
	    	if(sectores != ""){
	    		//Se pinta un campo acío
				$("#sector").html("<option value=''>Seleccione...</option>");

				//Se recorren los municipios
				$.each(sectores, function(key, val){
		            //Se agrega cada municipio al select
		            $("#sector").append("<option value='" + val.Pk_Id_Sector + "'>" + val.Nombre + "</option>");
		        });//Fin each
	    	} else{
	    		//Se pinta un campo acío
				$("#sector").html("<option value=''>Seleccione primero un municipio</option>");
	    	} //Fin if

	        $('#sector > option[value="<?php echo $curriculo->Fk_Id_Sector; ?>"]').attr('selected', 'selected');
	        $('#tramo > option[value="<?php echo $curriculo->Fk_Id_Tramo; ?>"]').attr('selected', 'selected');
	        $('#frente > option[value="<?php echo $curriculo->Fk_Id_Frente; ?>"]').attr('selected', 'selected');
	        $('#oficio > option[value="<?php echo $curriculo->Fk_Id_Oficio; ?>"]').attr('selected', 'selected');
	        $('#labores_ejecutadas > option[value="<?php echo $curriculo->Id_Labores_Ejecutadas; ?>"]').attr('selected', 'selected');
	        $('#subcontratista > option[value="<?php echo $curriculo->Fk_Id_Valor_Contratista; ?>"]').attr('selected', 'selected');
	        $('#nivel_estudio > option[value="<?php echo $curriculo->Fk_Id_Valor_Nivel_Estudio; ?>"]').attr('selected', 'selected');
	        $('#profesion > option[value="<?php echo $curriculo->Fk_Id_Valor_Profesion; ?>"]').attr('selected', 'selected');
	        $('#acr > option[value="<?php echo $curriculo->ACR; ?>"]').attr('selected', 'selected');

	        if("<?php echo $curriculo->Verificado; ?>" == "1"){$("#verificada").prop('checked', true);}
		});
	</script>
<?php } ?>

<script type="text/javascript">
	//Cuando el DOM esté listo
	$(document).ready(function(){
		//Recolección de datos
		var id_hoja_vida = "<?php echo $id_hoja_vida; ?>";
		var anio = $("#anio");
		var anio_vinculacion = $("#anio_vinculacion");
		var dia = $("#dia");
		var dia_vinculacion = $("#dia_vinculacion");
		// var documento = $("#documento");
		var direccion = $("#direccion");
		var fecha_nacimiento = null;
		var fecha_vinculacion = null;
		var frente = $("#frente");
		var nivel_estudio = $("#nivel_estudio");
		var profesion = $("#profesion");
		var genero = $("#genero");
		var labores_ejecutadas = $("#labores_ejecutadas");
		var mes = $("#mes");
		var mes_vinculacion = $("#mes_vinculacion");
		var municipio = $("#municipio");
		var nombres = $("#nombres");
		var observaciones = $("#observaciones");
		var oficio = $("#oficio");
		var sector = $("#sector");
		var subcontratista = $("#subcontratista");
		var telefono = $("#telefono");
		var tipo_hoja_vida = $("#tipo_hoja_vida");
		var tramo = $("#tramo");
		var ubicacion_fisica = $("#ubicacion_fisica");
		var acr = $("#acr");
		var documento_existe = false

		// Campos bloqueados
    	var documento = $("#documento").numericInput({
            allowFloat: false,
            allowNegative: false
        }); // numeric input;

		/**
		 * Validación del documento de identidad
		 */
		documento.on("keyup", function(){
			//Variable de exito
			exito = false;

			//Se ejecuta la validación del documento
			validar_documento = enviar_ajax("<?php echo site_url('hoja_vida/validar_documento'); ?>", {documento: documento.val()});
			
			if ($.trim(documento.val()) == "") {
				//No sigue
				$(".documento").removeClass("exito");
                $(".documento").addClass("error");
                $(".documento").html('<i class="icon-remove-sign"></i> <br>El número de documento no puede estar vacío.');
			} else if(validar_documento){
				documento_existe = true;
				//No sigue
				$(".documento").removeClass("exito");
                $(".documento").addClass("error");
                $(".documento").html('<i class="icon-remove-sign"></i> <br>El número de documento ya se encuentra resgistrado en la base de datos.');
                exito = false;
			} else {
				//Ok
				$(".documento").removeClass("error");
                $(".documento").html('<i class="icon-ok-sign"></i><br>');
			}
		});//Fin documento change

		//Se toma las fechas
		fecha_nacimiento = anio.val() + "-" + mes.val() + "-" + dia.val();

		/**
         * Cálculo de la fecha de nacimiento
         */
        $("#dia, #mes, #anio").on("change", function(){
        	//Si se seleccionaron los tres datos, se declara la fecha
        	if(dia.val() !="" && mes.val() !="" && anio.val() !=""){
        		//Se toma la fecha
				fecha_nacimiento = anio.val() + "-" + mes.val() + "-" + dia.val();

				//Se calcula la edad
				edad = enviar_ajax("<?php echo site_url('hoja_vida/calcular_edad') ?>", {fecha: dia.val() + "-" + mes.val() + "-" + anio.val()})

				//Se imprime la edad
				$("#edad>h4").html(edad + " años");
        	} else {
    			//Se resetea nuevamente la fecha
        		fecha_nacimiento = null;
        		$("#edad>h4").html("");
        	} // if
        }); // Change fecha nacimiento

        /**
		 * Cuando se seleccione un municipio
		 */
        municipio.on("change", function(){
        	//Petición ajax
        	sectores = enviar_ajax_json("<?php echo site_url('solicitud/cargar_sectores2'); ?>", {municipio: municipio.val()});

        	//Si llegaron datos
        	if(sectores != ""){
        		//Se pinta un campo acío
				sector.html("<option value=''>Seleccione...</option>");

				//Se recorren los municipios
				$.each(sectores, function(key, val){
		            //Se agrega cada municipio al select
		            sector.append("<option value='" + val.Pk_Id_Sector + "'>" + val.Nombre + "</option>");
		        });//Fin each
        	} else{
        		//Se pinta un campo acío
				sector.html("<option value=''>Seleccione primero un municipio</option>");
        	} //Fin if
        });//Fin change municipio
		
		//Submit
		$("form").on("submit", function(){
			// Se quita cualquier mensaje de error
			$(".div_mensaje").html("");

			//Se recoge el valor del tipo seleccionado
			var tipo_hoja_vida = $('input:radio[name=tipo_hoja_vida]:checked');
			
			// Si no ha seleccionado si está o no vinculado
			if(!tipo_hoja_vida.val()){
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Especifique si está o no vinculado.</div>');
                return false;
			} // if

			// Fecha de vinculación
			var fecha_vinculacion = anio_vinculacion.val() + "-" + mes_vinculacion.val() + "-" + dia_vinculacion.val();

			//Si se seleccionaron los tres datos, se declara la fecha
        	if(dia_vinculacion.val() !="" && mes_vinculacion.val() !="" && anio_vinculacion.val() !=""){
        		fecha_vinculacion = anio_vinculacion.val() + "-" + mes_vinculacion.val() + "-" + dia_vinculacion.val();
        	}else{
        		fecha_vinculacion = null;
        	} // if
			
			recibida = "0";
			verificada = "0";
			
			//Valor de hoja de vida verificada y recibida
			if($("#recibida").is(':checked')){recibida = "1";}
			if($("#verificada").is(':checked')){verificada = "1";}

			// Si la cédula ya existe en base de datos
			if(documento_existe){
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Este documento ya existe.</div>');
                return false;
			} // if

			//Se recogen los datos a validar
			campos_obligatorios = new Array(
				documento.val(),
				nombres.val(),
				telefono.val(),
				fecha_nacimiento,
				genero.val(),
				sector.val()
			);

			// Si es vinculado
			if(tipo_hoja_vida.val() == "1"){
				// Se agrega la fecha de vinculación para la validación de obligatorios
				campos_obligatorios.push(fecha_vinculacion);
				campos_obligatorios.push(subcontratista.val());
				campos_obligatorios.push(nivel_estudio.val());
				campos_obligatorios.push(profesion.val());
				campos_obligatorios.push(oficio.val());
				campos_obligatorios.push(labores_ejecutadas.val());
				campos_obligatorios.push(tramo.val());
				campos_obligatorios.push(frente.val());
			}
			// console.log(campos_obligatorios);

			if(!validar_campos_vacios(campos_obligatorios)){
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede guardar la hoja de vida.\n\
                Verifique que los campos obligatorios (marcados con *) estén llenos.</div>');
			} else {
				//Se recogen los datos
				datos = {
					"Contratado": tipo_hoja_vida.val(),
					"Direccion": direccion.val(),
					"Documento": documento.val(),
					"Fecha_Nacimiento": fecha_nacimiento,
					"Fecha_Vinculacion": fecha_vinculacion,
					"Fk_Id_Frente": frente.val(),
					"Fk_Id_Oficio": oficio.val(),
					"Fk_Id_Sector": sector.val(),
					"Fk_Id_Tramo": tramo.val(),
					"Fk_Id_Valor_Contratista": subcontratista.val(),
					"Fk_Id_Valor_Nivel_Estudio": nivel_estudio.val(),
					"Fk_Id_Valor_Profesion": profesion.val(),
					"Id_Genero": genero.val(),
					"Id_Labores_Ejecutadas": labores_ejecutadas.val(),
					"Nombres": nombres.val(),
					"Observaciones": observaciones.val(),
					"Recibida": recibida,
					"Telefono": telefono.val(),
					"ACR": acr.val(),
					"Ubicacion_Fisica": ubicacion_fisica.val(),
					"Verificada": verificada
				}//datos

				// Si es no vinculado
				if (tipo_hoja_vida.val() == "0") {
					// Se elimina el contratista
					datos["Fk_Id_Valor_Contratista"] = null;
				}
				// console.log(datos);

				//Depende del caso, se guarda o se actualiza
				if (id_hoja_vida > 0) {
					console.log("Actualizando...");

					// Agregar datos adicionales
					datos.Fecha_Actualizacion = "<?php echo date('Y-m-d', time()); ?>";

					//Para actualizar ejecutaremos una funcion JS que envía datos con ajax
					actualizar = enviar_ajax("<?php echo site_url('hoja_vida/actualizar'); ?>", {'datos': datos, 'id_hoja_vida': id_hoja_vida});

					//Variable de mensaje
					mensaje = "La hoja de vida se actualizó correctamente.";
				} else {
					console.log("Guardando...");
					
					// Agregar datos adicionales
					datos.Fk_Id_Usuario = "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>";

					// Si es recibida
					if (recibida == "1") {
						datos.Fecha_Recepcion = "<?php echo date('Y-m-d', time()); ?>";
					} // if

					//Para guardar ejecutaremos una funcion JS que envía datos con ajax
					guardar = enviar_ajax("<?php echo site_url('hoja_vida/guardar'); ?>", {'datos': datos});

					//Variable de mensaje
					mensaje = "La hoja de vida se guardó correctamente.";

					//Se limpia el formulario
					limpiar(".form-inline");
				};

				//Se muestra el mensaje de exito
            	$(".div_mensaje").html('<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button>' + mensaje + '</div>');

				//Se resetea la edad
				$("#edad>h4").html("");
			}

			return false;
		});//Fin submit
	});//Fin document.ready
</script>
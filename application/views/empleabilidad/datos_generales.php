<?php
//Se cargan los días, meses y años
$dias = $this->solicitud_model->listar_dias();
$meses = $this->solicitud_model->listar_meses();
$anios = $this->solicitud_model->listar_anios();
$anios_actual = $this->solicitud_model->listar_anios_actual();

$municipios= $this->solicitud_model->cargar_municipios();
$niveles_estudio = $this->hoja_vida_model->cargar_niveles_estudio();
$profesiones = $this->hoja_vida_model->cargar_profesiones();
?>

<!-- Formulario -->
<form class="form-inline">
	<div class="row-fluid">
		<div class="span12">
			<strong style="font-size: 0.8em">Si su lugar de residencia o profesión no apareece dentro de las opciones, por favor especifíquela dentro de la descripción del perfil</strong>
		</div>
		</div>
	<div class="row-fluid">
		<div class="span4 well">
			<!-- Número de documento -->
			<div class="control-group">
				<label class="control-label" for="documento">Número de documento *</label>
				<div class="controls">
					<?php if (isset($curriculo->Documento)) { $documento = $curriculo->Documento; }else{ $documento = ""; } ?>
					<input type="text" id="documento" class="select_lateral span11" value="<?php echo $documento; ?>" autofocus/>
					<span class="documento"></span>
				</div>
			</div><!-- Número de documento -->

			<!-- Nombres -->
			<div class="control-group">
				<label class="control-label" for="nombres">Nombres y apellidos *</label>
				<div class="controls">
					<?php if (isset($curriculo->Nombres)) { $nombres = $curriculo->Nombres; }else{ $nombres = ""; } ?>
					<input type="text" id="nombres" class="select_lateral" value="<?php echo $nombres; ?>" />
					<span></span>
				</div>
			</div><!-- Nombres -->

			<!-- Número de teléfono -->
			<div class="control-group">
				<label class="control-label" for="telefono">Número de teléfono *</label>
				<div class="controls">
					<?php if (isset($curriculo->Telefono)) { $telefono = $curriculo->Telefono; }else{ $telefono = ""; } ?>
					<input type="text" id="telefono" class="select_lateral" value="<?php echo $telefono; ?>" />
					<span></span>
				</div>
			</div><!-- Número de teléfono -->
		</div>

		<div class="span4 well">
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

				<!-- Nivel de estudios -->
				<div class="control-group">
					<label class="control-label" for="nivel_estudio">Estudios (último completado) *</label>
					<div class="controls">
						<select id="nivel_estudio"class="select_lateral">
							<option value="">Seleccione...</option>
							<?php foreach ($niveles_estudio as $nivel_estudio) { ?>
								<option value="<?php echo $nivel_estudio->Pk_Id_Valor; ?>"><?php echo $nivel_estudio->Nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div><!-- Nivel de estudios -->
			</div>
		</div>

		<div class="span4 well">
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

				<!-- Género -->
				<div class="control-group">
					<label class="control-label" for="genero">Género *</label>
					<div class="controls">
						<select id="genero"class="select_lateral">
							<option value="">Seleccione</option>
							<option value="2">Femenino</option>
							<option value="1">Masculino</option>
						</select>
					</div>
				</div><!-- Género -->

				<!-- Dirección -->
				<div class="control-group">
					<label class="control-label" for="direccion">Dirección</label>
					<div class="controls">
						<?php if (isset($curriculo->Direccion)) { $direccion = $curriculo->Direccion; }else{ $direccion = ""; } ?>
						<input type="text" id="direccion" class="span12 select_lateral" value="<?php echo $direccion; ?>" />
					</div>
				</div><!-- Dirección -->

				
		</div>
	</div>

	<!-- Descripción -->
				<div class="control-group">
					<label class="control-label" for="observaciones">Describa brevemente su perfil (Qué hace, profesión, lugar de residencia y experiencia, si la tiene) *</label>
					<div class="controls">
						<textarea id="observaciones" class="span12" rows="3" ><?php if (isset($curriculo->Observaciones)) { echo $curriculo->Observaciones; }else{ echo ""; } ?></textarea>
					</div>
				</div><!-- Descripción -->

	<p>
		<button class="btn btn-large btn-block btn-primary" type="submit">Siguiente</button>
	</p>
</form>

<script type="text/javascript">
	//Cuando el DOM esté listo
	$(document).ready(function(){
		var anio = $("#anio");
		var dia = $("#dia");
		var direccion = $("#direccion");
		var fecha_nacimiento = null;
		var nivel_estudio = $("#nivel_estudio");
		var profesion = $("#profesion");
		var genero = $("#genero");
		var mes = $("#mes");
		var municipio = $("#municipio");
		var nombres = $("#nombres");
		var observaciones = $("#observaciones");
		var sector = $("#sector");
		var telefono = $("#telefono");
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
			validar_documento = enviar_ajax("<?php echo site_url('empleabilidad/validar_documento'); ?>", {documento: documento.val()});
			
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

        /**
		 * Cuando se seleccione un municipio
		 */
        municipio.on("change", function(){
        	//Petición ajax
        	sectores = enviar_ajax_json("<?php echo site_url('empleabilidad/cargar_sectores'); ?>", {municipio: municipio.val()});

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

			//Se toma las fechas
			fecha_nacimiento = anio.val() + "-" + mes.val() + "-" + dia.val();
			
			// Si la cédula ya existe en base de datos
			if(documento_existe){
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Este número de documento ya existe. Por favor envíenos un correo a info@vinus.com.co para actualizar su hoja de vida</div>');

                return false;
			}

			//Se recogen los datos a validar
			campos_obligatorios = new Array(
				documento.val(),
				nombres.val(),
				telefono.val(),
				fecha_nacimiento,
				genero.val(),
				sector.val(),
				nivel_estudio.val(),
				profesion.val(),
				observaciones.val()
			);

			if(!validar_campos_vacios(campos_obligatorios)){
				//Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aún no podemos guardar sus datos.\n\
                Verifique que los campos obligatorios (marcados con *) estén diligenciados.</div>');

                return false;
			} // if

			//Se recogen los datos
			datos = {
				"Contratado": 0,
				"Direccion": direccion.val().toUpperCase(),
				"Documento": documento.val(),
				"Fecha_Nacimiento": fecha_nacimiento,
				"Fk_Id_Sector": sector.val(),
				"Fk_Id_Valor_Nivel_Estudio": nivel_estudio.val(),
				"Fk_Id_Valor_Profesion": profesion.val(),
				"Id_Genero": genero.val(),
				"Nombres": nombres.val().toUpperCase(),
				"Observaciones": observaciones.val().toUpperCase(),
				"Recibida": 0,
				"Telefono": telefono.val(),
				"Fk_Id_Usuario": 33,
				"Fecha_Recepcion": "<?php echo date('Y-m-d', time()); ?>"
			}//datos

			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			id = enviar_ajax("<?php echo site_url('empleabilidad/guardar'); ?>", {'datos': datos});

			// Si guardó correctamente
			if (id) {
				// Se envía el email informando de la subida de la hoja de vida
				

				// Se redirecciona a la subida del archivo
				location.href = "empleabilidad/archivo" + "/" + id;
			} // if

			return false;
		});//Fin submit
	});//Fin document.ready
</script>
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
					<label class="control-label" for="genero">Género</label>
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
					<label class="control-label" for="observaciones">Describa brevemente su perfil *</label>
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
				// $("#edad>h4").html(edad + " años");
        	} else {
    			//Se resetea nuevamente la fecha
        		fecha_nacimiento = null;
        		// $("#edad>h4").html("");
        	} // if
        }); // Change fecha nacimiento

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

				

			return false;
		});//Fin submit
	});//Fin document.ready
</script>
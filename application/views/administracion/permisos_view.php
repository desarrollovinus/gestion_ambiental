<div id="mensajes"></div>
<legend></legend>
<?php 
//Se consultan los permisos del usuario
$permisos = $this->permisos_model->cargar_permisos($id_usuario);

// echo "id_usuario: " . $id_usuario."\n". "permisos: ";
$acciones = array();

foreach ($permisos as $permiso) {
	array_push($acciones, $permiso->Fk_Id_Accion);
}
?>
<div id="div_permisos">
	<div class="row-fluid">
		<!-- Módulo de inicio -->
		<div class="span3">
			<div class="well">
				<center><h4>Inicio</h4></center>

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#inicio1" data-toggle="tab">Acciones</a></li>
						<li><a href="#inicio2" data-toggle="tab">Reportes</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="inicio1">
							<!-- Indicador de solicitudes -->
							<label class="checkbox">
								<?php if(in_array("1", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="1" <?php echo $check; ?> > Indicador de solicitudes
							</label>

							<!-- Indicador de anexos ICA -->
							<label class="checkbox">
								<?php if(in_array("2", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="2" <?php echo $check; ?> > Indicador de anexos ICA
							</label>

							<br>
						</div>
						<div class="tab-pane" id="inicio2">
							<p>No hay reportes.</p>
						</div>
					</div>
				</div>
			</div>
		</div><!-- Módulo de inicio -->	

		<!-- Módulo de solicitudes -->
		<div class="span3">
			<div class="well">
				<center><h4>Solicitudes</h4></center>

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#solicitud1" data-toggle="tab">Acciones</a></li>
						<li><a href="#solicitud2" data-toggle="tab">Reportes</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="solicitud1">
							<!-- Crear solicitudes -->
							<label class="checkbox">
								<?php if(in_array("17", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="17" <?php echo $check; ?> > Crear solicitudes
							</label>
							
							<!-- Modificar solicitudes -->
							<label class="checkbox">
								<?php if(in_array("38", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="38" <?php echo $check; ?> > Modificar solicitudes
							</label>

							<!-- Ver solicitudes -->
							<label class="checkbox">
								<?php if(in_array("18", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="18" <?php echo $check; ?> > Ver solicitudes
							</label>
						</div>
						<div class="tab-pane" id="solicitud2">
							<!-- Plantilla de solicitudes comunitarias -->
							<label class="checkbox">
								<?php if(in_array("28", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="28" <?php echo $check; ?> > Plantilla de solicitudes comunitarias
							</label>

							<!-- Reporte de solicitudes comunitarias individual -->
							<label class="checkbox">
								<?php if(in_array("37", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="37" <?php echo $check; ?> > Reporte de solicitudes comunitarias individual
							</label>

							<!-- Consolidado mensual de solicitudes -->
							<label class="checkbox">
								<?php if(in_array("29", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="29" <?php echo $check; ?> > Consolidado mensual de solicitudes
							</label>
						</div>
					</div>
				</div>
			</div>
		</div><!-- Módulo de solicitudes -->

		<!-- Módulo ICA -->
		<div class="span6">
			<div class="well">
				<center><h4>ICA</h4></center>

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#ica1" data-toggle="tab">Acciones</a></li>
						<li><a href="#ica2" data-toggle="tab">Reportes</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="ica1">
							<div class="span3">
								<!-- ICA 0 -->
								<label class="checkbox">
									<?php if(in_array("20", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="20" <?php echo $check; ?> > ICA 0
								</label>

								<!-- ICA 1a -->
								<label class="checkbox">
									<?php if(in_array("21", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="21" <?php echo $check; ?> > ICA 1a
								</label>

								<label class="checkbox">
									<!-- ICA 2a -->
									<?php if(in_array("22", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="22" <?php echo $check; ?> > ICA 2a
								</label>
							</div>

							<div class="span3">
								<!-- ICA 2b -->
								<label class="checkbox">
									<?php if(in_array("23", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="23" <?php echo $check; ?> > ICA 2b
								</label>
								
								<!-- ICA 2c -->
								<label class="checkbox">
									<?php if(in_array("24", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="24" <?php echo $check; ?> > ICA 2c
								</label>

								<!-- ICA 2d -->
								<label class="checkbox">
									<?php if(in_array("25", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="25" <?php echo $check; ?> > ICA 2d
								</label>
							</div>

							<div class="span3">
								<!-- ICA 2e -->
								<label class="checkbox">
									<?php if(in_array("40", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="40" <?php echo $check; ?> > ICA 2e
								</label>

								<!-- ICA 2f -->
								<label class="checkbox">
									<?php if(in_array("42", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="42" <?php echo $check; ?> > ICA 2f
								</label>

								<!-- ICA 2g -->
								<label class="checkbox">
									<?php if(in_array("44", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="44" <?php echo $check; ?> > ICA 2g
								</label>
							</div>

							<div class="span3">
								<!-- ICA 2h -->
								<label class="checkbox">
									<?php if(in_array("46", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="46" <?php echo $check; ?> > ICA 2h
								</label>

								<!-- ICA 3a -->
								<label class="checkbox">
									<?php if(in_array("50", $acciones)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="permiso[]" value="50" <?php echo $check; ?> > ICA 3a
								</label>
							</div>
						</div>
						<div class="tab-pane" id="ica2">
							<!-- ICA 0 - Versiones -->
							<label class="checkbox">
								<?php if(in_array("30", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="30" <?php echo $check; ?> > ICA 0 - Versiones
							</label>

							<!-- ICA 1a - Informe de metas -->
							<label class="checkbox">
								<?php if(in_array("32", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="32" <?php echo $check; ?> > ICA 1a - Informe de metas
							</label>

							<!-- ICA 1a - Registro fotográfico mensual -->
							<label class="checkbox">
								<?php if(in_array("31", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="31" <?php echo $check; ?> > ICA 1a - Registro fotográfico mensual
							</label>

							<!-- ICA 2a - Estado del permiso de vertimientos -->
							<label class="checkbox">
								<?php if(in_array("33", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="33" <?php echo $check; ?> > ICA 2a - Estado del permiso de vertimientos
							</label>

							<!-- ICA 2b - Estado del permiso, autorización, concesión o licencia -->
							<label class="checkbox">
								<?php if(in_array("34", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="34" <?php echo $check; ?> > ICA 2b - Estado del permiso, autorización, concesión o licencia
							</label>

							<!-- ICA 2c - Estado del permiso de aprovechamiento forestal -->
							<label class="checkbox">
								<?php if(in_array("35", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="35" <?php echo $check; ?> > ICA 2c - Estado del permiso de aprovechamiento forestal
							</label>

							<!-- ICA 2d - Estado del permiso de ocupación de cauces -->
							<label class="checkbox">
								<?php if(in_array("36", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="36" <?php echo $check; ?> > ICA 2d - Estado del permiso de ocupación de cauces
							</label>

							<!-- ICA 2e - Estado del permiso de emisiones atmosféricas -->
							<label class="checkbox">
								<?php if(in_array("41", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="41" <?php echo $check; ?> > ICA 2e - Etado del permiso de emisiones atmosféricas
							</label>

							<!-- ICA 2f - Estado del permiso, concesión o licencia de explotación de canteras -->
							<label class="checkbox">
								<?php if(in_array("43", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="43" <?php echo $check; ?> > ICA 2f - Estado del permiso, concesión o licencia de explotación de canteras
							</label>

							<!-- ICA 2g - Estado de manejo de residuos sólidos -->
							<label class="checkbox">
								<?php if(in_array("45", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="45" <?php echo $check; ?> > ICA 2g - Estado de manejo de residuos sólidos
							</label>

							<!-- ICA 2h - Estado del permiso, concesión o licencia de zonas de depósito -->
							<label class="checkbox">
								<?php if(in_array("47", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="47" <?php echo $check; ?> > ICA 2h - Estado del permiso, concesión o licencia de zonas de depósito
							</label>

							<!-- ICA 3a - Estado de cumplimiento de los requerimientos de los actos administrativos -->
							<label class="checkbox">
								<?php if(in_array("51", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="51" <?php echo $check; ?> > ICA 3a - Estado de cumplimiento de los requerimientos de los actos administrativos
							</label>
						</div>
					</div>
				</div>
			</div>
		</div><!-- Módulo ICA -->
	</div>

	<div class="row-fluid">
		<!-- Módulo de hojas de vida-->
		<div class="span5">
			<div class="well">
				<center><h4>Hojas de vida</h4></center>

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#hojas1" data-toggle="tab">Acciones</a></li>
						<li><a href="#hojas2" data-toggle="tab">Reportes</a></li>
						<li><a href="#hojas3" data-toggle="tab">Contratistas</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="hojas1">
							<!-- Crear hojas de vida -->
							<label class="checkbox">
								<?php if(in_array("57", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="57" <?php echo $check; ?> > Crear hojas de vida
							</label>

							<!-- Modificar hojas de vida -->
							<label class="checkbox">
								<?php if(in_array("58", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="58" <?php echo $check; ?> > Modificar hojas de vida
							</label>

							<!-- Consultar hojas de vida -->
							<label class="checkbox">
								<?php if(in_array("59", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="59" <?php echo $check; ?> > Consultar hojas de vida
							</label>

							<!-- Subir hojas de vida -->
							<label class="checkbox">
								<?php if(in_array("60", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="60" <?php echo $check; ?> > Subir hojas de vida
							</label>

							<!-- Ver hojas de vida subidas -->
							<label class="checkbox">
								<?php if(in_array("61", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="61" <?php echo $check; ?> > Ver hojas de vida subidas
							</label>

							<!-- Eliminar hojas de vida subidas -->
							<label class="checkbox">
								<?php if(in_array("62", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="62" <?php echo $check; ?> > Eliminar hojas de vida subidas
							</label>

							<!-- Crear capacitaciones -->
							<label class="checkbox">
								<?php if(in_array("67", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="67" <?php echo $check; ?> > Crear capacitaciones
							</label>

							<!-- Agregar capacitaciones -->
							<label class="checkbox">
								<?php if(in_array("68", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="68" <?php echo $check; ?> > Agregar capacitaciones
							</label>

							<!-- Reporte semanal -->
							<label class="checkbox">
								<?php if(in_array("63", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="63" <?php echo $check; ?> > Generar Reporte semanal
							</label>
						</div>
						<div class="tab-pane" id="hojas2">
							<!-- Reporte de hojas de vida recibidas-->
							<label class="checkbox">
								<?php if(in_array("66", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="66" <?php echo $check; ?> > Reporte de hojas de vida recibidas
							</label>

							<!-- Reporte de hojas de vida vinculados -->
							<label class="checkbox">
								<?php if(in_array("64", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="64" <?php echo $check; ?> > Reporte de hojas de vida de los vinculados
							</label>

							<!-- Consolidado mensual de las hojas de vida -->
							<label class="checkbox">
								<?php if(in_array("75", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="75" <?php echo $check; ?> > Consolidado mensual de las hojas de vida
							</label>

							<!-- Informe mensual de capacitaciones -->
							<label class="checkbox">
								<?php if(in_array("76", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="76" <?php echo $check; ?> > Informe mensual de capacitaciones
							</label>
						</div>

						<div class="tab-pane" id="hojas3">
							<?php 
							//Se consultan los contratistas a los que accede el usuario
							$contratistas = $this->permisos_model->cargar_contratistas_usuario($id_usuario);

							// echo "id_usuario: " . $id_usuario."\n". "permisos: ";
							$contratistas_ = array();

							foreach ($contratistas as $contratista_) {
								array_push($contratistas_, $contratista_->Fk_Id_Valor_Contratista);
							} // foreach
							?>

							<!-- Todos los subcontratistas -->
							<label class="checkbox">
								<?php if(in_array("0", $contratistas_)) {$check = "checked"; $activo="disabled";} else {$check = "";$activo="";} ?>
								<input type="checkbox" id="todos_contratistas" value="0" <?php echo $check; ?>> <b>Todos</b>
							</label>
							
							<?php foreach ($this->ica_model->cargar_subcontratistas() as $subcontratista) { ?>
								<!-- Subcontratista -->
								<label class="checkbox">
									<?php if(in_array($subcontratista->Pk_Id_Valor, $contratistas_)) {$check = "checked";} else {$check = "";} ?>
									<input type="checkbox" name="contratista" value="<?php echo $subcontratista->Pk_Id_Valor; ?>" <?php echo $check." ".$activo; ?>>  <?php echo $subcontratista->Nombre; ?>
								</label>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Módulo SISO -->
		<div class="span4">
			<div class="well">
				<center><h4>SISO</h4></center>

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#siso1" data-toggle="tab">Acciones</a></li>
						<li><a href="#siso2" data-toggle="tab">Reportes</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="siso1">
							<!-- Agregar inspección de maquinaria -->
							<label class="checkbox">
								<?php if(in_array("69", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="69" <?php echo $check; ?> > Agregar inspección de maquinaria
							</label>

							<!-- Consultar inspección de maquinaria -->
							<label class="checkbox">
								<?php if(in_array("71", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="71" <?php echo $check; ?> > Consultar inspección de maquinaria
							</label>

							<!-- Agregar inspección de equipos -->
							<label class="checkbox">
								<?php if(in_array("70", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="70" <?php echo $check; ?> > Agregar inspección de equipos
							</label>
						</div>
						<div class="tab-pane" id="siso2">
							<label class="checkbox">
								<?php if(in_array("72", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="72" <?php echo $check; ?> > Inspección de maquinaria
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Módulo Administrativo -->
		<div class="span3">
			<div class="well">
				<center><h4>Administración</h4></center>

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#admin1" data-toggle="tab">Acciones</a></li>
						<li><a href="#admin2" data-toggle="tab">Reportes</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="admin1">
							<!-- Ver logs de auditoría -->
							<label class="checkbox">
								<?php if(in_array("26", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="26" <?php echo $check; ?> > Ver logs de auditoría
							</label>

							<!-- Asignar permisos -->
							<label class="checkbox">
								<?php if(in_array("27", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="27" <?php echo $check; ?> > Asignar permisos
							</label>

							<!-- Crear usuarios -->
							<label class="checkbox">
								<?php if(in_array("7", $acciones)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" name="permiso[]" value="7" <?php echo $check; ?> > Crear usuarios
							</label>
						</div>
						<div class="tab-pane" id="admin2">
							<p>No hay reportes.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<button class="btn btn-large btn-block btn-primary btn-success" type="button">Guardar permisos</button>

<script type="text/javascript">
    //Cuando el DOM este listo 
    $(document).ready(function(){
    	$("#usuario").on("change", function(){
    		if($(this).val() != ""){
    			$("#div_permisos").slideDown('slow');
    		} else {
				$("#div_permisos").slideUp('slow');
    		}
    	});

        //Botón
        $("button").on("click", function(){
        	//Arreglo y otras variables
        	var permisos = new Array();
    		var contratistas = new Array();
        	var id_usuario = $("#usuario").val();

        	// Si el check de todos los contratistas está activo
        	if ($("#todos_contratistas").is(':checked')){
        		console.log("check")
        		// El arreglo solo tendrá cero
        		contratistas.push("0")
        	} else {
        		//Se recorren los chequeados
	        	$("input[name='contratista']:checked").each(function() {
		            //Se agrega el check al arreglo
		            contratistas.push($(this).val());
		        });//each
        	} // if

        	//Se recorren los chequeados
        	$("input[name='permiso[]']:checked").each(function() {
	            //Se agrega el check al arreglo
	            permisos.push($(this).val());
	        });//each

	        enviar_ajax("<?php echo site_url('administracion/actualizar_permisos'); ?>", {"datos": permisos,"contratistas": contratistas, id_usuario: id_usuario});

	        //Se muestra el mensaje
	        $("#mensajes").html('<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button>Se han guardado los permisos correctamente</div>');
        });//Button click

        // Al dar clic en todos los contratistas
        $("#todos_contratistas").on("click", function(){
        	// Si está chequeado
	        if ($(this).is(':checked')){
	            // Se desactivan y quitan los inputs
	            $("input[name^='contratista']").attr("disabled", true);
	            $("input[name^='contratista']").prop('checked', false);
	        }else{
	            // Se activan los inputs
	            $("input[name^='contratista']").removeAttr("disabled");
	        } // if
        }); // clic todos contratistas
    });//Document.ready
</script>
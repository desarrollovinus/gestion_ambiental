<?php
//Arreglo de permisos
$acceso = $this->session->userdata('Acceso');

/*<!--Validar permiso-->*/
if (!isset($acceso[50])) { ?>
	<div class="hero-unit">
		<h1>Acceso denegado</h1>
		<p>Usted no cuenta con permisos para trabajar el ICA 3a. Si necesita usar este formato, por favor comuníquese con el área de Sistemas para que le sean asignados los permisos correspondientes. </p>
	</div>
<?php } else { ?>
	<!--La fecha debe ir sobre el modal-->
	<style>.datepicker{z-index: 1151;}</style>

	<!-- **************************************************** Modal 1 ***************************************************** -->
	<a href="#modal_1" role="button" class="btn btn-large btn-block btn-primary btn-alert" data-toggle="modal">Agregar requerimiento</a>
	<div id="modal_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Nuevo requerimiento</h3>
		</div>

		<div class="modal-body">
			<form class="form-horizontal">
				<!--1-->
				<div class="control-group">
					<label class="control-label" for="requerimiento">Requerimiento</label>
					<div class="controls">
						<textarea id="requerimiento" class="span12" rows="3"></textarea>
					</div>
				</div>

				<!-- 2 -->
				<div class="control-group">
					<label class="control-label" for="cumplimiento">Cumplimiento</label>
					<div class="controls">
						<select id="cumplimiento" class="span6">
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>

						<input type="text" id="cumplimiento_parcial" class="span6" placeholder="Parcial %">	
					</div>
				</div>

				<!-- 3 -->
				<div class="control-group">
					<label class="control-label" for="fecha_inicio">Fechas</label>
					<div class="controls">
						<div class="row-fluid">
							<div class="span6">
								<div class="input-append date"  id="fecha_inicio" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
						  			<input class="span12" size="16" type="text" placeholder="Fecha inicial" disabled/>
						  			<span class="add-on"><i class="icon-th"></i></span>
						  		</div>
							</div>

							<div class="span6">
								<div class="input-append date"  id="fecha_final" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
						  			<input class="span12" size="16" type="text" placeholder="Fecha final" disabled/>
						  			<span class="add-on"><i class="icon-th"></i></span>
						  		</div>
							</div>
						</div>
					</div>
				</div>

				<!-- 4 -->
				<div class="control-group">
					<label class="control-label" for="observaciones">Observaciones</label>
					<div class="controls">
						<textarea id="observaciones" class="span12" rows="3"></textarea>
					</div>
				</div>
			</form>
		</div>

		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="btn_guardar1" class="btn btn-primary">Guardar</button>
		</div>
	</div><br>
	<legend></legend>


	<!--Validar permiso-->
	<?php if (isset($acceso[51])) { ?>	
		<!-- **************************************************** Reporte ***************************************************** -->
		<a href="#" id="reporte_3a" role="button" class="btn btn-large btn-block btn-success btn-alert" data-toggle="modal">Reporte</a><br>
	<?php } ?>	

	<legend></legend>

	<!--Caja de los requerimientos -->
	<div id="lista_requerimientos" class="row-fluid"></div>
<?php } ?>

<script type="text/javascript">
	//Cuando el DOM esté listo
	$(document).ready(function(){
		//Datos del panel lateral
		var id_periodo = $("#periodo");
		var id_tramo = $("#tramo");
		var id_ficha = $("#ficha");

		//Cargaremos los requerimientos asociados a esta ficha
		if (id_ficha.val() !== "") {
			datos = {
				'id_periodo': id_periodo.val(),
				'id_tramo': id_tramo.val(),
				'id_ficha': id_ficha.val()
			};//datos

			//Se cargan los requerimientos por ajax
			requerimientos = enviar_ajax_json("<?php echo site_url('ica/cargar_3a_requerimientos'); ?>", datos);
			
			//Si hay requerimientos
			if (requerimientos.length > 0) {
				//Se recorren los requerimientos
				$.each(requerimientos, function(key, val){
					//Se imprimen en la interfaz
					$("#lista_requerimientos").append("<div class='box-header'>" + val.Descripcion.substring(0, 140) + "</div>");//Fin append
				});//Fin each
			};
		} else{
			$("#lista_requerimientos").html("");
		} //if

		// Fecha inicial
		var fecha_inicio = $('#fecha_inicio').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			fecha_inicio.hide();
		}).data('datepicker');

		// Fecha final
		var fecha_final = $('#fecha_final').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			fecha_final.hide();
		}).data('datepicker');

		// Botón reporte
		$("#reporte_3a").on("click", function(){
			url = '<?php echo site_url("reporte/ica_3a") ?>'
			location.href = url + "/" +id_periodo.val() + "/" + id_tramo.val() + "/" + id_ficha.val();
		});//Fin boton reporte

		//Boton guardar 1
		$("#btn_guardar1").on("click", function(){
			//Recoleccion de datos
			var requerimiento = $("#requerimiento");
			var cumplimiento = $("#cumplimiento");
			var cumplimiento_parcial = $("#cumplimiento_parcial");
			var fecha_inicio = $("#fecha_inicio>input");
			var fecha_final = $("#fecha_final>input");
			var observaciones = $("#observaciones");
			
			//Se recogen los datos
			datos = {
				'Fk_Id_Periodo': id_periodo.val(),
				'Fk_Id_Tramo': id_tramo.val(),
				'Fk_Id_Ficha': id_ficha.val(),
				'Descripcion': requerimiento.val(),
				'Cumplimiento': cumplimiento.val(),
				'Cumplimiento_Parcial': cumplimiento_parcial.val(),
				'Fecha_Inicial': fecha_inicio.val(),
				'Fecha_Final': fecha_final.val(),
				'Observaciones': observaciones.val(),
				'Fk_Id_Usuario': "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>"
			}//Fin datos
			// console.log(datos)

			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_3a'); ?>", {'datos': datos});

			//Si se guardó
			if (guardar != "false") {
				//Se agrega el nuevo requerimiento a la lista
				$("#lista_requerimientos").append("<div class='box-header'>" +  requerimiento.val().substring(0, 140) + "</div>");//Fin append

				//Se cierra el modal
				$('#modal_1').modal('hide');

				//Se limpia el formulario
				limpiar(".form-horizontal");
			}
		});//Fin btn guardar 1
	});//Fin document.ready
</script>
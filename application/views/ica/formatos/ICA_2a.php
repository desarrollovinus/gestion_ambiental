<?php
$acceso = $this->session->userdata('Acceso');

/*<!--Validar permiso-->*/
if (!isset($acceso[22])) { ?>
	<div class="hero-unit">
		<h1>Acceso denegado</h1>
		<p>Usted no cuenta con permisos para trabajar el ICA 2a. Si necesita usar este formato, por favor comuníquese con el área de Sistemas para que le sean asignados los permisos correspondientes. </p>
	</div>
<?php } else { ?>
<!--La fecha debe ir sobre el modal-->
	<style>.datepicker{z-index:1151;}</style>

	<!-- **************************************************** Modal 1 ***************************************************** -->
	<a href="#modal_1" role="button" class="btn btn-large btn-block btn-primary btn-alert" data-toggle="modal">1. Otorgado - 2. En trámite</a>
	<div id="modal_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">1. Otorgado - 2. En trámite</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<!--1-->
				<div class="control-group">
					<label class="control-label" for="numero_acto">Número y fecha del acto administrativo</label>
					<div class="controls">
						<input type="text" id="numero_acto" class="span6" placeholder="Número" autofocus >
											
						<div class="input-append date" id="fecha_acto" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				  			<input id="fecha_acto_2" class="span6" size="16" type="text" disabled/>
				  			<span class="add-on"><i class="icon-th"></i></span>
				  		</div>
					</div>
				</div>
				<!--2-->
				<div class="control-group">
					<label class="control-label" for="autoridad1">Autoridad ambiental competente</label>
					<div class="controls">
						<input type="text" id="autoridad1" class="span12" placeholder="" >
					</div>
				</div>
				<!--3-->
				<div class="control-group">
					<label class="control-label" for="">Vigencia, tipo y fecha</label>
					<div class="controls">
						<input type="text" id="vigencia" class="span4" placeholder="Vigencia" >
						<select id="tipo" class="span4">
							<option value="">Seleccione un tipo</option>
							<option value="1">Nuevo</option>
							<option value="2">Renovación o modificación</option>
						</select>
						<div class="input-append date" id="fecha_radicacion" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				  			<input id="fecha_radicacion_2" class="span4" size="16" type="text" disabled/>
				  			<span class="add-on"><i class="icon-th"></i></span>
				  		</div>
					</div>
				</div>
				<!--4-->
				<div class="control-group">
					<label class="control-label" for="autoridad2">Autoridad ambiental competente</label>
					<div class="controls">
						<input type="text" id="autoridad2" class="span12" placeholder="" >
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

	<!-- **************************************************** Modal 2 ***************************************************** -->
	<a href="#modal_2" role="button" class="btn btn-large btn-block btn-primary btn-alert" data-toggle="modal">3. Uso del recurso</a>
	<div id="modal_2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">3. uso del recurso</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<!--1-->
				<div class="control-group">
					<label class="control-label" for="numero_vertimiento">Tipo de vertimiento</label>
					<div class="controls">
						<input type="text" id="numero_vertimiento" class="span6" placeholder="Número" >
						<select id="tipo_vertimiento" class="span6">
							<option value="1">Domésticas</option>
							<option value="2">Industrial</option>
						</select>
					</div>
				</div>

				<!--2-->
				<div class="control-group">
					<label class="control-label" for="autorizado">Vertimiento</label>
					<div class="controls">
						<input type="text" id="autorizado" class="span4" placeholder="Autorizado" >
						<input type="text" id="utilizado" class="span4" placeholder="Utilizado" >
						<input type="text" id="duracion" class="span4" placeholder="Duración" ><br><br>
						<input type="text" id="dispocision_final" class="span12" placeholder="Tipo de disposición final" >
					</div>
				</div>

				<!--3-->
				<div class="control-group">
					<label class="control-label" for="nombre_fuente">Disposición Final</label>
					<div class="controls">
						<input type="text" id="nombre_fuente" class="span6" placeholder="Nombre de la fuente receptora" >
						<input type="text" id="coordenadas" class="span6" placeholder="Coordenadas / Origen" ><br><br>
						<input type="text" id="descripcion_tratamiento" class="span12" placeholder="Descr. Sistema Tratamiento Aguas" ><br><br>
						<input type="text" id="pma" class="span12" placeholder="PMA Relacionado" >
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="btn_guardar2" class="btn btn-primary">Guardar</button>
		</div>
	</div><br>
	<legend></legend>

	<!-- **************************************************** Modal 3 ***************************************************** -->
	<a href="#modal_3" role="button" class="btn btn-large btn-block btn-primary btn-alert" data-toggle="modal">4. Monitoreo e Inspección Ambiental</a>
	<div id="modal_3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">4. Monitoreo e Inspección Ambiental</h3>
		</div>
		<div class="modal-body">
			<form id="" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="parametros">Monitoreo e inspección ambiental</label>
					<div class="controls">
						<input type="text" id="parametros" class="span12" placeholder="Parámetros" ><br><br>
						<input type="text" id="unidad_medicion" class="span6" placeholder="Unidad de medición" >
						<input type="text" id="valor_medicion" class="span6" placeholder="Valor" ><br><br>
						<input type="text" id="metodo_muestra" class="span12" placeholder="Método de toma de muestra" ><br><br>
						<input type="text" id="metodo_analisis" class="span6" placeholder="Método de análisis" >
						<div class="input-append date" id="fecha_muestreo" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				  			<input id="fecha_muestreo_2" class="span6" size="16" type="text" disabled/>
				  			<span class="add-on"><i class="icon-th"></i></span>
				  		</div>
						<input type="text" id="localizacion_muestreo" class="span12" placeholder="Localización de punto de muestreo" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="numero_norma">Norma nac. / internac.</label>
					<div class="controls">
						<input type="text" id="numero_norma" class="span6" placeholder="Número" >
						<input type="text" id="valor_norma" class="span6" placeholder="Valor" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="">Compromiso en estudio ambiental.</label>
					<div class="controls">
						<input type="text" id="valor_compromiso" class="span12" placeholder="Valor" >
						<input type="text" id="pma_compromiso" class="span12" placeholder="Programas del PMA relacionados" >
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="btn_guardar3" class="btn btn-primary">Guardar</button>
		</div>
	</div><br>
	<legend></legend>

	<!--Validar permiso-->
	<?php if (isset($acceso[33])) { ?>
		<!-- **************************************************** Reporte ***************************************************** -->
		<a href="#" id="reporte_2a" role="button" class="btn btn-large btn-block btn-success btn-alert" data-toggle="modal">Reporte</a>
	<?php } ?>
<?php } ?>
<script type="text/javascript">
	//Cuando el DOM esté listo
	$(document).ready(function(){
		//Datos del panel lateral
		var id_periodo = $("#periodo");
		var id_tramo = $("#tramo");
		var id_ficha = $("#ficha");

		//Usamos este estilo para poner la fecha sobre el modal
		$(".datepicker").css("z-index:1151");
		
		var fechas = $('#fecha_acto, #fecha_muestreo, #fecha_radicacion').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			fechas.hide();
		}).data('datepicker');

		$("#reporte_2a").on("click", function(){
			url = '<?php echo site_url("reporte/ica_2a") ?>'
			location.href = url + "/" + $("#ficha").val();
		});//Fin boton reporte

		//Boton guardar 1
		$("#btn_guardar1").on("click", function(){
			//Recoleccion de datos
			var numero_acto = $("#numero_acto");
			var fecha_acto = $("#fecha_acto_2");
			var autoridad1 = $("#autoridad1");
			var vigencia = $("#vigencia");
			var tipo = $("#tipo");
			var fecha_radicacion = $("#fecha_radicacion_2");
			var autoridad2 = $("#autoridad2");

			//Se recogen los datos
			datos = {
				id_periodo: id_periodo.val(),
				id_tramo: id_tramo.val(),
				id_ficha: id_ficha.val(),
				numero_acto: numero_acto.val(),
				fecha_acto: fecha_acto.val(),
				autoridad1: autoridad1.val(),
				vigencia: vigencia.val(),
				tipo: tipo.val(),
				fecha_radicacion: fecha_radicacion.val(),
				autoridad2: autoridad2.val()
			}//Fin datos
			console.log(datos);
			
			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_estado_permiso'); ?>", datos);

			//Si se guardó
			if (guardar != "false") {
				//Se cierra el modal
				$('#modal_1').modal('hide');
			}
		});//Fin btn guardar 1

		//Boton guardar 2
		$("#btn_guardar2").on("click", function(){
			console.log("Guardando uso del recurso...");

			//Recoleccion de datos
			var numero_vertimiento = $("#numero_vertimiento");
			var tipo_vertimiento = $("#tipo_vertimiento");
			var autorizado = $("#autorizado");
			var utilizado = $("#utilizado");
			var duracion = $("#duracion");
			var dispocision_final = $("#dispocision_final");
			var nombre_fuente = $("#nombre_fuente");
			var coordenadas = $("#coordenadas");
			var descripcion_tratamiento = $("#descripcion_tratamiento");
			var pma = $("#pma");

			//Arreglo de datos
			datos = {
				id_periodo: id_periodo.val(),
				id_tramo: id_tramo.val(),
				id_ficha: id_ficha.val(),
				numero_vertimiento: numero_vertimiento.val(),
				tipo_vertimiento: tipo_vertimiento.val(),
				autorizado: autorizado.val(),
				utilizado: utilizado.val(),
				duracion: duracion.val(),
				dispocision_final: dispocision_final.val(),
				nombre_fuente: nombre_fuente.val(),
				coordenadas: coordenadas.val(),
				descripcion_tratamiento: descripcion_tratamiento.val(),
				pma: pma.val()
			}
			console.log(datos);

			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_uso_recurso'); ?>", datos);

			//Si se guardó
			if (guardar != "false") {
				//Se cierra el modal
				$('#modal_2').modal('hide');
			}
		});//Fin guardar 2

		//Boton guardar 3
		$("#btn_guardar3").on("click", function(){
			console.log("Guardando monitoreo...");

			//Recoleccion de datos
			var parametros = $("#parametros");
			var unidad_medicion = $("#unidad_medicion");
			var valor_medicion = $("#valor_medicion");
			var metodo_muestra = $("#metodo_muestra");
			var metodo_analisis = $("#metodo_analisis");
			var fecha_muestreo = $("#fecha_muestreo_2");
			var localizacion_muestreo = $("#localizacion_muestreo");
			var numero_norma = $("#numero_norma");
			var valor_norma = $("#valor_norma");
			var valor_com = $("#valor_com");
			var valor_compromiso = $("#valor_compromiso");
			var pma_compromiso = $("#pma_compromiso");

			//Arreglo de datos
			datos = {
				id_periodo: id_periodo.val(),
				id_tramo: id_tramo.val(),
				id_ficha: id_ficha.val(),
				parametros: parametros.val(),
				unidad_medicion: unidad_medicion.val(),
				valor_medicion: valor_medicion.val(),
				metodo_muestra: metodo_muestra.val(),
				metodo_analisis: metodo_analisis.val(),
				fecha_muestreo: fecha_muestreo.val(),
				localizacion_muestreo: localizacion_muestreo.val(),
				numero_norma: numero_norma.val(),
				valor_norma: valor_norma.val(),
				valor_compromiso: valor_compromiso.val(),
				pma_compromiso: pma_compromiso.val()
			}
			console.log(datos);

			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_monitoreo'); ?>", datos);

			//Si se guardó
			if (guardar != "false") {
				//Se cierra el modal
				$('#modal_3').modal('hide');
			}
		});//Fin guardar 3
	});//Fin document.ready
</script>
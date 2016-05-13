<?php
$acceso = $this->session->userdata('Acceso');

/*<!--Validar permiso-->*/
if (!isset($acceso[24])) { ?>
	<div class="hero-unit">
		<h1>Acceso denegado</h1>
		<p>Usted no cuenta con permisos para trabajar el ICA 2c. Si necesita usar este formato, por favor comuníquese con el área de Sistemas para que le sean asignados los permisos correspondientes. </p>
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
						<input type="text" id="numero_acto" class="span6" placeholder="Número" autofocus />
						<div class="input-append date"  id="fecha_acto" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				  			<input id="fecha_acto_2" class="span6" size="16" type="text" placeholder="Fecha" disabled/>
				  			<span class="add-on"><i class="icon-th"></i></span>
				  		</div>
					</div>
				</div>

				<!--2-->
				<div class="control-group">
					<label class="control-label" for="autoridad1">Autoridad ambiental competente</label>
					<div class="controls">
						<input type="text" id="autoridad1" class="span12" />
					</div>
				</div>

				<!--3-->
				<div class="control-group">
					<label class="control-label" for="">Vigencia, tipo y fecha de radicación</label>
					<div class="controls">
						<input type="text" id="vigencia" class="span4" placeholder="Vigencia" />
						<select id="tipo" class="span4">
							<option value="1">Nuevo</option>
							<option value="2">Renovación o modificación</option>
						</select>
						<div class="input-append date" id="fecha_radicacion" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				  			<input id="fecha_radicacion_2" class="span4" size="16" type="text" placeholder="Fecha" disabled/>
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
			<h3 id="myModalLabel">3. uso del recurso - Captación</h3>
		</div>

		<div class="modal-body">
			<form id="form2" class="form-horizontal">
				<!-- 1 -->
				<div class="control-group">
					<label class="control-label" for="numero">Autorizado</label>
					<div class="controls">
						<input type="text" id="numero" class="span12" placeholder="Número" ><br><br>
						<input type="text" id="area_autorizado" class="span6" placeholder="Área afectada" >
						<input type="text" id="volumen_autorizado" class="span6" placeholder="Volúmen (m3)" >
					</div>
				</div>

				<!-- 2 -->
				<div class="control-group">
					<label class="control-label" for="area_aprovechada">Aprovechada</label>
					<div class="controls">
						<input type="text" id="area_aprovechada" class="span6" placeholder="Área afectada" >
						<input type="text" id="volumen_aprovechada" class="span6" placeholder="Volúmen" >
					</div>
				</div>

				<!-- 3 -->
				<div class="control-group">
					<div class="controls">
						<input type="text" id="coordenadas" class="span12" placeholder="Localización y coordenadas" />
					</div>
				</div>

				<!-- 4 -->
				<div class="control-group">
					<div class="controls">
						<input type="text" id="area_total" class="span12" placeholder="Área total afectada por el cambio de uso" />
					</div>
				</div>

				<!-- 5 -->
				<div class="control-group">
					<div class="controls">
						<input type="text" id="especies_aprovechadas" class="span12" placeholder="Nombre de las especies aprovechadas" />
					</div>
				</div>

				<!-- 6 -->
				<div class="control-group">
					<div class="controls">
						<input type="text" id="especies_reforestacion" class="span12" placeholder="Nombre de las especies por reforestar" />
					</div>
				</div>

				<!-- 7 -->
				<div class="control-group">
					<div class="controls">
						<input type="text" id="pma" class="span12" placeholder="PMA relacionados" />
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
			<form id="form3" class="form-horizontal">
				<!-- 1 -->
				<div class="control-group">
					<label class="control-label" for="numero_monitoreo">Monitoreo e inspección ambiental</label>
					<div class="controls">
						<input type="text" id="numero_monitoreo" class="span6" placeholder="Número" >
						<input type="text" id="parametros" class="span6" placeholder="Parámetros" ><br><br>
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
				
				<!-- 2 -->
				<div class="control-group">
					<label class="control-label" for="compromiso">Compromiso en estudio ambiental.</label>
					<div class="controls">
						<input type="text" id="compromiso" class="span12" />
						
					</div>
				</div>

				<!-- 2 -->
				<div class="control-group">
					<label class="control-label" for="pma_relacionado">Porgramas del PMA relacionados</label>
					<div class="controls">
						<input type="text" id="pma_relacionado" class="span12" />
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
	<?php if (isset($acceso[35])) { ?>	
		<!-- **************************************************** Reporte ***************************************************** -->
		<a href="#" id="reporte_2c" role="button" class="btn btn-large btn-block btn-success btn-alert" data-toggle="modal">Reporte</a>
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

		var fechas = $('#fecha_acto, #fecha_radicacion, #fecha_muestreo').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			fechas.hide();
		}).data('datepicker');

		$("#reporte_2c").on("click", function(){
			url = '<?php echo site_url("reporte/ica_2c") ?>'
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
			
			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_2c'); ?>", datos);

			//Si se guardó
			if (guardar != "false") {
				//Se cierra el modal
				$('#modal_1').modal('hide');

				limpiar(".form-horizontal");
			}
		});//Fin btn guardar 1

		//Boton guardar 2
		$("#btn_guardar2").on("click", function(){
			//Recoleccion de datos
			var numero = $("#numero");
			var area_autorizado = $("#area_autorizado");
			var volumen_autorizado = $("#volumen_autorizado");
			var area_aprovechada = $("#area_aprovechada");
			var volumen_aprovechada = $("#volumen_aprovechada");
			var coordenadas = $("#coordenadas");
			var area_total = $("#area_total");
			var especies_aprovechadas = $("#especies_aprovechadas");
			var especies_reforestacion = $("#especies_reforestacion");
			var pma = $("#pma");

			//Se recogen los datos
			datos = {
				id_periodo: id_periodo.val(),
				id_tramo: id_tramo.val(),
				id_ficha: id_ficha.val(),
				numero: numero.val(),
				area_autorizado: area_autorizado.val(),
				volumen_autorizado: volumen_autorizado.val(),
				area_aprovechada: area_aprovechada.val(),
				volumen_aprovechada: volumen_aprovechada.val(),
				coordenadas: coordenadas.val(),
				area_total: area_total.val(),
				especies_aprovechadas: especies_aprovechadas.val(),
				especies_reforestacion: especies_reforestacion.val(),
				pma: pma.val(),
			}//Fin datos
			//console.log(datos)

			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_2c_recurso'); ?>", datos);

            //Si se guardó
			if (guardar != "false") {
				//Se cierra el modal
				$('#modal_2').modal('hide');

				limpiar("#form2");
			}
		});//Fin btn guardar 2

		//Boton guardar 3
		$("#btn_guardar3").on("click", function(){
			//Recoleccion de datos
			var numero = $("#numero_monitoreo");
			var parametros = $("#parametros");
			var unidad_medicion = $("#unidad_medicion");
			var valor_medicion = $("#valor_medicion");
			var metodo_muestra = $("#metodo_muestra");
			var metodo_analisis = $("#metodo_analisis");
			var fecha_muestreo = $("#fecha_muestreo_2");
			var localizacion_muestreo = $("#localizacion_muestreo");
			var valor_com = $("#valor_com");
			var compromiso = $("#compromiso");
			var pma = $("#pma_relacionado");

			//Arreglo de datos
			datos = {
				id_periodo: id_periodo.val(),
				id_tramo: id_tramo.val(),
				id_ficha: id_ficha.val(),
				numero: numero.val(),
				parametros: parametros.val(),
				unidad_medicion: unidad_medicion.val(),
				valor_medicion: valor_medicion.val(),
				metodo_muestra: metodo_muestra.val(),
				metodo_analisis: metodo_analisis.val(),
				fecha_muestreo: fecha_muestreo.val(),
				localizacion_muestreo: localizacion_muestreo.val(),
				compromiso: compromiso.val(),
				pma: pma.val()
			}
			
			//Para guardar ejecutaremos una funcion JS que envía datos con ajax
			guardar = enviar_ajax("<?php echo site_url('ica/guardar_2c_monitoreo'); ?>", datos);

			//Si se guardó
			if (guardar != "false") {
				//Se cierra el modal
				$('#modal_3').modal('hide');

				limpiar("#form3");
			}
		});//Fin guardar 3
	});//Fin document.ready
</script>
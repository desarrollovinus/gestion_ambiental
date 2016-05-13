<?php
$acceso = $this->session->userdata('Acceso');

/*<!--Validar permiso-->*/
if (!isset($acceso[21])) { ?>
	<div class="hero-unit">
		<h1>Acceso denegado</h1>
		<p>Usted no cuenta con permisos para trabajar el ICA 1a. Si necesita usar este formato, por favor comuníquese con el área de Sistemas para que le sean asignados los permisos correspondientes. </p>
	</div>
<?php } else { ?>
	<!-- ****************************************Metas**************************************** -->
	<div class="span6">
		<h4>1. Metas</h4>
		<table id="meta" class="table"></table>
		<legend></legend>
		<a href="#modal_meta" role="button" class="btn btn-large btn-block btn-primary btn-alert" data-toggle="modal">Agregar Meta</a>
		
		<!--Validar permiso-->
    	<?php if (isset($acceso[32])) { ?>
			<a id="btn_reporte" href="#" role="button" class="btn btn-large btn-block btn-primary btn-success" data-toggle="modal">Generar Reporte</a>
		<?php } ?>

	</div>

	<!-- ****************************************Anexos**************************************** -->
	<div class="span6">
		<h4>2. Anexos</h4>
		<select id="registro" class="span12"></select>
		<br><br>
		<div class="tabbable">
			<!--Titulos de las pestañas-->
		   	<ul class="nav nav-tabs">
			   	<li class="active"><a href="#tab1" data-toggle="tab">Anexo en PDF</a></li>
			   	<li><a href="#tab2" data-toggle="tab">Registro fotográfico</a></li>
		   	</ul

			<!--Contenido-->
		   	<div class="tab-content">
				<!--Anexos en PDF-->
		      	<div class="tab-pane active" id="tab1">
					<div id="panel_subir_pdf" class="ocultar form-vertical">
						<!--Fecha de Inicio-->
			            <label for="fecha_inicio_pdf">Fecha Inicial</label>
						<div id="fecha2" class="input-append date" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
							<input id="fecha_inicio_pdf" class="span12"  type="text" readonly>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>

			            <!--Fecha Final-->
			            <label for="fecha_fin_pdf">Fecha Final</label>
			            <div id="fecha3" class="input-append date" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
							<input id="fecha_fin_pdf" class="span12"  type="text" readonly>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>

			            <div class="form-inline">
			               	<!--Observacion-->
			               	<input type="text" id="observacion_pdf" class="input-xlarge" placeholder="Observación" />

			               	<!--Boton de subida-->
			               	<input type="button" id="subir" class="btn btn-info" value="Seleccionar anexo y subir" />
		               		<span id="mensaje_archivo" class="ocultar"></span><br><br>
			            </div>
					</div>
		      	</div>

		      	<!--Anexos fotograficos-->
		      	<div class="tab-pane" id="tab2">
		      		<div id="panel_subir_fotos" class="ocultar">
			            <!--Fecha-->
						<div id="fecha1" class="input-append date" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
							<input id="fecha_foto" class="span12"  type="text" readonly>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>

						<!--Lugar-->
						<div class="form-inline">
							<input type="text" id="lugar_foto" class="span12" placeholder="Lugar" /> 
						</div>
						<br>

						<!--Observacion-->
						<div class="form-inline">
							<input type="text" id="observacion_foto"  class="span12" placeholder="Observación" />
						</div>

						<!--Boton de subida-->
						<input type="button" id="subir_foto" class="btn btn-info" value="Seleccionar foto y subir" />
						<span id="mensaje_foto" class="ocultar"></span><br><br>
		      		</div>
		      	</div>
		   	</div>
		</div>
	</div>

	<!-- ****************************************Metas**************************************** -->
	<div id="modal_meta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Nueva meta</h3>
		</div>
		<div class="modal-body">
			<form id="form_meta" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="descripcion_meta">Descripción</label>
					<div class="controls">
						<!--<input type="text"  placeholder="Digite una descripción" rows="5">-->
						<textarea id="descripcion_meta" class="span12" rows="3"></textarea>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="btn_guardar_meta" class="btn btn-primary">Guardar Tema</button>
		</div>
	</div>

	<!-- ****************************************Parametros Metas**************************************** -->
	<div id="modal_meta_parametros" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Nuevo parámetro</h3>
		</div>
		<div class="modal-body">
			<form id="form_meta_parametro" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="">Parámetros de control medido</label>
					<div class="controls">
						<input type="text" id="parametro_descripcion" class="span12" placeholder="Descripción" autofocus />
						<input type="text" id="parametro_valor" class="span12" placeholder="Valor">
						<!--<textarea class="span12" rows="5"></textarea>-->
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="">Valor de referencia o característica de calidad</label>
					<div class="controls">
						<input type="text" id="calidad_descripcion" class="span12" placeholder="Descripción">
						<input type="text" id="calidad_valor" class="span12" placeholder="Valor">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label>¿Cumple?</label>
						<select id="cumple">
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="btn_guardar_parametro" class="btn btn-primary">Guardar Parámetro</button>
		</div>
	</div>

	<!-- ****************************************Acciones**************************************** -->
	<div id="modal_accion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Nueva Acción</h3>
		</div>
		<div class="modal-body">
			<form id="form_meta_accion" class="form-horizontal">
				<input type="hidden" id="accion_meta">
				<div class="control-group">
					<label class="control-label" for="descripcion_accion">Descripción</label>
					<div class="controls">
						<!--<input type="text"  placeholder="Digite una descripción" rows="5">-->
						<textarea id="descripcion_accion" class="span12" rows="2"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="">Acciones de verificación periódica</label>
					<div class="controls">
						<input type="text" id="periodicidad" class="span12" placeholder="Periodicidad">
						<input type="text" id="porcentaje_cumplimiento" class="span12" placeholder="Porcentaje Cumplimiento">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="">Acciones de verificación según avance</label>
					<div class="controls">
						<input type="text" id="porcentaje_avance_programado" class="span12" placeholder="Porcentaje de avance programado">
						<input type="text" id="porcentaje_avance_actual" class="span12" placeholder="Porcentaje de avance a la fecha">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="observacion_accion">Observación</label>
					<div class="controls">
						<!--<input type="text"  placeholder="Digite una descripción" rows="5">-->
						<textarea id="observacion_accion" class="span12" rows="5"></textarea>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="btn_guardar_accion" class="btn btn-primary">Guardar Acción</button>
		</div>
	</div>
<?php } ?>

<script type="text/javascript">
	function agregar_parametro(id_meta){
		//Se abre el modal
		$('#modal_meta_parametros').modal('show');

		$("#accion_meta").val(id_meta)
	}

	function agregar_accion(id_meta){
		//Se abre el modal
		$('#modal_accion').modal('show');

		$("#accion_meta").val(id_meta)
	}

	$("#btn_reporte").on("click", function(){
		url = '<?php echo site_url("reporte/ica_1a") ?>'
		location.href = url + "/" + $("#ficha").val();
	});//Fin boton reporte

	//Al guardar la meta
	$("#btn_guardar_meta").on("click", function(){
		console.log("Guardando meta...");

		//Datos que voy a guardar
		datos = {
			id_periodo: $("#periodo").val(),
			id_tramo: $("#tramo").val(),
			id_ficha: $("#ficha").val(),
			descripcion: $("#descripcion_meta").val()
		};//Fin datos

		//Solicitud ajax para guardar la meta
		$.ajax({
			url: "<?php echo site_url('ica/guardar_meta') ?>",
			type: "POST",
			data: datos,
			success: function(respuesta){
				//Si se guardó correctamente
				if (respuesta != "Error") {
					console.log(respuesta)

					//Se imprime la meta
					$("#meta").append(
						'<tr>' +
						'<td>' + datos.descripcion + '</td>' +
						'<td class="span2">' + '<a onClick="javascript:agregar_parametro(' + respuesta + ')" role="button" class="btn btn-small btn-block btn-primary btn-info" data-toggle="modal">Agregar Parámetro</a>' + '</td>' +
						'<td class="span2">' + '<a onClick="javascript:agregar_accion(' + respuesta + ')" role="button" class="btn btn-small btn-block btn-primary btn-info" data-toggle="modal">Agregar Acción</a>' + '</td>' +
						'</tr>'
					);//Fin append

					//Se cierra la ventana
					$('#modal_meta').modal('hide');
					
					//Limpiar formulario
					$("#form_meta")[0].reset();
				}
			}//Fin success
		});//Fin ajax
	});//Fin guardar meta

	//Al guardar el parametro
	$("#btn_guardar_parametro").on("click", function(){
		console.log("Guardando parámetro...");

		//Datos que voy a guardar
		datos = {
			id_meta: $("#accion_meta").val(),
			parametro_descripcion: $("#parametro_descripcion").val(),
			parametro_valor: $("#parametro_valor").val(),
			calidad_descripcion: $("#calidad_descripcion").val(),
			calidad_valor: $("#calidad_valor").val(),
			cumple: parseInt($("#cumple").val())
		}//Fin datos

		//Solicitud ajax para guardar los parametros
		$.ajax({
			url: "<?php echo site_url('ica/guardar_parametro') ?>",
			type: "POST",
			data: datos,
			success: function(respuesta){
				//Si se guardó correctamente
				if (respuesta != "Error") {
					console.log(respuesta)
					//Se imprime la meta
					$("#meta").append(
						
					);//Fin append

					//Se cierra la ventana
					$('#modal_meta_parametros').modal('hide');
					
					//Limpiar formulario
					$("#form_meta_parametro")[0].reset();
				}
			}//Fin success
		});//Fin ajax
	});//Fin guardar parametro

	//Al guardar la acción
	$("#btn_guardar_accion").on("click", function(){
		console.log("Guardando acción...");

		datos = {
			id_meta: $("#accion_meta").val(),
			descripcion: $("#descripcion_accion").val(),
			periodicidad: $("#periodicidad").val(),
			porcentaje_cumplimiento: $("#porcentaje_cumplimiento").val(),
			porcentaje_avance_programado: $("#porcentaje_avance_programado").val(),
			porcentaje_avance_actual: $("#porcentaje_avance_actual").val(),
			observacion: $("#observacion_accion").val()
		}

		$.ajax({
			url: "<?php echo site_url('ica/guardar_accion') ?>",
			type: "POST",
			data: datos,
			success:function(respuesta){
				//Si se guardó correctamente
				if (respuesta != "Error") {
					//Se cierra la ventana
					$('#modal_accion').modal('hide');
					
					//Limpiar formulario
					$("#form_meta_accion")[0].reset();
				}//Fin if()
			}//Fin success
		});//Fin ajax
	});//Fin guardar acción

	//Cuando el DOM este listo
	$(document).ready(function(){
		function reporte(){
			console.log('reporte')
			location.href = '<?php echo site_url("reporte/ica_1a") ?>';
		}

		//Fechas
		var fecha1 = $('#fecha1').datepicker({ onRender: function(date) { }
		}).on('changeDate', function(ev) { fecha1.hide(); }).data('datepicker');

		//Fechas
		var fecha2 = $('#fecha2').datepicker({ onRender: function(date) { }
		}).on('changeDate', function(ev) { fecha2.hide(); }).data('datepicker');

		//Fechas
		var fecha3 = $('#fecha3').datepicker({ onRender: function(date) { }
		}).on('changeDate', function(ev) { fecha3.hide(); }).data('datepicker');

		//Mediante ajax se cargan los registros relacionados a la ficha
		$.ajax({
			url: '<?php echo site_url("ica/cargar_registros"); ?>',
			type: 'POST',
			dataType: 'JSON',
			//async: false,
			data: {id_ficha: $("#ficha").val()},
			success: function(respuesta){
				//Si trae datos
				if(respuesta.length > 0) {
					//Se resetea el select
					$("#registro").html('').append("<option value=''>Seleccione un registro</option>");

					//Se recorren los registros
					$.each(respuesta, function(key, val){
						//Si el registro tiene codigo
						if(val.Codigo){
							//Se imprime el codigo
							codigo = ' (' + val.Codigo + ')';
						} else {
							//No se imprime
							codigo = '';
						}//Fin if()

						//Se agrega cada registro al select
						$("#registro").append("<option value='" + val.Pk_Id_Registro + "'>" + val.Descripcion + codigo + "</option>");
					});//Fin each
				} else {
					//Se resetea el select
					$("#registro").html('');

					//Se oculta el panel de subida de archivos
             		$("[id^=panel_subir_]").hide('slow');
				}//Fin if
			}//Fin success
		});//Fin ajax
		
		//Carga las metas asociadas a la ficha 
		if ($("#ficha").val() !== "") {
			//Solicitud ajax para mostrar las metas 
			$.ajax({
				url: "<?php echo site_url('ica/cargar_metas'); ?>",
				type: "POST",
				dataType: "JSON",
				data: {id_ficha: $("#ficha").val()},
				success: function(respuesta){
					if (respuesta.length > 0) {
						//Se recorre el resultado
						$.each(respuesta, function(key, val){
							//Se imprimen en la interfaz
							$("#meta").append(
								'<tr>' +
								'<td>' + val.Descripcion + '</td>' +
								'<td class="span2">' + '<a onClick="javascript:agregar_parametro(' + val.Pk_Id_Meta + ')" role="button" class="btn btn-small btn-block btn-primary btn-info" data-toggle="modal">Agregar Parámetro</a>' + '</td>' +
								'<td class="span2">' + '<a onClick="javascript:agregar_accion(' + val.Pk_Id_Meta + ')" role="button" class="btn btn-small btn-block btn-primary btn-info" data-toggle="modal">Agregar Acción</a>' + '</td>' +
								'</tr>'
							);//Fin append
						});//Fin each
					}//Fin if
				}//Fin success
			});//Fin ajax
		};//Fin if ficha

		/**
      	 * Cuando se seleccione una registro
      	 */
      	$("#registro").on('change', function(){
  			//Si se selecciona un valor
         	if($(this).val() !== ""){
	            datos = {
	            	id_periodo: $("#periodo").val(),
            		id_formato: $("#formato").val(),
	               	id_ficha: $("#ficha").val(),
	               	id_registro: $(this).val()
	            }//Fin datos

	            /**
        		 * Como un registro puede estar asociado a varias fichas, entonces
        		 * se consulta el id de la relacion entre la ficha y el registro seleccionados
        		 */
        		$.ajax({
        			url: '<?php echo site_url("ica/cargar_relacion_registros"); ?>',
	               	data: datos,
	               	type: 'POST',
	               	success: function(respuesta){
	               		//Si se selecciona un registro
	               		if(respuesta != "") {
	               			//Se muestra el panel de subida de archivos
                     		$("[id^=panel_subir_]").show('slow');

                     		//Se envia el id en un input oculto
                  			$("#id_ficha_registro").val(respuesta);
               			} //Fin if
               			
               			//Se prepara la subida del archivo
						new AjaxUpload('#subir', {
							action: '<?php echo site_url("ica/subir"); ?>',
							type: 'POST',
							data: datos,
							onSubmit : function(file , ext){
								//Se valida la extension del archivo
								if (!(ext && /^(pdf|PDF)$/.test(ext))){
									//Se muestra el error
									$("#mensaje_archivo").html('El anexo no es válido. Debe subir un archivo PDF').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
								      return false;
								} else if ($("#fecha_inicio_pdf").val() === '' || $("#fecha_fin_pdf").val() === '' || $.trim( $("#observacion_pdf").val()) === '') {
									//Si no se llenaron todos los campos, se muestra el mensaje
									$("#mensaje_archivo").html('Por favor diligencie todos los datos').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
									return false;
								} else {
									//Se muestra la imagen cargando
									$("#mensaje_archivo").fadeIn().html("<img src='<?php echo base_url().'img/cargando.gif'; ?>' />");
								}//Fin if

								//Se arregan al arreglo JSON los datos a enviar
								datos['tipo_archivo'] = 1;
								datos['id_ficha_registro'] = $("#id_ficha_registro").val();
								datos['fecha_inicio'] = $("#fecha_inicio_pdf").val();
								datos['fecha_fin'] = $("#fecha_fin_pdf").val();
								datos['observacion'] = $("#observacion_pdf").val();
								datos['lugar'] = null;

								//console.log(datos)
							},//Fin onSubmit,
							onComplete: function(file, response){
								//Si la respuesta es true
								if(response){
									//Se muestra el mensaje de exito
									$("#mensaje_archivo").html('El archivo se subió correctamente.').removeClass('error').addClass('exito').fadeIn(2000).delay(3000).fadeOut("slow");
								} else {
									//Se muestra el mensaje de error
									$("#mensaje_archivo").html('Ha ocurrido un error al subir el anexo.').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
								}
							}//Fin onComplete
						});//Fin ajaxupload

						//Subir foto
						new AjaxUpload('#subir_foto', {
							action: '<?php echo site_url("ica/subir"); ?>',
							type: 'POST',
							data: datos,
							onSubmit : function(file , ext){
								//Se valida la extension del archivo
								if (!(ext && /^(jpg|JPG)$/.test(ext))){
									//Se muestra el error
									$("#mensaje_foto").html('El anexo no es válido. Debe subir una foto en formato JPG').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
								      return false;
								} else if ($("#fecha_foto").val() === '' ||  $.trim($("#lugar_foto").val()) === ''||  $.trim($("#observacion_foto").val()) === '') {
									//Si no se llenaron todos los campos, se muestra el mensaje
									$("#mensaje_foto").html('Por favor diligencie todos los datos').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
									return false;
								} else {
									//Se muestra la imagen cargando
									$("#mensaje_foto").fadeIn().html("<img src='<?php echo base_url().'img/cargando.gif'; ?>' />");
								}//Fin if

								//Se arregan al arreglo JSON los datos a enviar
								datos['tipo_archivo'] = 2;
								datos['id_ficha_registro'] = $("#id_ficha_registro").val();
								datos['fecha_inicio'] = $("#fecha_foto").val();
								datos['fecha_fin'] = null;
								datos['observacion'] = $("#observacion_foto").val();
								datos['lugar'] = $("#lugar_foto").val();

							},//Fin onSubmit
							onComplete: function(file, response){
								//console(response)
								//Si la respuesta es true
								if(response){
									//Se muestra el mensaje de exito
									$("#mensaje_foto").html('La foto se subió correctamente').removeClass('error').addClass('exito').fadeIn(2000).delay(3000).fadeOut("slow");
								} else {
									//Se muestra el mensaje de error
									$("#mensaje_foto").html('Ha ocurrido un error al subir el anexo.').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
								}
							}//Fin onComplete
						});//Fin ajaxUpload foto
               		}//Fin success
    			});//Fin ajax
         	} //Fin if
  		});//Fin change registro
	});//Fin document.ready
</script>
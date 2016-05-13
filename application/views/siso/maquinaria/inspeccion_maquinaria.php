<!-- Enlaces para las firmas  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.signaturepad.css" media="screen">
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.signaturepad.min.js"></script>

<?php
// Se cargan los datos necesarios
$conductores = $this->ica_model->cargar_conductores();
$categorias = $this->ica_model->cargar_categorias_vehiculos();
$estados = $this->siso_model->cargar_estados_maquinas();
$maquinas = $this->ica_model->cargar_maquinas();
?>

<!-- Modal Exito -->
<div id="modal_exito_maquinaria" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Inspección registrada</h3>
	</div>
	<div class="modal-body">
		<p>Se ha registrado correctamente la inspección. Ahora por favor registre la firma.</p>
	</div>
	<div class="modal-footer">
		<a id="progreso"></a>
		<button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Ok</button>
	</div>
</div><!-- Modal Exito -->

<style>.datepicker{z-index:1151;}</style>
<center><h3>Inspección de maquinaria</h3></center>

<!-- Formulario -->
<form class="form_maquinaria" id="cont_maquinaria">
	<div class="row-fluid">
		<!-- Columna 1 -->
		<div class="span3 well">
			<center><b>Datos generales</b></center>
			<br>

			<!-- Máquina -->
			<div class="control-group">
				<!-- <label class="control-label" for="select_maquina">Máquina</label> -->
				<div class="controls">
					<select id="select_maquina" class="select_lateral" autofocus>
						<option value="">Máquina...</option>
						<?php foreach ($maquinas as $maquina) { ?>
							<option value="<?php echo $maquina->Pk_Id_Valor; ?>"><?php echo $maquina->Nombre; ?></option>
						<?php } ?>
					</select>
				</div>
			</div><!-- Máquina -->

			<!-- Operador -->
			<div class="control-group">
				<!-- <label class="control-label" for="select_operador">Operador</label> -->
				<div class="controls">
					<?php //if (isset($curriculo->Documento)) { $documento = $curriculo->Documento; }else{ $documento = ""; } ?>
					<select id="select_operador" class="select_lateral" >
						<option value="">Operador...</option>
						<?php foreach ($conductores as $conductor) { ?>
							<option value="<?php echo $conductor->Pk_Id_Hoja_Vida_Conductor; ?>"><?php echo $conductor->Nombres; ?></option>
						<?php } ?>
					</select>
				</div>
			</div><!-- Operador -->

			<!-- Horómetro o kilometraje -->
			<div class="control-group">
				<!-- <label class="control-label" for="input_horometro">Horómetro o kilometraje</label> -->
				<div class="controls">
		  			<input class="span12" id="input_horometro" type="text" placeholder="Horómetro o kilometraje"/>
				</div>
			</div><!-- Horómetro o kilometraje -->
		</div><!-- Columna 1 -->
		
		<!-- Columna 2 -->
		<div class="span3 well">
			<center><b>Licencia de conducción del operador</b></center>

			<!-- Categoría -->
			<div class="control-group">
				<label class="control-label" for="select_categoria">Categoría</label>
				<div class="controls">
					<?php //if (isset($curriculo->Documento)) { $documento = $curriculo->Documento; }else{ $documento = ""; } ?>
					<select id="select_categoria" class="select_lateral" >
						<option value="">Seleccione...</option>
						<?php foreach ($categorias as $categoria) { ?>
							<option value="<?php echo $categoria->Pk_Id_Valor; ?>"><?php echo $categoria->Nombre; ?></option>
						<?php } ?>
					</select>
				</div>
			</div><!-- Categoría -->

			<!-- Vigencia -->
			<div class="control-group">
				<label class="control-label" for="select_categoria">Vigencia</label>
				<div class="controls">
					<div class="input-append date"  id="vigencia" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
			  			<input class="span12" size="16" type="text" placeholder="Fecha" disabled/>
			  			<span class="add-on"><i class="icon-th"></i></span>
			  		</div>
		  		</div>
			</div><!-- Vigencia -->
		</div><!-- Columna 2 -->
		
		<!-- Columna 3 -->
		<div class="span3 well">
			<center><b>SOAT</b></center>
			
			<!-- ¿Requerido? -->
			<div class="control-group span12">
				<label class="control-label">¿Requerido?</label><br>
				<label class="radio span3">
					<input type="radio" name="soat_requerido" id="soat_requerido" value="1" > Si
				</label>
				<label class="radio span3">
					<input type="radio" name="soat_requerido" id="soat_requerido" value="0" checked> No
				</label>
			</div><!-- ¿Requerido? -->
			
			<!-- Fecha de vencimiento -->
			<div class="control-group span12">
				<label class="control-label">Vencimiento</label>
				<div class="controls">
					<div class="input-append date"  id="vencimiento_soat" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
			  			<input class="span12" size="16" type="text" placeholder="Fecha" disabled/>
			  			<span class="add-on"><i class="icon-th"></i></span>
			  		</div>
		  		</div>
			</div><!-- Fecha de vencimiento -->
		</div><!-- Columna 3 -->


		<!-- Columna 4 -->
		<div class="span3 well">
			<center><b>Revisión tecnicomecánica</b></center>

			<!-- ¿Requerido? -->
			<div class="control-group span12">
				<label class="control-label">¿Requerido?</label><br>
				<label class="radio span3">
					<input type="radio" name="revision_requerida" id="revision_requerida" value="1" > Si
				</label>
				<label class="radio span3">
					<input type="radio" name="revision_requerida" id="revision_requerida" value="0" checked> No
				</label>
			</div><!-- ¿Requerido? -->
			
			<!-- Vencimiento -->
			<div class="control-group span12">
				<label class="control-label">Vencimiento</label>
				<div class="controls">
					<div class="input-append date"  id="vencimiento_revision" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
			  			<input class="span12" size="16" type="text" placeholder="Fecha" disabled/>
			  			<span class="add-on"><i class="icon-th"></i></span>
			  		</div>
		  		</div>
			</div><!-- Vencimiento -->
		</div><!-- Columna 4 -->
	</div>
	
	<!-- Tabla de estados -->
	<table id="tabla_estados" class="table table-striped">
		<thead>
			<tr>
				<th>
					<center>Nro.</center>
				</th>
				<th width="40%">
					<center>Descripción</center>
				</th>
				<th colspan="3">
					<center>Estado</center>
				</th>
				<th rowspan="2" width="40%">
					<center>Observaciones</center>
				</th>
			</tr>
			<tr>
				<th><center></center></th>
				<th class="ocultar"><center>Estado</center></th>
				<th><center>Estado de la máquina</center></th>
				<th><center>B</center></th>
				<th><center>M</center></th>
				<th><center>N/A</center></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$cont = 0;
			foreach ($estados as $estado) {
			$cont++;
			?>
			<tr>
				<td><?php echo $cont; ?></td>
				<td class="ocultar"><?php echo $estado->Pk_Id_Valor; ?></td>
				<td><?php echo $estado->Nombre; ?></td>
				<td>
					<label class="radio">
						<input type="radio" id="<?php echo $cont; ?>" name="<?php echo $estado->Pk_Id_Valor; ?>" value="1">
					</label>
				</td>
				<td>
					<label class="radio">
						<input type="radio" id="<?php echo $cont; ?>" name="<?php echo $estado->Pk_Id_Valor; ?>" value="0">
					</label>
				</td>
				<td>
					<label class="radio">
						<input type="radio" id="<?php echo $cont; ?>" name="<?php echo $estado->Pk_Id_Valor; ?>" value="2">
					</label>
				</td>
				<td>
		  			<input name="observacion<?php echo $estado->Pk_Id_Valor; ?>" class="span12" type="text"/>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table><!-- Tabla de estados -->

	<input id="btn_guardar_inspeccion" class="btn btn-large btn-block btn-success" type="submit" />

	<div id="div_mensaje"></div>
</form><!-- Formulario -->

<!-- Firma -->
<div id="cont_firma"></div>

<script type="text/javascript">
	//Cuando el DOM esté listo
	$(document).ready(function(){
		// Fechas
		var vigencia = $('#vigencia').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			vigencia.hide();
		}).data('datepicker');	

		var vencimiento_soat = $('#vencimiento_soat').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			vencimiento_soat.hide();
		}).data('datepicker');	

		var vencimiento_revision = $('#vencimiento_revision').datepicker({
			onRender: function(date) {
			}
		}).on('changeDate', function(ev) {
			vencimiento_revision.hide();
		}).data('datepicker');	

		// Declaración de variables
		var maquina = $("#select_maquina");
		var operador = $("#select_operador");
		var categoria = $("#select_categoria");
		var horometro = $("#input_horometro");
		var estados = {};

		// Submit
		$(".form_maquinaria").on("submit", function(){
			//Arreglo JSON de datos a enviar posteriormente
            datos_formulario = {
            	"Fecha_Vencimiento_Revision": $("#vencimiento_revision > input").val(),
            	"Fecha_Vencimiento_Soat": $("#vencimiento_soat > input").val(),
            	"Fecha_Vigencia": $("#vigencia > input").val(),
            	"Fk_Id_Valor_Categoria": categoria.val(),
            	"Fk_Id_Valor_Maquina": maquina.val(),
            	"Fk_Id_Hoja_Vida_Operador": operador.val(),
            	"Fk_Id_Usuario": "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>",
            	"Horometro": horometro.val(),
            	"Soat_Requerido": $('input:radio[id=soat_requerido]:checked').val(),
            	"Revision_requerida": $('input:radio[id=revision_requerida]:checked').val()
            };
            // console.log(datos_formulario);

            // Se guarda el registro
			guardar = enviar_ajax("<?php echo site_url('siso/guardar'); ?>", {'tipo': 'inspeccion_maquinaria', 'datos': datos_formulario});

			// Contador
			cont = "<?php echo $cont; ?>";
			
			// Recorrido por cada estado
			for (i = 1; i <= cont; i++) {
				// Se toma el id de estado
				id_estado = $('input[id='+i+']').attr('name');

				//Se toma el valor del estado
				estado  = $("input[name='" + id_estado + "']:checked").val();

				// Si el estado tiene un valor
				if (estado) {
					// Se recogen los datos en un arreglo				
					datos_estado = {
						'Fk_Id_Valor_Estado': id_estado,
						'Fk_Id_Siso_Maquinaria': guardar,
						'Valor': $("input[name='" + id_estado + "']:checked").val(),
						'Observacion': $("input[name='observacion" + id_estado + "']").val()
					}
		            // console.log(datos_estado);

		            // Se guarda el registro de cada estado que tenga algún check
					guardar_estado = enviar_ajax("<?php echo site_url('siso/guardar'); ?>", {'tipo': 'estado', 'datos': datos_estado});
				};
			}// for

			// Si se guarda correctamente
			if(guardar > 0){
				//Se muestra el mensaje de exito
				$('#modal_exito_maquinaria').modal('show');

				// Se desactiva el botón
				$("#btn_guardar_inspeccion").attr('disabled', 'disabled');

				// Se muestra el contenedor de firma
				$("#cont_firma").load("<?php echo site_url('siso/firma'); ?>", {id_siso_maquinaria: guardar});
			} else {
				//Se muestra el mensaje de exito
            	$("#div_mensaje").html('<div class="alert alert-danger"><button class="close" data-dismiss="alert">&times;</button>Hubo un error al crear el registro.</div>');
			// console.log(guardar);
			}
			
			// Se detiene el formulario
			return false;
		}); // submit
	});//Fin document.ready
</script> 
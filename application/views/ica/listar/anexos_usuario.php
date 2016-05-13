<!-- Modal Eliminar -->
<div id="modal_eliminar" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Eliminar</h3>
	</div>
	<div class="modal-body">
		<input id="archivo" type="hidden">
		<input id="id_anexo" type="hidden">
		<p>¿Está seguro de eliminar el anexo?</p>
	</div>
	<div class="modal-footer">
		<a id="progreso"></a>
		<button class="btn" data-dismiss="modal" aria-hidden="true">No, cancelar</button>
		<a id="btn_eliminar" href="#" class="btn btn-primary">Si</a>
	</div>
</div><!-- Modal Eliminar -->

<?php
// Se listan los anexos
$anexos = $this->ica_model->listar_anexos_usuario();
?>
<!-- Cabecera -->
<div class="box-header">
	<b>Estos son los <?php echo number_format(count($anexos), 0, '', '.'); ?> anexos que usted ha subido</b>
</div><!-- Cabecera -->

<!-- Cuerpo -->
<div class="box-content">
	<?php
	// Contador 
	$cont = 1;

	// Recorrido de los anexos
	foreach ($anexos as $anexo) {
		// Se consulta el archivo y archivo a eliminar
		$archivo = $this->ica_model->listar_anexos_subidos($anexo->Pk_Id_Anexo);
		$archivo_eliminar = $this->ica_model->listar_archivos_eliminar($anexo->Pk_Id_Anexo);

		// Si es PDF
		if ($anexo->Fk_Id_Anexo_Tipo == 1) {
			// Declaración de la clase
			$clase = 'anexo_pdf';
			$src = base_url().'img/pdf.png';
		}else{
			// Declaración de la clase
			$clase = 'anexo_foto';
			$src = $archivo;
		}
		?>

		<!-- Contenedor -->
		<div id="anexo<?php echo $anexo->Pk_Id_Anexo; ?>" class="<?php echo $clase; ?>">
			<img src="<?php echo $src; ?>" />
			<blockquote>
				<h5><?php echo $cont." - ".$anexo->Observacion; ?></h5>
				<small><b>Fecha de subida:</b> <?php echo date('Y-m-d', strtotime($anexo->Fecha_Hora)); ?></small>
				<small><b>Fecha de inicio:</b> <?php echo date('Y-m-d', strtotime($anexo->Fecha_Inicio)); ?></small>
				<small><b>Período:</b> <?php echo $anexo->Periodo; ?></small>
				<small><b>Tramo:</b> <?php echo $anexo->Tramo; ?></small>
				<small><b>Formato:</b> <?php echo $anexo->Formato; ?></small>
				<small><b>Ficha:</b> <?php echo $anexo->Ficha; ?></small>
				<small><b>Registro:</b> <?php echo $anexo->Registro; ?></small>
				<center>
					<a href="<?php echo $archivo; ?>" title="Ver anexo" target="blank">
						<i class="icon-search" title="Ver"></i> 
					</a>
					|
					<a href="javascript:eliminar('<?php echo $archivo_eliminar; ?>', '<?php echo $anexo->Pk_Id_Anexo; ?>')" >
						<i class="icon-remove" title="Eliminar este anexo"></i>
					</a>
				</center>
			</blockquote>
		</div>
		<?php
		$cont++;
	} // foreach
	?>
</div><!-- Cuerpo -->

<script type="text/javascript">
	function eliminar(archivo, id_anexo){
		$("#archivo").val(archivo);
		$("#id_anexo").val(id_anexo);
		// Se abre el modal
		$('#modal_eliminar').modal('show');
	}

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Eliminar
		$("#btn_eliminar").on("click", function(){
			eliminar = enviar_ajax("<?php echo site_url('ica/eliminar_anexo'); ?>", {archivo: $("#archivo").val(), id_anexo: $("#id_anexo").val()});
			console.log(eliminar);
			
			// Se cierra el modal
            $('#modal_eliminar').on('hidden', function () {
				$('#modal_eliminar').modal('hide');
			})
			
			// Se redirecciona
			location.href = "<?php echo site_url('ica/anexos_usuario'); ?>";

		}); // Eliminar
	});//Fin document.ready
</script>
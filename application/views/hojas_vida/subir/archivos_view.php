<?php
$acceso = $this->session->userdata('Acceso');
//
$id_hoja_vida = $this->input->post('id_hoja_vida');
//Se listan los archivos subidos
$archivos = $this->hoja_vida_model->listar_archivos($id_hoja_vida);
?>

<!-- Modal Eliminar -->
<div id="modal_eliminar" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Eliminar</h3>
	</div>
	<div class="modal-body">
		<input id="archivo" type="hidden">
		<input id="id_hoja_vida_archivo" type="hidden">
		<p>¿Está seguro de eliminar el archivo escaneado?</p>
	</div>
	<div class="modal-footer">
		<a id="progreso"></a>
		<button class="btn" data-dismiss="modal" aria-hidden="true">No, cancelar</button>
		<a id="btn_eliminar" href="#" class="btn btn-primary">Si</a>
	</div>
</div><!-- Modal Eliminar -->

<table id="tabla_archivos" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>Nro.</th>
			<th>Categoría</th>
			<th>Subcategoría</th>
			<th>Fecha subida</th>
			<th>Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$cont = 1;
		foreach ($archivos as $archivo) {
		?>
			<tr>
				<td><?php echo $cont; ?></td>
				<td><?php echo $archivo->Categoria; ?></td>
				<td><?php echo $archivo->Subcategoria; ?></td>
				<td><?php echo $this->auditoria_model->formato_fecha($archivo->Fecha); ?></td>
				<td>
					<?php
					//$ruta = base_url().'archivos/hojas_vida/'.$archivo->Pk_Id_Hoja_Vida_Archivo;
					// $ruta_eliminar = './archivos/hojas_vida/'.$archivo->Pk_Id_Hoja_Vida_Archivo.'/';

					$archivo_eliminar = $this->hoja_vida_model->listar_archivos_eliminar($archivo->Pk_Id_Hoja_Vida_Archivo);
					$escaneo = $this->hoja_vida_model->listar_archivos_subidos($archivo->Pk_Id_Hoja_Vida_Archivo);
					?>
					<!-- Permiso para ver archivos -->
					<?php if (isset($acceso[61])) { ?>
						<a href="<?php echo $escaneo; ?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=600'); return false;"><i class="icon-search"></i></a>
					<?php } ?>

					<!-- Permiso para eliminar archivos -->
					<?php if (isset($acceso[62])) { ?>
						<a href="javascript:eliminar('<?php echo $archivo_eliminar; ?>', '<?php echo $archivo->Pk_Id_Hoja_Vida_Archivo; ?>')"><i class="icon-remove"></i></a>
					<?php } ?>
				</td>
			</tr>
		<?php
		$cont++;
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
	function eliminar(archivo, id_hoja_vida_archivo){
		$("#archivo").val(archivo);
		$("#id_hoja_vida_archivo").val(id_hoja_vida_archivo);
		// Se abre el modal
		$('#modal_eliminar').modal('show');
	}

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Eliminar
		$("#btn_eliminar").on("click", function(){
			eliminar = enviar_ajax("<?php echo site_url('hoja_vida/eliminar') ?>", {archivo: $("#archivo").val(), id_hoja_vida_archivo: $("#id_hoja_vida_archivo").val()});
			console.log(eliminar);
			
			// 
			$('#modal_eliminar').modal('hide');
			
			// Se cierra el modal
            // $('#modal_eliminar').on('hidden', function () {
            
			// })

			//Se carga la lista con archivos subidos
			$("#archivos_subidos").load("<?php echo site_url('hoja_vida/listar_archivos') ?>", {'id_hoja_vida': "<?php echo $id_hoja_vida; ?>"})
		}); // Eliminar
	});//Fin document.ready
</script>
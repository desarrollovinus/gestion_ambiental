<?php $id_siso_maquinaria = $this->input->post('id_siso_maquinaria'); ?>

<!-- Modal Exito -->
<div id="modal_exito_firma" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Firma registrada</h3>
	</div>
	<div class="modal-body">
		<p>Se ha registrado correctamente la firma. Si desea cambiarla, por favor firme de nuevo y presione el botón "Guardar la firma"</p>
	</div>
	<div class="modal-footer">
		<a id="progreso"></a>
		<button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Ok</button>
	</div>
</div><!-- Modal Exito -->

<!-- <form method="post" action="<?php //echo site_url('siso/guardar_firma'); ?>" class="sigPad"> -->
<form method="post" class="sigPad">
	<ul class="sigNav">
		<li class="drawIt"><a href="#draw-it">Firma del operario</a></li>
		<li class="clearButton"><a href="#clear">Limpiar</a></li>
	</ul>
	<div class="sig sigWrapper">
		<div class="typed"></div>
		<canvas class="pad" width="400" height="105"></canvas>
		<input type="hidden" name="output" class="output">
	</div>
	<button type="submit">Guardar la firma</button>
</form>

<script>
	var sig;

	$(document).ready(function() {
		sig = $('.sigPad').signaturePad({drawOnly:true});
	});

	$('.sigPad').submit(function(evt) {
		// Valor de la imagen
		$('.imgOutput').val( sig.getSignatureImage() );

		// Se guarda la imagen
		guardar = enviar_ajax("<?php echo site_url('siso/guardar_firma'); ?>", {'output': $('.output').val(), id: "<?php echo $id_siso_maquinaria; ?>"});

		//Se muestra el mensaje de exito
		$('#modal_exito_firma').modal('show');

		// Se detiene el formulario
		return false;
	});  
</script>
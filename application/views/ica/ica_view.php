<blockquote>
	<p>Módulo ICA</p>
	<small>Este módulo es para ingresar información de cada uno de los formatos del ICA</small>
	<small>Si desea visualizar la información, diríjase a <a href="<?php echo site_url('ica/listar_anexos'); ?>">Este módulo</a></small>
</blockquote>

<!--Input oculto que guarda el id relacional-->
<input type="hidden" id="id_ficha_registro" name="id_ficha_registro" />

<!--En este DIV se carga la vista que se seleccione según el formato-->
<div id="vista" class="ocultar">
	<center>
		<p>Cargando...</p>
		<p>
			<img src='<?php echo base_url().'img/cargando.gif'; ?>' />
		</p>	
	</center>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
	});//Fin document.ready
</script>
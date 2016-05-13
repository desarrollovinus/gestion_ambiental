<div id="info_menu" class="hero-unit">
	<h4>Solicitud <?php echo $this->auditoria_model->numero_solicitud($id_solicitud); ?></h4>
	
	<!--Validar permiso-->
	<?php if (isset($acceso[37])) { ?>
		<input type="button" class="btn btn-large btn-block btn-danger" value="Imprimir solicitud" onclick="window.open('<?php echo site_url('reporte/solicitud_recepcion/'.$id_solicitud) ?>', '', 'width = 800,height = 600')">
		
		<input type="button" class="btn btn-large btn-block btn-danger" value="Imprimir seguimiento" onclick="window.open('<?php echo site_url('reporte/solicitud_seguimiento/'.$id_solicitud) ?>', '', 'width=800,height = 600')">
	<?php } // ?>
	<ul>
		<li>Para Modificar los datos generales haga clic sobre el campo.</li>
	</ul>
</div>
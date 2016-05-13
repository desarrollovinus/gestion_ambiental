<div>
	<!--Se hace un recorrido-->
	<?php foreach ($solicitudes as $solicitud): ?>
		<!--Caja de la solicitud-->
		<div class="solicitud">
			<!--Cabecera de la caja de la solicitud-->
			<div class="box-header cabecera">
				<!--Iconos-->
				<div class="iconos">
					<a href="#"><i class="icon-print" title="Haga clic para imprimir la solicitud (En desarrollo)" data-toggle="tooltip"></i></a>
					<a href="<?php echo site_url('solicitud/ver/'.$solicitud->Pk_Id_Solicitud); ?>"><i class="icon-search" title="Haga clic para ver la solicitud" data-toggle="tooltip"></i></a>
					<a href="<?php echo site_url('reporte/solicitud/'.$solicitud->Pk_Id_Solicitud); ?>"><i class="icon-download-alt" title="Haga clic para descargar la solicitud" data-toggle="tooltip"></i></a>
				</div>
				<!--Nombre del solicitante-->
				<div class="solicitante"><?php echo $solicitud->Nombres; ?></div>
				<!--Numero de solicitud-->
				<div class="numero">
					<?php echo $this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud); ?>
				</div>
			</div>

			<!--Cuerpo de la caja de la solicitud-->
			<a href="<?php echo site_url('solicitud/ver/'.$solicitud->Pk_Id_Solicitud); ?>">
				<div class="box-content cuerpo">
					<!--Descripcion-->
					<div class="descripcion">
						<!--Descripcion-->
						<?php echo $solicitud->Solicitud_Descripcion; ?> - 

						<!--Fecha-->
						<p id="fecha_solicitud">
							<b class="time1" title="<?php echo $solicitud->Fecha_Creacion; ?>"><?php echo $this->auditoria_model->formato_fecha($solicitud->Fecha_Creacion); ?></b>
						</p>
					</div>
				</div>
			</a>
		</div>
	<!--Se finaliza el recorrido-->
	<?php endforeach; ?>
</div>

<script type="text/javascript">
	//Cuando el DOM este listo 
    $(document).ready(function(){
    	//Mensajes de informacion
	    $('.icon-print, .icon-search, .icon-download-alt').tooltip({
	        placement: 'top'
	    });

    	//Marca de fecha
    	$(".time1").timeago();

    	jQuery.ias({
            container : '.solicitudes',
            item: '.post',
            pagination: '#content .navigation',
            next: '.next-posts a',
            loader: '<img src="https://raw.github.com/webcreate/infinite-ajax-scroll/master/dist/images/loader.gif"/>',
            triggerPageThreshold: 2
        });
  	});
</script>

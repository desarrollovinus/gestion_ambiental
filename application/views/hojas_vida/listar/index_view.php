<input id="total_curriculos" type="hidden">

<!-- Modal Confirmación -->
<div id="modal_confirmacion" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Confirmación</h3>
	</div>
	<div class="modal-body">
		<p>¿Está seguro de generar el reporte correspondiente a esta semana? Recuerde:</p>
		<ul>
			<li>No debe tener ninguna búsqueda activada para que el reporte se genere completo.</li>
			<li>Sólo se generará el reporte con las hojas de vida contratadas</li>
		</ul>
	</div>
	<div class="modal-footer">
		<a id="progreso"></a>
		<button class="btn" data-dismiss="modal" aria-hidden="true">No, cancelar</button>
		<a id="btn_guardar_reporte" href="#" class="btn btn-primary">Si</a>
	</div>
</div><!-- Modal Confirmación -->

<center>
	<div id="barra_progreso">
		<div class="progress progress-striped active">
			<div id="barra" class="bar" style="width: 0%;"></div>
		</div>
	</div>
	<p></p>
	
	<!-- <input id="buscar" type="text" placeholder="Buscar por nombre o documento" autofocus > -->
</center>

<!-- Contenedor de las hojas de vida -->
<div id="hojas_vida">
	<?php $this->load->view('hojas_vida/listar/listar_view'); ?>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		/**
		 * Al generar el reporte
		 */
		$("#btn_generar").on("click", function(){			
			// Se abre el modal
			$('#modal_confirmacion').modal('show');
		}); //btn_generar_reporte

		/**
		 * Guardado del reporte
		 */
		$("#btn_guardar_reporte").on("click", function(){
			// Se cierra el modal
			$('#modal_confirmacion').modal('hide');

			//Variable contadora
			var cont = 0;

			//Se guarda la hoja de vida en la tabla de reportes
			vinculados = enviar_ajax_json("<?php echo site_url('hoja_vida/listar_vinculados'); ?>", {'datos': '0'});

			//Se toma el total de los vinculados y se multimplica por lo que demorará cada registro
			total_vinculados = vinculados.length * 0.015;

			// total_vinculados = 200;
			 console.log(total_vinculados)

			// 
		    $.each(vinculados, function( index, val ) {
				// Arreglo de datos a enviar
				datos = {
					"Fk_Id_Hoja_Vida": val.Pk_Id_Hoja_Vida,
					"Fecha": "<?php echo date('Y-m-d'); ?>"
				}
    			
    			//Se guarda la hoja de vida en la tabla de reportes
				enviar_ajax_asincrono("<?php echo site_url('hoja_vida/guardar_reporte'); ?>", {'datos': datos});

				
			});

			//Intervalo
			var progreso = setInterval(function(){
			    //Aumentar contador
		    	cont++;
			    
			    // Avanza la barra de progreso
				$("#barra").css("width", cont + '%');

			    if (cont >= total_vinculados){
			    	//Se muestra el mensaje de exito
            		$("#barra_progreso").html('<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button>El reporte se generó correctamente.</div>');

			    	//Se detiene el loop
			        clearInterval(progreso);
			    } // if
			}, 500); // intervalo
		}); //btn_guardar_reporte
	});//Fin document.ready
</script>
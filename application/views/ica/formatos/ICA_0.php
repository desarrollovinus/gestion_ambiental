<?php
$acceso = $this->session->userdata('Acceso');

/*<!--Validar permiso-->*/
if (!isset($acceso[20])) { ?>
	<div class="hero-unit">
		<h1>Acceso denegado</h1>
		<p>Usted no cuenta con permisos para trabajar el ICA 0. Si necesita usar este formato, por favor comuníquese con el área de Sistemas para que le sean asignados los permisos correspondientes. </p>
	</div>
<?php } else { ?>
	<div class="box-header"><h2></h2></div>
	<div class="box-content">
		<form class="form-inline">
			<input type="text" id="nueva_version" class="span6" placeholder="Digite una nueva versión y presione Enter" />   
			<span id="mensaje_version"></span>
		</form>
		<div id="versiones"></div>
		<legend></legend>

		<!--Validar permiso-->
		<?php if (isset($acceso[30])) {?>
			<!-- Boton para impresion del reporte -->
		   	<button id="imprimir" class="btn btn-large btn-success btn-block btn-primary" type="button">Generar reporte en Excel de todas las fichas</button>  
	   	<?php } ?>
	</div>
<?php } ?>

<script type="text/javascript">
	//Cuando el DOM este listo
	$(document).ready(function(){
		//Si se selecciona una ficha
		if ($("#ficha").val() != "") {
			//Mediante ajax se cargan las versiones de la ficha
			$.ajax({
				url: "<?php echo site_url('ica/listar_versiones'); ?>",
				type: 'POST',
				data: {id_ficha: $("#ficha").val()},
				dataType: 'JSON',
				success: function(respuesta){
					$(".box-header>h2").html("Versiones la ficha " + $("#ficha option:selected").html());

					//Se inicializa el contador de versiones
					cont = 1;

					//Se recorren las versiones obtenidas
					$.each(respuesta, function(index, value){
						//Se imprimen los datos
						$("#versiones").append(
							//Se imprimen las versiones
							"<b>" + cont + ".</b> " + value.Version + "<br/>"
						);//Fin append

						//Se aumenta el contador
						cont++;
					});//Fin each
				}//Fin success
			});//Fin ajax
			
			//Cuando se presione enter
			$('form').on('submit', function(){
				//Se almacenan los daos a enviar
				datos = {
					version: $("#nueva_version").val(),
					ficha: $("#ficha").val()
				};

				//Mediante ajax se guarda la version de la ficha
				$.ajax({
					url: "<?php echo site_url('ica/guardar_version_ficha') ?>",
					data: datos,
					type: 'POST',
					success: function(respuesta){
						//Si se guardó correctamente
						if(respuesta == 'true'){
							//Se muestra el mensaje de exito
							$("#mensaje_version").addClass('exito').text('La versión se creó correctamente').fadeIn(2000).fadeOut(3000);
						} else {
							//Si no, se muestra error
							$("#mensaje_version").addClass('error').text('La versión no pudo crearse').fadeIn(2000).fadeOut(3000);
						}//Fin if
					}
				});//Fin ajax

				//Se pone en lista el resultado
				$("#versiones").append(
					"<b>" + cont + ".</b> " + $("#nueva_version").val() + "<br/>"
				);//Fin append

				//Aumentar el contador
				cont++;

				//Se detiene el formulario
				return false;
			});//Fin submit

			//Boton para generar el reporte
			$("#imprimir").on('click', function(){
				//Se genera el reporte
				location.href = "<?php echo site_url('reporte/ICA_0') ?>" + "/" + $("#tramo").val();
			});//Fin click
		}//Fin if ficha
	});//Fin document.ready
</script>

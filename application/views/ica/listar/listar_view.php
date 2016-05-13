<div id="vista_listar">
	<div id="info_menu" class="hero-unit">
		Por favor seleccione las opciones del menú lateral para visualizar los anexos correspondientes
	</div>
</div>
<script type="text/javascript">
	//Cuando el DOM esté listo
	$(document).ready(function(){
		console.log('Cargando módulo...');

		//Ficha
		$("#ficha").on('change', function(){
			//Si se selecciona algún valor
			if ($(this).val() != "") {
				//Se crea un arreglo JSON con los datos recogidos del menú lateral
				filtro = {
					periodo: $("#periodo").val(),
					tramo: $("#tramo").val(),
					formato: $("#formato").val(),
					ficha: $("#ficha").val()
				};

				//Se crea una url 
				url = "<?php echo site_url('ica/listar_archivos_subidos'); ?>" + "/" + filtro.periodo + "/" + "/" + filtro.ficha;

				console.log(filtro);
			} else {
				//Se envia una url diferente
				url = "<?php echo site_url('ica/listar_archivos_subidos'); ?>" + "/null/null/null" ;
			}

			//Se carga la url que se definió
			$("#vista_listar").load(url);//Fin load
		});//Fin change
	});//Fin document.ready
</script>
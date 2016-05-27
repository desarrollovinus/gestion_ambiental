<legend>Sus datos fueron registrados exitosamente.<br> <span>Ahora, si dispone de una hoja de vida en PDF, proceda a subirla.</span></legend>

<!-- Botón -->
<input type="button" id="subir" class="btn btn-info inline" value="Seleccionar archivo y subir" />

<div class="span12">
	<span id="mensaje_archivo" class="ocultar"></span>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    	// //Declaración de variables
    	// var categoria = $("#categoria");
    	// var subcategoria = $("#subcategoria");

    	// //Se carga la lista con archivos subidos
    	// $("#archivos_subidos").load("<?php // echo site_url('hoja_vida/listar_archivos') ?>", {'id_hoja_vida': "<?php // echo $id_hoja_vida; ?>"})

    	datos = {
	    	id_hoja_vida: "<?php echo $id_hoja_vida; ?>"
        }//Fin datos
        console.log(datos);

    	//Se prepara la subida del archivo
		new AjaxUpload('#subir', {
			action: '<?php echo site_url("empleabilidad/subir_archivo"); ?>',
			type: 'POST',
			data: datos,
			onSubmit : function(file , ext){
				//Se valida la extension del archivo
				if (!(ext && /^(pdf|PDF)$/.test(ext))){
					//Se muestra el error
					$("#mensaje_archivo").html('El archivo no es válido. Debe subir un archivo PDF').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
			      	return false;
				} else {
					//Se muestra la imagen cargando
					$("#mensaje_archivo").fadeIn().html("<img src='<?php echo base_url().'img/cargando.gif'; ?>' />");
				} // if

				//Se arregan al arreglo JSON los datos a enviar
				datos['id_subcategoria'] = 1;
			}, // onsubmit
			onComplete: function(file, respuesta){
				console.log(respuesta);
				//Si la respuesta es true
				if(respuesta == "true"){
					//Se muestra el mensaje de exito
					$("#mensaje_archivo").html('El archivo se subió correctamente.').removeClass('error').addClass('exito').fadeIn(2000).delay(3000);
					$("#subir").hide("slow");
					$("span").hide("slow");
				}
			} // oncomplete
		}); // AjaxUpload
    });
</script>
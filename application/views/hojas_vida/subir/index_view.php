<?php
//Se obtiene el id de la hoja de vida
$id_hoja_vida = $this->uri->segment(3);

//Se cargan las categorías
$categorias = $this->hoja_vida_model->listar_categorias();
?>

<!-- Permiso para subir archivos -->
<?php if (isset($acceso[60])) { ?>
	<form class="form-inline">
		<div class="span3">
			<!-- Categoría -->
			<label for="categoria">Categoría</label>
			<select id="categoria" class="input-large inline" autofocus>
			    <option value="">Seleccione...</option>
			    <?php foreach ($categorias as $categoria) { ?>
				    <option value="<?php echo $categoria->Pk_Id_Hoja_Vida_Categoria; ?>"><?php echo $categoria->Nombre; ?></option>
			    <?php } ?>
			</select>
		</div>

		<div class="span3">
			<!-- subcategoría -->
			<label for="subcategoria">Subcategoría</label>
			<select id="subcategoria" class="input-large inline">
			    <option value="">Seleccione la categoría</option>
			</select>
		</div>

		<div class="span3">
			<p></p>
			<!-- Botón -->
			<input type="button" id="subir" class="btn btn-info inline" value="Seleccionar archivo y subir" />
		</div>

		<div class="span12">
			<span id="mensaje_archivo" class="ocultar"></span>
		</div>
	</form>

	<div class="clear"></div>
	<legend></legend>
<?php } ?>
<!-- Permiso para subir archivos -->

<!-- Permiso para visualizar o borrar archivos -->
<?php if (isset($acceso[61]) || isset($acceso[62])) { ?>
	<div id="archivos_subidos"></div>

	<script type="text/javascript">
	    $(document).ready(function(){
	    	//Declaración de variables
	    	var categoria = $("#categoria");
	    	var subcategoria = $("#subcategoria");

	    	//Se carga la lista con archivos subidos
	    	$("#archivos_subidos").load("<?php echo site_url('hoja_vida/listar_archivos') ?>", {'id_hoja_vida': "<?php echo $id_hoja_vida; ?>"})

	    	categoria.on("change", function(){
	    		if (categoria.val() != "") {
	    			// Se consultan las subcategorías vía ajax
		    		subcategorias = enviar_ajax_json("<?php echo site_url('hoja_vida/cargar_subcategorias') ?>", {id_categoria: categoria.val()});

	                //Se resetea el select y se agrega una option vacia
	                subcategoria.html('').append("<option value=''>Seleccione...</option>");

		    		//Se recorren las subcategorías
		            $.each(subcategorias, function(key, val){
		                //Se agrega cada tramo al select
		                subcategoria.append("<option value='" + val.Pk_Id_Hoja_Vida_Subcategoria + "'>" + val.Nombre + "</option>");
		            })//Fin each
	    		};
	    	});//change categoria

	    	datos = {
		    	id_hoja_vida: "<?php echo $id_hoja_vida; ?>"
	        }//Fin datos

	    	//Se prepara la subida del archivo
			new AjaxUpload('#subir', {
				action: '<?php echo site_url("hoja_vida/subir_archivo"); ?>',
				type: 'POST',
				data: datos,
				onSubmit : function(file , ext){
					console.log(file);
					//Se valida la extension del archivo
					if (!(ext && /^(pdf|PDF)$/.test(ext))){
						//Se muestra el error
						$("#mensaje_archivo").html('El archivo no es válido. Debe subir un archivo PDF').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
				      	return false;
					} else if(categoria.val() == "" || subcategoria.val() == "") {
						//Se muestra el error
						$("#mensaje_archivo").html('Seleccione una categoría y subcategoría.').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");
						return false;
					} else {
						//Se muestra la imagen cargando
						$("#mensaje_archivo").fadeIn().html("<img src='<?php echo base_url().'img/cargando.gif'; ?>' />");
					} // if

					//Se arregan al arreglo JSON los datos a enviar
					datos['id_subcategoria'] = subcategoria.val();
				}, // onsubmit
				onComplete: function(file, respuesta){
					//Si la respuesta es true
					if(respuesta == "true"){
						//Se muestra el mensaje de exito
						$("#mensaje_archivo").html('El archivo se subió correctamente.').removeClass('error').addClass('exito').fadeIn(2000).delay(3000).fadeOut("slow");

						//Se carga la lista con archivos subidos
	    				$("#archivos_subidos").load("<?php echo site_url('hoja_vida/listar_archivos') ?>", {'id_hoja_vida': "<?php echo $id_hoja_vida; ?>"})
					} else {
						//Se muestra el mensaje de error
						$("#mensaje_archivo").html('Ha ocurrido un error al subir el achivo.').removeClass('exito').addClass('error').fadeIn(2000).delay(3000).fadeOut("slow");

						return false;
					}
				} // oncomplete
			}); // AjaxUpload
	    });
	</script>
<?php } ?>
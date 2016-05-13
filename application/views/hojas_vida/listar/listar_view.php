<?php
// Validar contratistas
$validar_contratistas = $this->hoja_vida_model->validar_contratistas_usuario();

// Si tiene marcado como todos los contratistas
if($validar_contratistas == 1){
	// Se cargan todos los subcontratistas
	$subcontratistas = $this->ica_model->cargar_subcontratistas();
} else {
	// Se cargan solo los subcontratistas del usuario
	$subcontratistas = $this->ica_model->cargar_subcontratistas_usuario();	
} // if

$oficios = $this->hoja_vida_model->cargar_oficios();
$municipios = $this->solicitud_model->cargar_municipios();
?>

<div class="span2">
	<!-- ¿Vinculado? -->
	<div class="control-group">
		<label class="control-label" for="select_vinculado">¿Vinculado?</label>
		<div class="controls">
			<select id="select_vinculado"class="select_lateral">
				<option value="">Todos</option>
				<option value="1">Si</option>
				<option value="0">No</option>
			</select>
		</div>
	</div><!-- ¿Vinculado? -->
</div>

<div class="span2">
	<!-- Contratista -->
	<div class="control-group">
		<label class="control-label" for="select_contratista">Contratista</label>
		<div class="controls">
			<select id="select_contratista" class="select_lateral">
				<?php
				// Si está marcado como todos
				if($validar_contratistas == 1){
					echo '<option value="0">Todos</option>';
				} // if

				// Si no hay contratistas configurados
				if (count($subcontratistas) == 0){
					echo '<option value="N">Ninguno</option>';
				} else {
					// Recorrido
					foreach ($subcontratistas as $subcontratista) {
						echo '<option value="'.$subcontratista->Pk_Id_Valor.'">'.$subcontratista->Nombre.'</option>';
					} // foreach
				} // if
				?>
			</select>
		</div>
	</div><!-- Contratista -->
</div>

<div class="span2">
	<!-- ¿Calificado? -->
	<div class="control-group">
		<label class="control-label" for="select_calificado">¿Calificado?</label>
		<div class="controls">
			<select id="select_calificado"class="select_lateral">
				<option value="">Todos</option>
				<option value="1">Si</option>
				<option value="0">No</option>
			</select>
		</div>
	</div><!-- ¿Calificado? -->
</div>

<div class="span2">
	<!-- Oficio -->
	<div class="control-group">
		<label class="control-label" for="select_oficio">Cargo / Oficio</label>
		<div class="controls">
			<select id="select_oficio"class="select_lateral">
				<option value="">Todos</option>
				<?php foreach ($oficios as $oficio) { ?>
					<option value="<?php echo $oficio->Pk_Id_Oficio; ?>"><?php echo $oficio->Nombre; ?></option>
				<?php } ?>
			</select>
		</div>
	</div><!-- Oficio -->
</div>

<div class="span2">
	<!-- Municipio -->
	<div class="control-group">
		<label class="control-label" for="select_municipio">Municipio</label>
		<div class="controls">
			<select id="select_municipio"class="select_lateral">
				<option value="">Todos</option>
				<?php foreach ($municipios as $municipio) { ?>
					<option value="<?php echo $municipio->Pk_Id_Municipio; ?>"><?php echo $municipio->Nombre; ?></option>
				<?php } ?>
			</select>
		</div>
	</div><!-- Municipio -->
</div>

<div class="span2">
	<!-- ¿Verificado? -->
	<div class="control-group">
		<label class="control-label" for="select_verificado">¿Verificado?</label>
		<div class="controls">
			<select id="select_verificado"class="select_lateral">
				<option value="">Todos</option>
				<option value="1">Si</option>
				<option value="0">No</option>
			</select>
		</div>
	</div><!-- ¿Verificado? -->
</div>

<div class="row-fluid">
	<!-- Tabla -->
	<div id="cont_tabla"></div>
</div>

<script type="text/javascript">
	function cargar(datos){
		// Si el vinculado es 0
		if($("#select_vinculado").val() == "0"){
			// El contratista es 0 (todos)
			datos.contratista = "0";
		} // if
		// console.log(datos);

		// Cara de la tabla
		$("#cont_tabla").load("<?php echo site_url('hoja_vida/tabla'); ?>", {"datos": datos});

		// Imagen de carga
		$("#cont_tabla").html('').append('<div align="center">Cargando las hojas de vida, por favor espere. Esta operación puede tardar...<br><img src="' + '<?php echo base_url(); ?>' + 'img/cargando.gif"/></div>');
	} // cargar

    $(document).ready(function(){
    	// Datos a enviar
		datos = {
			"vinculado": "",
			"contratista": $("#select_contratista").val(),
			"calificado": $("#select_calificado").val(),
			"oficio": $("#select_oficio").val(),
			"municipio": $("#select_municipio").val(),
			"verificado": $("#select_verificado").val()
		} // datos

		// De entrada, se carga la tabla con unos valores por defecto
    	cargar(datos);

    	// Cuando un select cambie
    	$("[id^='select']").on("change", function(){
    		// Datos a enviar
    		datos = {
    			"vinculado": $("#select_vinculado").val(),
    			"contratista": $("#select_contratista").val(),
				"calificado": $("#select_calificado").val(),
				"oficio": $("#select_oficio").val(),
				"municipio": $("#select_municipio").val(),
				"verificado": $("#select_verificado").val()
    		} // datos

    		// Carga de la interfaz
    		cargar(datos);
    	}); // change
    });//document.ready
</script>
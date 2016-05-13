<?php
//Se hacen todos los llamados a bases de datos para alimentar los arreglos
$meses = $this->solicitud_model->listar_meses();
$anios = $this->solicitud_model->listar_anios();
$tramos =  $this->solicitud_model->cargar_tramos();
$subcontratistas = $this->ica_model->cargar_subcontratistas();
$materiales = $this->ica_model->cargar_material_dispuesto();
$escombreras = $this->ica_model->cargar_escombreras();
$usos = $this->ica_model->cargar_usos();
?>
<div class="row-fluid">
	<!--Material dispuesto-->
	<div class="span6">
		<legend>Datos material dispuesto</legend>
		<div class="row-fluid">
			<div class="span6">
				<!--Mes-->
				<label for="mes">Mes</label>
				<select id="mes" class="select_lateral" autofocus>
					<?php foreach ($meses as $mes) { ?>
						<option value="<?php echo $mes['Numero'] ?>"><?php echo $mes['Nombre']; ?></option>
					<?php } ?>
				</select>
				
				<!--Año-->
				<label for="anio">Año</label>
				<select id="anio" class="select_lateral">
					<?php foreach ($anios as $anio) { ?>
						<option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
					<?php } ?>
				</select>
				
				<!--Tramo-->
				<label for="tramo">Tramo</label>
				<select id="tramo" class="select_lateral">
					<option>Seleccione un tramo</option>
					<?php foreach ($tramos as $tramo){ ?>
						<option value="<?php echo $tramo->Pk_Id_Tramo; ?>"><?php echo $tramo->Nombre; ?></option>
					<?php } ?>
				</select>
				
				<!--Subcontratista-->
				<label for="subcontratista">Subcontratista</label>
				<select id="subcontratista" class="select_lateral">
					<option>Seleccione un subcontratista</option>
					<?php foreach ($subcontratistas as $subcontratista) { ?>
						<option value="<?php echo 'o'; ?>"><?php echo $subcontratista->Nombre; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="span6">
				<!--Material dispuesto-->
				<label for="material_dispuesto">Material dispuesto</label>
				<select id="material_dispuesto" class="select_lateral">
					<option>Seleccione el material dispuesto</option>
					<?php foreach ($materiales as $material) { ?>
						<option value="<?php echo $material->Pk_Id_Valor; ?>"><?php echo $material->Nombre; ?></option>
					<?php } ?>
				</select>
				
				<!--Escombrera-->
				<label for="zona_deposito">Zona de depósito - Escombrera</label>
				<select id="zona_deposito" class="select_lateral">
					<option>Seleccione la zona de depósito</option>
						<?php foreach ($escombreras as $escombrera) { ?>
							<option value="<?php echo $escombrera->Pk_Id_Valor; ?>"><?php echo $escombrera->Nombre; ?></option>
						<?php } ?>
				</select>
				
				<!--Abscisa-->
				<label for="abscisa">Abscisa</label>
				<input type="text" id="abscisa" class="select_lateral" />

				<!--Abscisa-->
				<label for="volumen">Volúmen</label>
				<input type="text" id="volumen" class="select_lateral" placeholder="En m3" />
			</div>
		</div>
	</div>
	
	<!--Material excavado-->
	<div class="span6">
		<legend>Datos material excavado</legend>
		<div class="row-fluid">
			<div class="span6">
				<!--Mes-->
				<label for="mes">Mes</label>
				<select id="mes" class="select_lateral">
					<?php foreach ($meses as $mes) { ?>
						<option value="<?php echo $mes['Numero'] ?>"><?php echo $mes['Nombre']; ?></option>
					<?php } ?>
				</select>

				<!--Año-->
				<label for="anio">Año</label>
				<select id="anio" class="select_lateral">
					<?php foreach ($anios as $anio) { ?>
						<option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
					<?php } ?>
				</select>
				
				<!--Tramo-->
				<label for="tramo">Tramo</label>
				<select id="tramo" class="select_lateral">
					<option>Seleccione un tramo</option>
					<?php foreach ($tramos as $tramo){ ?>
						<option value="<?php echo $tramo->Pk_Id_Tramo; ?>"><?php echo $tramo->Nombre; ?></option>
					<?php } ?>
				</select>

				<!--Subcontratista-->
				<label for="subcontratista">Subcontratista</label>
				<select id="subcontratista" class="select_lateral">
					<option>Seleccione un subcontratista</option>
					<?php foreach ($subcontratistas as $subcontratista) { ?>
						<option value="<?php echo 'o'; ?>"><?php echo $subcontratista->Nombre; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="span6">
				<!--Material excavado-->
				<label for="material_excavado">Material excavado</label>
				<select id="material_excavado" class="select_lateral">
					<option>Seleccione el material excavado</option>
					<?php foreach ($materiales as $material) { ?>
						<option value="<?php echo $material->Pk_Id_Valor; ?>"><?php echo $material->Nombre; ?></option>
					<?php } ?>
				</select>

				<!--Uso-->
				<label for="uso">Uso</label>
				<select id="uso" class="select_lateral">
					<option>Seleccione el uso del material</option>
					<?php foreach ($usos as $uso) { ?>
						<option value="<?php echo $uso->Pk_Id_Valor; ?>"><?php echo $uso->Nombre; ?></option>
					<?php } ?>
				</select>

				<!--Abscisa-->
				<label for="abscisa">Abscisa</label>
				<input type="text" id="abscisa" class="select_lateral" />

				<!--Abscisa-->
				<label for="volumen">Volúmen</label>
				<input type="text" id="volumen" class="select_lateral" placeholder="En m3" />
			</div>
		</div>
	</div>
	
	<!--Boton de guardado-->
	<button id="guardar" class="btn btn-large btn-block btn-primary btn-success" type="button">Guardar Indicador</button>
	
	<br/>
	<legend></legend>
	<div class="registro">
		<span class="mes">Diciembre</span>
		<span class="anio">2014</span>
		<span class="tramo">Niquía - Hatillo</span>
		<span class="empresa">Perforex</span>
		<span class="material_dispuesto">Descapote</span>
		<span cass="escombrera">ZODME N° 6 L.A Barbosa - Pradera</span>
		<span class="abscisa">K 8+200</span>
		<span class="volumen">200</span>
	</div>
</div>

<script type="text/javascript">
	//Cuando el DOM este listo
	$(document).ready(function(){
		//Se selecciona por defecto el mes actual
		$("#mes option[value='<?php echo date('n'); ?>']").attr('selected', true);

		//Se selecciona por defecto el año actual
		$("#anio option[value='<?php echo date('Y'); ?>']").attr('selected', true);

		//
		$("#guardar").on('click', function(){
			console.log('Clic');
		});//Fin guardar
	});//Fin document.ready
</script>

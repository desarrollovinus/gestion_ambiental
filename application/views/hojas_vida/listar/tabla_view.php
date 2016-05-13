<?php
// Carga de permisos y datos necesarios
$acceso = $this->session->userdata('Acceso');
?>

<table>
	<thead>
		<tr>
			<th>Nro.</th>
			<th>Nombres</th>
			<th>Documento</th>
			<th>Contratista</th>
			<th>Vinculado</th>
			<th>Ubicación</th>
			<th width="30px">Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$cont = 1;
		foreach ($curriculos as $curriculo) {
		?>
			<tr>
				<td><?php echo $cont; ?></td>
				<td><?php echo $curriculo->Nombres; ?></td>
				<td class="derecha"><?php echo $curriculo->Documento; ?></td>
				<td><?php echo $curriculo->Subcontratista; ?></td>
				<td><?php echo $curriculo->Contratado; ?></td>
				<td><?php echo $curriculo->Ubicacion_Fisica; ?></td>
				<td>
					<!-- Se activa el ícono si puede ver o editar-->
					<?php if (isset($acceso[58]) || isset($acceso[59])) { ?>
						<a href="<?php echo site_url('hoja_vida/crear').'/'.$curriculo->Pk_Id_Hoja_Vida; ?>" title="Ver y editar hoja de vida" target="_blank"><i class="icon-edit"></i></a> 
			    	<?php } ?>

			    	<!--Validar permiso-->
					<?php if (isset($acceso[60]) || isset($acceso[61]) || isset($acceso[62])) { ?>
						<a href="<?php echo site_url('hoja_vida/subir').'/'.$curriculo->Pk_Id_Hoja_Vida; ?>" title="Administrar archivos escaneados" target="_blank"><i class="icon-folder-open"></i></a> 
			    	<?php } ?>

			    	<!--Validar permiso-->
					<?php if (isset($acceso[68])) { ?>
						<a href="<?php echo site_url('hoja_vida/agregar_capacitacion').'/'.$curriculo->Pk_Id_Hoja_Vida; ?>" title="Agregar capacitación" target="_blank"><i class="icon-book"></i></a> 
			    	<?php } ?>
				</td>
			</tr>
		<?php
		$cont++;
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
    	// $("#total_curriculos").val("x");

        // Inicialización de la tabla
        $('table').dataTable( {
            "bProcessing": true,
        }); // Tabla
    });//document.ready
</script>
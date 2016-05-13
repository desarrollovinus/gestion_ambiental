<?php
// Se consulta la maquinaria en base de datos
$maquinas = $this->siso_model->listar_inspeccion_maquinaria(null);
?>

<table id="tabla">
    <thead>
        <tr>
            <th>Nro.</th>
			<th>Vehículo</th>
			<th>Operador</th>
			<th>Fecha de creación</th>
			<th>hallazgos</th>
			<th width="30px">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
		$cont = 1;
		foreach ($maquinas as $maquina) {
		?>
        <tr>
			<td class="derecha"><?php echo $cont; ?></td>
			<td class="nombres"><?php echo $maquina->Nombre; ?></td>
			<td><?php echo $maquina->Operador; ?></td>
			<td><?php echo $maquina->Fecha_Creacion; ?></td>
			<td class="derecha"><?php echo $maquina->Hallazgos; ?></td>
            <td>
            	<!-- Se imprime el reporte si hay permisos -->
				<?php if (isset($acceso[72])) { ?>
					<a href="<?php echo site_url('reporte/inspeccion_maquinaria').'/'.$maquina->Pk_Id_Siso_Maquinaria; ?>" title="Imprimir planilla" ><i class="icon-list-alt"></i></a> 
		    	<?php } ?>

				<!--Validar permiso-->
				<?php //if (isset($acceso[60]) || isset($acceso[61]) || isset($acceso[62])) { ?>
					<!-- <a href="<?php //echo site_url('hoja_vida/subir').'/'.$curriculo->Pk_Id_Hoja_Vida; ?>" title="Administrar archivos escaneados" target="_blank"><i class="icon-folder-open"></i></a>  -->
		    	<?php //} ?>

		    	<!--Validar permiso-->
				<?php //if (isset($acceso[68])) { ?>
					<!-- <a href="<?php //echo site_url('hoja_vida/agregar_capacitacion').'/'.$curriculo->Pk_Id_Hoja_Vida; ?>" title="Agregar capacitación" target="_blank"><i class="icon-book"></i></a>  -->
		    	<?php //} ?>
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
    	$("#total_curriculos").val("<?php echo $cont; ?>");

        // Inicialización de la tabla
        $('#tabla').dataTable( {
            "bProcessing": true,
        }); // Tabla
    });//document.ready
</script>
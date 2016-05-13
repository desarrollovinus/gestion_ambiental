<div id="container" class="graficos"></div>

<?php
$estados = $this->solicitud_model->cargar_estados();
$areas = $this->solicitud_model->cargar_areas_encargadas();
?>

<table id="datatable" class="tabla_graficos ocultar">
	<thead>
		<tr>
			<!--estados-->
			<th></th>
			<?php foreach ($estados as $estado) { ?>
			<th><?php echo $estado->Nombre; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($areas as $area) { ?>
			<tr>
				<th><?php echo $area->Nombre; ?></th>
				
				<!--Recorrido de estados-->
				<?php
				foreach ($estados as $estado){
					$solicitudes = $this->reporte_model->contar_solicitudes_area($area->Pk_Id_Area_Encargada, $estado->Pk_Id_Solicitud_Estado);

					foreach ($solicitudes as $solicitud) {
					?>
					<td><?php echo $solicitud->Total; ?></td>
					<?php
					}//Fin foreach
					?>
				
				<?php }//Fin foreach ?>
			</tr>
		<?php }//Fin foreach ?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function (){
		console.log('')
	    $('#container').highcharts({
	        data: {
	            table: document.getElementById('datatable'),
	            color: '#000000'
	        },
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'Consolidado de solicitudes por áreas'
	        },
	        yAxis: {
	            allowDecimals: false,
	            title: {
	                text: 'Número de solicitudes'
	            }
	        },
	        tooltip: {
	            formatter: function() {
	                return '<b>'+ this.series.name +':</b><br/>'+
	                    this.y +' '+ this.x.toLowerCase();
	            	}
	        	}

    	});
	});
</script>
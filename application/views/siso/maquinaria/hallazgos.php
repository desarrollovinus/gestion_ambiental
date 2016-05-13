<!-- Carga de hallazgos -->
<?php $hallazgos = $this->siso_model->cargar_hallazgos(); ?>

<!-- Modal Editar -->
<div id="modal_editar" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Acción de mejora</h3>
    </div>
    <div class="modal-body">
        <input id="id_hallazgo" type="hidden">
        
        <textarea id="mejora" rows="3" class="span12" autofocus></textarea>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a id="btn_guardar" href="#" class="btn btn-primary">Guardar</a>
    </div>
</div><!-- Modal Eliminar -->

<table id="tabla">
    <thead>
        <tr>
            <th width="30px">Nro.</th>
			<th>Vehículo</th>
			<th>Fecha</th>
            <th>Hallazgo</th>
			<th>Estado</th>
			<th width="30px">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
		$cont = 1;
		foreach ($hallazgos as $hallazgo) {
		?>
        <tr>
			<td class="derecha"><?php echo $cont++; ?></td>
			<td class="nombres"><?php echo $hallazgo->Maquina; ?></td>
            <td class="nombres"><?php echo date('Y-m-d (h:i)', strtotime($hallazgo->Fecha_Creacion)); ?></td>
            <td class="nombres"><?php echo $hallazgo->Descripcion; ?></td>
			<td class="nombres"><?php if($hallazgo->Corregido == '1'){echo "Resuelto";}else{echo "Pendiente";} ?></td>
            <td>
            	<!--Validar permiso-->
                <?php //if (isset($acceso[68])) { ?>
                    <a href="javascript:editar(<?php echo $hallazgo->Pk_Id_Siso_Maquinaria_Estado; ?>)" title="Implementar mejora"><i class="icon-edit"></i></a> 
                <?php //} ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<br><br>

<!--Validar permiso-->
<?php //if (isset($acceso[71])) { ?>
	<button class="btn btn-success btn-block" type="button" id="reporte_hallazgos" >Generar reporte</button>
<?php //} ?>

<script type="text/javascript">
    /**
     * [editar description]
     * @param  {[type]} id_hallazgo [description]
     * @return {[type]}             [description]
     */
    function editar(id_hallazgo){
        $("#id_hallazgo").val(id_hallazgo);

        // Se abre el modal
        $('#modal_editar').modal('show');

        console.log($("#id_hallazgo").val())
    }

    // Cuando el DOM esté listo
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla').dataTable( {
            "bProcessing": true,
        }); // Tabla

        // Reporte de hallazgos
		$("#reporte_hallazgos").on("click", function(){
			// Redireccionar
			location.href = '<?php echo site_url("reporte/inspeccion_maquinaria_hallazgos"); ?>';
		});

        // Guardar 
        $("#btn_guardar").on("click", function(){
            // AArreglo con los datos
            datos = {
                "Corregido": 1,
                "Fk_Id_Usuario": "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>",
                "Accion_Mejora": $("#mejora").val(),
                "Fecha_Mejora": "<?php echo date('Y-m-d') ?>"
            }
            console.log(datos);

            //Se calcula la edad
            guardar = enviar_ajax("<?php echo site_url('siso/actualizar_estado_maquinaria') ?>", {datos: datos, id: $("#id_hallazgo").val()});

            console.log(guardar);

            // Se cierra el modal
            $('#modal_editar').modal('hide');
        });
    });//document.ready
</script>



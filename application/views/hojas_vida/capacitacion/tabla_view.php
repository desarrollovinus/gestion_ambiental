<!-- Se listan las capacitaciones -->
<?php $capacitaciones = $this->hoja_vida_model->cargar_capacitaciones(); ?>

<h3>Capacitaciones creadas</h3>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="tabla" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro">Nro</th>
                <th class="alinear_centro">Nombre</th>
                <th class="alinear_centro">Inicio</th>
                <th class="alinear_centro">Horas</th>
                <th class="alinear_centro" width="10%">Opc.</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
            <!-- Se recorren las capacitaciones -->
            <?php
            $cont = 1;
            foreach ($capacitaciones as $capacitacion) { 
            ?>
                <tr>
                    <td class="derecha"><?php echo $cont; ?></td>
                    <td><?php echo $capacitacion->Nombre; ?></td>
                    <td><?php echo $capacitacion->Fecha_Inicio; ?></td>
                    <td class="derecha"><?php echo $capacitacion->Horas; ?></td>
                    <td></td>
                </tr>
            <?php
            $cont++;
            }
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla').dataTable( {
            "bProcessing": true,
        }); // Tabla
        
        //valor = ajax("<?php echo site_url('crm/actualizar') ?>", {"tipo": "condicional"}, 'JSON');
        //imprimir(valor);        
    });//document.rady
</script>
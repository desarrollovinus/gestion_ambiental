<?php
//Se ejecutan los modelos necesarios
$total_solicitudes = $this->inicio_model->total_solicitudes();
$total_ica = $this->inicio_model->total_ica();
$formatos = $this->ica_model->cargar_formatos();
$interacciones = $this->auditoria_model->ultimas_actualizaciones($this->session->userdata('Pk_Id_Usuario'));
?>
<div class="row-fluid">
    <div class="span6">
        <div class="well">
            <h4>Sus últimas interacciones:</h4>
            <?php foreach ($interacciones as $interaccion) { ?>
                <h6><?php echo $interaccion->Detalle; ?>
                    <small class="time1" title="<?php echo $interaccion->Fecha_Hora; ?>"><?php echo $this->auditoria_model->formato_fecha($interaccion->Fecha_Hora); ?></small>
                <h6>
            <?php } ?>
        </div>
    </div>

    <div class="span6">
        <div class="row-fluid">
            <!--Validar permiso-->
            <?php if (isset($acceso[59])) { ?>
                <!--Estados de las hojas de vida verificada-->
                <div class="span12">
                    <div class="box-header"><h2>Proceso de verificación de hojas de vida</h2></div>
                    <div class="box-content">
                        <div class="row-fluid">
                            <?php
                            $no_verificados = $this->hoja_vida_model->contar_verificados('0');
                            $no_verificados_porcentaje = $this->hoja_vida_model->porcentaje_verificacion($no_verificados);
                            $verificados = $this->hoja_vida_model->contar_verificados('1');
                            $verificados_porcentaje = $this->hoja_vida_model->porcentaje_verificacion($verificados);
                            ?>
                            <!--Caja de hojas de vida-->
                            <div class="span3 box-small">
                                <!--Total de hojas ded vida -->
                                <a title="<?php echo number_format($no_verificados, 0, '', '.'); ?> sin verificar" class="box-small-link" href="<?php echo site_url('hoja_vida'); ?>">
                                    <!--Total de hojas de vida  por estado-->
                                    <div><?php echo number_format($no_verificados, 0, '', '.'); ?></div>
                                </a>

                                <!--Porcentaje-->
                                <span id="notificacion_no_verificados" class="notification"><?php echo number_format($no_verificados_porcentaje, 2, ',', '.').' %'; ?></span>
                                <!--Nombre del estado-->
                                <div class="box-small-title">Sin verificar</div>
                            </div>

                            <!--Caja de hojas de vida-->
                            <div class="span3 box-small">
                                <!--Total de hojas ded vida -->
                                <a title="<?php echo number_format($verificados, 0, '', '.'); ?> verificados" class="box-small-link" href="<?php echo site_url('hoja_vida'); ?>">
                                    <!--Total de hojas de vida  por estado-->
                                    <div><?php echo number_format($verificados, 0, '', '.'); ?></div>
                                </a>

                                <!--Porcentaje-->
                                <span id="notificacion_verificados" class="notification"><?php echo number_format($verificados_porcentaje, 2, ',', '.').' %'; ?></span>
                                <!--Nombre del estado-->
                                <div class="box-small-title">Verificadas</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="row-fluid">
            <!--Validar permiso-->
            <?php if (isset($acceso[1])) { ?>
            <!--Estados de las solicitudes-->
            <div class="span12">
                <div class="box-header"><h2>Solicitudes</h2></div>
                <div class="box-content">
                    <div class="row-fluid">
                        <!--Recorrido para pintar las cajas-->
                        <?php foreach ($total_solicitudes as $total): ?>
                            
                            <!--Caja de solicitudes-->
                            <div class="span3 box-small">
                                <!--Validar permiso-->
                                <?php if (isset($acceso[18])) { $url = site_url('solicitud/listar/'.$total->Pk_Id_Solicitud_Estado); } else {$url = "#"; } ?>

                                <!--Total de solicitudes-->
                                <a title="<?php echo number_format($total->Count, 0, '', '.'); ?> solicitudes" class="box-small-link" href="<?php echo $url; ?>">
                                    <!--Total de solicitudes por estado-->
                                    <div><?php echo number_format($total->Count, 0, '', '.'); ?></div>
                                </a>

                                <!--Porcentaje-->
                                <span id="notificacion<?php echo $total->Pk_Id_Solicitud_Estado; ?>" class="notification"><?php echo number_format($total->Porcentaje, 0).' %'; ?></span>
                                <!--Nombre del estado-->
                                <div class="box-small-title"><?php echo $total->Nombre; ?></div>
                            </div>
                            
                        <!--Se finaliza el recorrido-->
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="row-fluid">
            <!--Validar permiso módulo-Accion-->
            <?php if (isset($acceso[2])) { ?>
            <!--Estados del ICA-->
            <div class="span12">
                <div class="box-header"><h2>ICA</h2></div>
                <div class="box-content">
                    <div class="row-fluid">
                        <?php ?>
                        <!--Caja de ICA-->
                        <div class="span3 box-small">
                            <!--Validar permiso-->
                            <?php if (isset($acceso[21])) { $url = site_url('ica/listar_anexos'); } else {$url = "#"; } ?>

                            <!--Total de solicitudes-->
                            <a title="<?php echo number_format($total_ica, 0, '', '.'); ?> anexos" class="box-small-link" href="<?php echo $url; ?>">
                                <!--Total de solicitudes por estado-->
                                <div><?php echo number_format($total_ica, 0, '', '.'); ?></div>
                            </a>


                            <!--Porcentaje-->
                            <!--<span class="notification"></span>-->
                            <!--Nombre del estado-->
                            <div class="box-small-title">Anexos subidos</div>
                        </div>
                        <?php ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    //Cuando el DOM este listo 
    $(document).ready(function(){
        //Marca de fecha
        $(".time1").timeago();

        //Se agrega el color respectivo para diferenciar los tipos de solicitudes
        $("#notificacion1").addClass("yellow");
        $("#notificacion_no_verificados").addClass("red");
        $("#notificacion2").addClass("green");
        $("#notificacion_verificados").addClass("blue");
    })
</script>
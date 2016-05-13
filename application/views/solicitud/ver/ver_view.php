<?php
$acciones = $this->solicitud_model->cargar_acciones_emprendidas();
$lugares = $this->solicitud_model->cargar_lugares_recepcion();
$formas = $this->solicitud_model->cargar_formas_recepcion();
$tipos = $this->solicitud_model->cargar_tipos_solicitud();
$funcionarios = $this->solicitud_model->cargar_funcionarios();

$_funcionarios = array('' => '');
$_acciones = array('' => '');
$_lugares = array('' => '');

//Recorrido para traer todas las acciones emprendidas de la base de datos y agregarlos en el dropdown
foreach($acciones as $accion):
    $_acciones[$accion->Pk_Id_Solicitud_Accion] = $accion->Nombre;
endforeach;

//Recorrido para traer todos los tramos de la base de datos y agregarlos en el dropdown
foreach($tramos as $tramo):
    $_tramos[$tramo->Pk_Id_Tramo] = $tramo->Nombre;
endforeach;

//Recorrido para traer todos las areas encargadas de la base de datos y agregarlos en el dropdown
foreach($areas as $area):
    $_areas[$area->Pk_Id_Area_Encargada] = $area->Nombre;
endforeach;

//Recorrido para traer todos los temas de la base de datos y agregarlos en el dropdown
foreach($temas as $tema):
    $_temas[$tema->Pk_Id_Tema] = $tema->Nombre;
endforeach;

//Recorrido para traer todas las formas de recepcion de la base de datos y agregarlos en el dropdown
foreach($formas as $forma):
    $_formas[$forma->Pk_Id_Recepcion_Forma] = $forma->Nombre;
endforeach;

//Recorrido para traer todos los lugares de recepcion de la base de datos y agregarlos en el dropdown
foreach($lugares as $lugar):
    $_lugares[$lugar->Pk_Id_Recepcion_Lugar] = $lugar->Nombre;
endforeach;

//Recorrido para traer todos los tipos de solicitud de la base de datos y agregarlos en el dropdown
foreach($tipos as $tipo):
    $_tipos[$tipo->Pk_Id_Solicitud_Tipo] = $tipo->Nombre;
endforeach;

//Recorrido para traer todo el personal al cual se puede remitir una solicitud y agregarlos en el dropdown
foreach($funcionarios as $funcionario):
    $_funcionarios[$funcionario->Pk_Id_Funcionario] = $funcionario->Nombres.' '.$funcionario->Apellidos;
endforeach;

$solicitud = $this->solicitud_model->ver($id_solicitud);
$seguimientos = $this->solicitud_model->ver_seguimientos($id_solicitud);
//$remisiones = $this->solicitud_model->ver_remision($id_solicitud);
?>

<div class="row-fluid">
    <!--Inicio datos generales-->
    <div class="row-fluid">
        <div class="box-header"><h2>Datos generales</h2></div>
        <div class="box-content">
            <div class="span4">
                <div>
                    <b>Fecha: </b>
                    <div><?php echo $solicitud->Fecha_Creacion; ?></div>
                </div>
                <div>
                    <b>Radicado de entrada: </b>
                    <div id="radicado_entrada" name="edit" title="Haga clic para modificar el radicado" data-toggle="tooltip" ><?php echo $solicitud->Radicado_Entrada; ?></div>
                </div>
                <div>
                    <b>Tramo: </b>
                    <div id="tramo" name="edit" title="Haga clic para seleccionar un tramo diferente" data-toggle="tooltip"><?php echo $solicitud->Tramo; ?></div>
                </div>
                <div>
                    <b>&Aacute;rea encargada: </b>
                    <div id="area_encargada" name="edit" title="Haga clic para seleccionar un &aacute;rea diferente" data-toggle="tooltip"><?php echo $solicitud->Area_Encargada; ?></div>
                </div>
            </div>
            <div class="span4">
                <div>
                    <b>Tema: </b>
                    <div id="tema" name="edit" title="Haga clic para seleccionar otro tema" data-toggle="tooltip"><?php echo $solicitud->Tema; ?></div>
                </div>
                <div>
                    <b>Nombres: </b>
                    <div id="nombres" name="edit" title="Haga clic para modificar los nombres" data-toggle="tooltip"><?php echo $solicitud->Nombres; ?></div>
                </div>
                <div>
                    <b>Direcci&oacute;n: </b>
                    <div id="direccion" name="edit" title="Haga clic para modificar la direcci&oacute;n" data-toggle="tooltip"><?php echo $solicitud->Direccion; ?></div>
                </div>
                <div>
                    <b>Tel&eacute;fono: </b>
                    <div id="telefono" name="edit" title="Haga clic para modificar el tel&eacute;fono" data-toggle="tooltip"><?php echo $solicitud->Telefono; ?></div>
                </div>
            </div>
            <div class="span4">
                <div>
                    <b>Lugar: </b>
                    <div>
                        <?php
                            echo $solicitud->Sector.', '.$solicitud->Municipio;
                        ?>
                    </div>
                </div>
                <div>
                    <b>Forma de recepci&oacute;n</b>
                    <div id="forma_recepcion" name="edit" title="Haga clic para cambiar la forma de recepci&oacute;n" data-toggle="tooltip">
                        <?php echo $solicitud->Forma_Recepcion; ?>
                    </div>
                </div>
                <div>
                    <b>Tipo de solicitud: </b>
                    <div id="tipo_solicitud" name="edit" title="Haga clic para cambiar el tipo de solicitud" data-toggle="tooltip">
                        <?php echo $solicitud->Tipo_Solicitud; ?>
                    </div>
                </div>
                <div>
                    <b>Lugar de recepción: </b>
                    <div id="lugar_recepcion" name="edit" title="Haga clic para cambiar el lugar de recepción" data-toggle="tooltip">
                        <?php echo $solicitud->Lugar_Recepcion; ?>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
            <ul class="nav nav-list">
                <li class="divider"></li>
                <div id="descripcion_solicitud" name="edit" title="Haga clic para modificar la descripci&oacute;n" data-toggle="tooltip"><?php echo $solicitud->Descripcion_Solicitud; ?></div><br/>
            </ul>
        </div>
    </div>
    <!--Fin datos generales-->
    
    <!--Inicio acciones emprendidas-->
    <div class="row-fluid">
        <div class="box-header"><h2>Acciones emprendidas</h2></div>
        <div class="box-content">
            <div>
                <b>Acci&oacute;n emprendida: </b>
                <div>
                    <?php echo form_dropdown('accion_emprendida', $_acciones,  set_value('accion_emprendida', $solicitud->Pk_Id_Solicitud_Accion), 'id="accion_emprendida" class="input-large"'); ?>
                </div>
            </div>
            <!--Si la accion es remision, desplegara este div. Inicialmente esta oculto-->
            <div id="remision" style="display: none">
                <input type="hidden" value="<?php echo $solicitud->Pk_Id_Remision; ?>" id="id_remision"/>
                <legend></legend>
                
                <!--Funcionario-->
                <label>Seleccione el funcionario al que remitir&aacute; *</label>
                <?php echo form_dropdown('funcionario', $_funcionarios,  set_value('funcionario', $solicitud->Pk_Id_Funcionario), 'id="funcionario" class="input-large"'); ?>
                <span class="funcionario"></span>
                
                <!--Fecha-->
                <label for="fecha_remision">Fecha</label>
                <div class="input-append date form_datetime">
                    <input type="text" id="fecha_remision" name="fecha_remision"  value="<?php echo $solicitud->Fecha_Remision; ?>" class="input-large" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                    <span class="fecha_respuesta"></span>
                </div>
                <input class="input-large" type="text" id="radicado_remision" name="radicado_remision" value="<?php echo $solicitud->Radicado_Remision; ?>" placeholder="N&uacute;mero de radicado">
            </div>
            <input type="button" class="btn btn-primary" value="Guardar" id="guardar_accion_emprendida"/>
            <span id="mensaje" class="ocultar vacio">Datos guardados.</span>
            <ul class="nav nav-list">
                <li class="divider"></li>
                <div id="descripcion_accion" name="edit" title="Haga clic para modificar la descripci&oacute;n" data-toggle="tooltip"><?php echo $solicitud->Descripcion_Accion; ?></div>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    <!--Fin acciones emprendidas-->
    
    <!--Inicio seguimientos-->
    <div class="row-fluid">
        <div class="box-header"><h2>Seguimiento</h2></div>
        <div class="box-content">
            <div>
                <?php
                $numero = 0;
                foreach ($seguimientos as $seguimiento):
                $numero++;
                ?>
                <!--Descripcion del seguimiento-->
                <div><b><?php echo $numero ?> - </b><?php echo $seguimiento->Descripcion; ?></div>
                <?php endforeach; ?>
                <div id="seguimiento"></div>
            </div><br/>
            
            <legend></legend>

            <!-- Boton de nuevo seguimiento-->
            <a href="#myModal" role="button" class="btn btn-success" data-toggle="modal">Crear nuevo seguimiento</a>
            <!-- Ventana para nuevo seguimiento -->
            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Escriba el nuevo seguimiento</h3>
                </div>
                <div class="modal-body">
                    <input class="input-large" type="text" id="nuevo_seguimiento" name="seguimiento" style="width: 80%"/>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button class="btn btn-primary" id="guardar">Guardar</button>
                </div>
            </div>
            <!--
            <div id="seguimiento"></div>
            <span onClick="agregar();">
                <i class="icon-plus"></i>
                <input type="button" class="btn btn-link" value="Agregar Seguimiento"/>
            </span>
            -->
        </div>
    </div>
    <!--Fin seguimientos-->
    
    <!--Inicio Solucion-->
    <div class="row-fluid form-inline">
        <div class="box-header"><h2>Respuesta</h2></div>
        <div class="box-content">
            <div id="btm-guardar">
                <label for="fecha_respuesta">Fecha: </label>
                <div class="input-append date form_datetime input" id="fecha_respuesta">
                    <input type="text" id="fecha_cierre" name="fecha_respuesta" value="<?php echo $solicitud->Fecha_Cierre; ?>" class="input-large" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                    <span class="fecha_respuesta"></span>
                </div>
                <input type="button" class="btn btn-primary ocultar" value="Guardar" id="guardar_fecha_respuesta" />    
                <span id="mensaje_fecha" class="ocultar vacio">Fecha guardada.</span>
                
                <div>
                    <b>Radicado: </b>
                    <div id="radicado_salida" name="edit" title="Haga clic para modificar el radicado" data-toggle="tooltip"><?php echo $solicitud->Radicado_Respuesta; ?></div>
                </div>
                <ul class="nav nav-list">
                    <li class="divider"></li>
                </ul>
                <div id="descripcion_respuesta" name="edit" title="Haga clic para modificar la respuesta" data-toggle="tooltip"><?php echo $solicitud->Descripcion_Respuesta; ?></div>
            </div>
        </div>    
    </div>
    <!--Fin solucion-->
</div>

<!--Validar permiso-->
<?php if (isset($acceso[38])) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            //Mensajes de informacion
            $('[name^=edit]').tooltip({
                placement: 'left'
            });
             
            //Radicado de entrada
            $('#radicado_entrada').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/'.'Radicado_Entrada'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Especifique un radicado</label>',
                type   : 'text',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });
            
            //Tramo
            $('#tramo').editable('<?php echo site_url('solicitud/modificar_selects/'.$id_solicitud.'/Fk_Id_Tramo/tbl_tramos/Pk_Id_Tramo'); ?>', { 
                data : '<?php print  json_encode($_tramos); ?>',
                id   : 'elementid',
                name : 'nuevo_valor',
                style   : 'display: block',
                type   : 'select'
            });
            
            //Area encargada
            $('#area_encargada').editable('<?php echo site_url('solicitud/modificar_selects/'.$id_solicitud.'/Fk_Id_Area_Encargada/tbl_area_encargada/Pk_Id_Area_Encargada'); ?>', { 
                data : '<?php print json_encode($_areas); ?>',
                id   : 'elementid',
                name : 'nuevo_valor',
                style   : 'display: block',
                type   : 'select'
            });
            
            //Tema
            $('#tema').editable('<?php echo site_url('solicitud/modificar_selects/'.$id_solicitud.'/Fk_Id_Tema/tbl_temas/Pk_Id_Tema'); ?>', { 
                data : '<?php print  json_encode($_temas); ?>',
                id   : 'elementid',
                name : 'nuevo_valor',
                type   : 'select'
            });
            
            //Nombres
            $('#nombres').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/'.'Nombres'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Escriba el nombre del solicitante</label>',
                type   : 'text',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });
            
            //Direccion
            $('#direccion').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/'.'Direccion'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Especifique una dirección</label>',
                tooltip   : 'Clic para editar...',
                type   : 'text',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });
            
            //Telefono
            $('#telefono').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/'.'Telefono'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Escriba el teléfono</label>',
                tooltip   : 'Clic para editar...',
                type   : 'text',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });
            
            //Tema
            $('#forma_recepcion').editable('<?php echo site_url('solicitud/modificar_selects/'.$id_solicitud.'/Fk_Id_Recepcion_Forma/tbl_recepcion_forma/Pk_Id_Recepcion_Forma'); ?>', { 
                data : '<?php print  json_encode($_formas); ?>',
                id   : 'elementid',
                name : 'nuevo_valor',
                type   : 'select'
            });

            // Lugar de recepción
            $('#lugar_recepcion').editable('<?php echo site_url('solicitud/modificar_selects/'.$id_solicitud.'/Fk_Id_Lugar_Recepcion/tbl_recepcion_lugares/Pk_Id_Recepcion_Lugar'); ?>', { 
                data : '<?php print json_encode($_lugares); ?>',
                id   : 'elementid',
                name : 'nuevo_valor',
                type   : 'select'
            });
            
            //Tipos de solicitud
            $('#tipo_solicitud').editable('<?php echo site_url('solicitud/modificar_selects/'.$id_solicitud.'/Fk_Id_Solicitud_Tipo/tbl_solicitud_tipos/Pk_Id_Solicitud_Tipo'); ?>', { 
                data : '<?php print  json_encode($_tipos); ?>',
                id   : 'elementid',
                name : 'nuevo_valor',
                type   : 'select'
            });
            
            //Descripcion de la solicitud
            $('#descripcion_solicitud').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/'.'Solicitud_Descripcion'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Escriba la descripción de la solicitud</label>',
                type   : 'textarea',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });
            
            if($("#accion_emprendida").val() ==3){
                $("#remision").show('slow');
            }
            
            $('#accion_emprendida').change(function(){
                $("#guardar_accion_emprendida").removeClass('ocultar');
                $("#mensaje").addClass('ocultar');
                if($(this).val() != 3){
                    $("#remision").hide('slow');
                }else{
                    $("#remision").show('slow');
                }
            })
            
            //Boton de guardar accion emprendida
            $("#guardar_accion_emprendida").click(function(){
                datos = {
                    id_remision:  $("#id_remision").val(),
                    solicitud: <?php echo $id_solicitud; ?>,
                    accion_emprendida: $("#accion_emprendida").val(),
                    funcionario: $("#funcionario").val(),
                    fecha_remision: $("#fecha_remision").val(),
                    radicado_remision: $("#radicado_remision").val()
                }
                
                //Se envia por post la informacion de la remision segun sea el caso
                $.post("<?php echo site_url('solicitud/modificar_accion_emprendida'); ?>",
                datos,
                function(msg){
                    $("#guardar_accion_emprendida").addClass('ocultar');
                    $("#mensaje").removeClass('ocultar');
                });//Fin function
            })
            
            //Descripcion accion
            $('#descripcion_accion').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/'.'Accion_Descripcion'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Especifique una descripción</label>',
                type   : 'textarea',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });

            //Se declara el contador que numerara los seguimientos que se agreguen 
            count = <?php echo $numero; ?>;

            //Accion realizada al guardar un seguimiento
            $("#guardar").click(function(){
                //console.log($("#nuevo_seguimiento").val())
                
                //Se envia la descripcion como un array json
                descripcion = {
                    descripcion: $("#nuevo_seguimiento").val()
                }

                //Se envia por post la informacion del seguimiento
                $.post("<?php echo site_url('solicitud/guardar_seguimiento/'.$id_solicitud); ?>",
                    descripcion,
                    function(msg){
                       if(msg){
                             console.log(msg)
                             campo = '<b>' + count + ' - </b>' + msg + '<br/>';
                             $("#seguimiento").append(campo);
                       }
                    }//Fin function
                );//Fin post

                //Se cierra la ventana
                $('#myModal').modal('hide');
                
                //Se aumenta en 1 el contador
                count++;
            })//Fin clic


            //Radicado de salida
            $('#radicado_salida').editable('<?php echo site_url('solicitud/guardar_radicado_salida/'.$id_solicitud); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Especifique una número de radicado de salida</label>',
                type   : 'textarea',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });

            $("#guardar_fecha_respuesta").click(function(){

                //Se prepara el arreglo
                datos = {
                    fecha_cierre: $('#fecha_cierre').val()
                };

                //Se envia por post la informacion de la remision segun sea el caso
                $.post("<?php echo site_url('solicitud/modificar_fecha_respuesta/'.$id_solicitud); ?>",
                datos,
                function(msg){
                    $("#guardar_fecha_respuesta").addClass('ocultar');
                    $("#mensaje_fecha").removeClass('ocultar');
                });//Fin function
            });
            
            //Radicado de salida
            $('#descripcion_respuesta').editable('<?php echo site_url('solicitud/modificar/'.$id_solicitud.'/Respuesta_Descripcion'); ?>', {
                id   : 'elementid',
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Especifique la respuesta</label>',
                type   : 'textarea',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });
        });
    </script>
<?php } ?>
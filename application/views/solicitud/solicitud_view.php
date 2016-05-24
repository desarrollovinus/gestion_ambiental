<?php
//Arreglo con los tramos
$_tramos = array('' => '');
foreach($tramos as $tramo):
    $_tramos[$tramo->Pk_Id_Tramo] = $tramo->Nombre;
endforeach;

//Arreglo con las areas
$_areas= array('' => '');
foreach($areas as $area):
    $_areas[$area->Pk_Id_Area_Encargada] = $area->Nombre;
endforeach;

//Arreglo con los temas
$_temas = array('' => '');
foreach($temas as $tema):
    $_temas[$tema->Pk_Id_Tema] = $tema->Nombre;
endforeach;

//Arreglo con los municipios
$_municipios = array('' => '');
foreach($municipios as $municipio):
    $_municipios[$municipio->Pk_Id_Municipio] = $municipio->Nombre;
endforeach;

//Arreglo con las formas de recepcion
$_formas = array('' => '');
foreach($formas as $forma):
    $_formas[$forma->Pk_Id_Recepcion_Forma] = $forma->Nombre;
endforeach;

//Arreglo con los tipos
$_tipos = array('' => '');
foreach($tipos as $tipo):
    $_tipos[$tipo->Pk_Id_Solicitud_Tipo] = $tipo->Nombre;
endforeach;

//Arreglo con las acciones
$_acciones = array('' => '');
foreach($acciones as $accion):
    $_acciones[$accion->Pk_Id_Solicitud_Accion] = $accion->Nombre;
endforeach;

//Arreglo con los funcionarios
$_funcionarios = array('' => '');
foreach($funcionarios as $funcionario):
    $_funcionarios[$funcionario->Pk_Id_Funcionario] = $funcionario->Nombres.' '.$funcionario->Apellidos;
endforeach;

//Arreglo con los lugares de recepción
$_lugares = array('' => '');
foreach($lugares as $lugar):
    $_lugares[$lugar->Pk_Id_Recepcion_Lugar] = $lugar->Nombre;
endforeach;

//Arreglo con los tipos de documentos
$_tipos_documentos = array('' => '');
foreach($tipos_documentos as $tipo):
    $_tipos_documentos[$tipo->Pk_Id_Documento_Tipo] = $tipo->Nombre;
endforeach;
?>

<div class="tabbable">
    <!--Pestanas-->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#seccion1" data-toggle="tab">Registro</a></li>
        <li><a href="#seccion2" data-toggle="tab">Seguimiento</a></li>
        <li><a href="#seccion3" data-toggle="tab">Respuesta</a></li>
    </ul>
    <!--Fin pestanas-->
    
    <?php echo form_open('solicitud/crear', array('class' => 'well')); ?>
    <div class="tab-content">
        <!--Seccion de registro de solicitud-->
        <div class="tab-pane active" id="seccion1">
            <div class="row-fluid">
                <!--Radicado de entrada-->
                <div class="span12" align="center">
                    <input type="text" id="radicado_entrada" name="radicado_entrada" class="input-xxlarge" placeholder="N&uacute;mero de radicado de entrada"/>
                    <legend></legend>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span4">
                    <!--Tipo de solicitud-->
                    <label for="tipo_solicitud">Tipo de solicitud *</label>
                    <?php echo form_dropdown('tipo_solicitud', $_tipos, '', 'id="tipo_solicitud" class="input-large"'); ?>
                    <span class="tipo_solicitud"></span>
                    
                    <!--Area encargada-->
                    <label for="area_encargada">&Aacute;rea encargada *</label>
                    <?php echo form_dropdown('area_encargada', $_areas, '', 'id="area_encargada" class="input-large"'); ?>
                    <span class="area_encargada"></span>
                    
                    <!--Municipio-->
                    <label>Municipio *</label>
                    <?php echo form_dropdown('municipio', $_municipios, '', 'id="municipio" class="input-large"'); ?>
                    <span class="municipio"></span>

                    <!--Sector-->
                    <label>Barrio - Vereda *</label>
                    <select id="sector" class="input-large" name="sector">
                        <option value=""></option>
                    </select>
                    <span class="sector"></span>

                    <!--Forma de recepcion-->
                    <label for="forma_recepcion">Forma de Recepci&oacute;n *</label>
                    <?php echo form_dropdown('forma_recepcion', $_formas, '', 'id="forma_recepcion" class="input-large"'); ?>
                    <span class="forma_recepcion"></span>

                    <!--Lugar de recepcion-->
                    <label for="lugar_recepcion">Lugar de Recepción *</label>
                    <?php echo form_dropdown('lugar_recepcion', $_lugares, '', 'id="lugar_recepcion" class="input-large"'); ?>
                    <span class="lugar_recepcion"></span>
                </div>

                <div class="span8">
                    <div class="row-fluid">
                        <div class="span6">
                            <!--Nombre completo-->
                            <label for="nombres">Nombres del solicitante *</label>
                            <input type="text" id="nombres" name="nombres" class="input-large"/>
                            <span class="nombres"></span>

                            <!--Tipo de documento-->
                            <label for="tipo_documento">Tipo de documento</label>
                            <?php echo form_dropdown('tipo_documento', $_tipos_documentos, '', 'id="tipo_documento" class="input-large"'); ?>

                            <!--Número de documento-->
                            <label for="numero_documento">Número</label>
                            <input type="text" id="numero_documento" name="numero_documento" class="input-large"/>

                            <!--Correo electrónico-->
                            <label for="email">Correo electrónico</label>
                            <input type="text" id="email" name="email" class="input-large"/>
                        </div>

                        <div class="span6">
                            <!--Tema-->
                            <label for="tema">Tema *</label>
                            <?php echo form_dropdown('tema', $_temas, '', 'id="tema" class="input-large"'); ?>
                            <span class="tema"></span>
                            
                            <!--Telefono-->
                            <label for="telefono">Tel&eacute;fono</label>
                            <input type="text" id="telefono" name="telefono" class="input-large"/>
                            <span class="telefono"></span>

                            <!--Direccion-->
                            <label for="direccion">Direcci&oacute;n</label>
                            <input type="text" id="direccion" name="direccion" class="input-large"/>
                            <span class="direccion"></span>

                            <!--Tramo-->
                            <label for="tramo">Tramo *</label>
                            <?php echo form_dropdown('tramo', $_tramos, '', 'id="tramo" class="input-large"'); ?>
                            <span class="tramo"></span>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <!--Descripcion de la solicitud-->
                            <label>Descripci&oacute;n detallada *</label>
                            <textarea id="descripcion_solicitud" name="descripcion_solicitud" style="width: 90%;" rows="5"></textarea>
                            <span class="descripcion_solicitud"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Seccion de seguimiento de solicitud-->
        <div class="tab-pane" id="seccion2">
            <!--Accion emprendida-->
            <label>Acci&oacute;n emprendida</label>
            <?php echo form_dropdown('accion_emprendida', $_acciones, '', 'id="accion_emprendida" class="span2"'); ?>
            
            <!--Si la accion es remision, desplegara este div. Inicialmente esta oculto-->
            <div id="remision" style="display: none">
                <legend></legend>
                
                <!--Funcionario-->
                <label>Seleccione el funcionario al que remitir&aacute; *</label>
                <?php echo form_dropdown('funcionario', $_funcionarios, '', 'id="funcionario" class="span2"'); ?>
                <span class="funcionario"></span>
                
                <!--Fecha-->
                <label for="fecha_remision">Fecha</label>
                <div class="input-append date form_datetime">
                    <input type="text" id="fecha_remision" name="fecha_remision" value="" class="input-large" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                    <span class="fecha_remision"></span>
                </div>
                <input class="input-large" type="text" id="radicado_remision" name="radicado_remision" placeholder="Número de radicado">
                
                <legend></legend>
            </div>
            
            <!--Descripcion  de la accion emprendidas-->
            <label>Descripci&oacute;n detallada de las acciones emprendidas</label>
            <textarea name="descripcion_acciones" id="descripcion_acciones" class="input-large" rows="5"></textarea>
            
            <!--Descripcion del seguimiento-->
            <div id="seguimiento"></div>
            <span onClick="agregar();">
                <i class="icon-plus"></i>
                <input type="button" class="btn btn-link" value="Agregar Seguimiento"/>
            </span>
        </div>
        
        <!--Seccion de solucion de solicitud-->
        <div class="tab-pane" id="seccion3">
            <!--Fecha de cierre-->
            <label for="fecha_respuesta">Fecha de respuesta</label>
            <div class="input-append date form_datetime">
                <input type="text" id="fecha_respuesta" name="fecha_respuesta" value="" class="input-large" readonly>
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-calendar"></i></span>
                <span class="fecha_respuesta"></span>
            </div>
            
            <!--Numero de radicado de entrada-->
            <label>N&uacute;mero de radicado de salida</label>
            <input type="text" id="radicado_salida" name="radicado_salida" class="input-large"/>
            
            <!---->
            <label>Descripci&oacute;n detallada</label>
            <textarea id="descripcion_respuesta" name="descripcion_respuesta" class="input-large" rows="5"></textarea>
        </div>
    </div>
</div>
<div align="center">
    <!--Botones-->
    <input type="submit" class="btn btn-primary" value="Guardar"/>
    <input type="button" class="btn" value="Cancelar" onClick="history.back()"/>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    //Se establece un contador
    count = 1;
    
    //Funcion que agrega un nuevo campo de seguimiento
    function agregar(){
        campo = '<label>Escriba el seguimiento No. ' + count +': </label><input class="input-large" type="text" id="nuevo_seguimiento' + count + '" name="seguimiento[]" style="width: 80%"/>';
        $("#seguimiento").append(campo);

        //Se establece el foco del En el campo que se agrega
        $('#nuevo_seguimiento' + count).focus();
        count++;
    }//Fin agregar

    //Cuando el DOM este listo
    $(document).ready(function(){
        //Se establece el foco del formulario
        $('#radicado_entrada').focus();
        
        /*
         * Estos son los campos a validar. False: obligatorios
         */
        val_radicado_entrada = true;
        val_tipo_solicitud = false;
        val_forma_recepcion = false;
        val_lugar_recepcion = false;
        val_tramo = false;
        val_area_encargada = false;
        val_tema = false;
        val_nombres = false;
        val_telefono = true;
        val_direccion = true;
        val_municipio = false
        val_sector = false
        val_descripcion_solicitud = false
        
        /****************************************************************
         *********Eventos al perder el foco en los campos****************
         ***************************************************************/
        //Tipo de solicitud
        $('#tipo_solicitud').blur(function(){
            if($(this).val() == ''){
                val_tipo_solicitud = false;
                $(".tipo_solicitud").removeClass("exito");
                $(".tipo_solicitud").addClass("error");
                $(".tipo_solicitud").html('<i class="icon-remove-sign"></i> Seleccione un tipo de solicitud.');
            }else{
                val_tipo_solicitud = true;
                $(".tipo_solicitud").removeClass("error");
                $(".tipo_solicitud").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin tipo de solicitud
        
        //Forma de recepcion
        $('#forma_recepcion').blur(function(){
            if($(this).val() == ''){
                val_forma_recepcion = false;
                $(".forma_recepcion").removeClass("exito");
                $(".forma_recepcion").addClass("error");
                $(".forma_recepcion").html('<i class="icon-remove-sign"></i> Seleccione una forma de recepci&oacute;n.');
            }else{
                val_forma_recepcion = true;
                $(".forma_recepcion").removeClass("error");
                $(".forma_recepcion").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin forma de recepcion

        //Lugar de recepcion
        $('#lugar_recepcion').blur(function(){
            if($(this).val() == ''){
                val_lugar_recepcion = false;
                $(".lugar_recepcion").removeClass("exito");
                $(".lugar_recepcion").addClass("error");
                $(".lugar_recepcion").html('<i class="icon-remove-sign"></i> Seleccione un lugar de recepci&oacute;n.');
            }else{
                val_lugar_recepcion = true;
                $(".lugar_recepcion").removeClass("error");
                $(".lugar_recepcion").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin Lugar de recepcion
        
        //Tramo
        $('#tramo').blur(function(){
            if($(this).val() == ''){
                val_tramo = false;
                $(".tramo").removeClass("exito");
                $(".tramo").addClass("error");
                $(".tramo").html('<i class="icon-remove-sign"></i> Seleccione un tramo.');
            }else{
                val_tramo = true;
                $(".tramo").removeClass("error");
                $(".tramo").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin tramo
        
        //Area encargada
        $('#area_encargada').blur(function(){
            if($(this).val() == ''){
                val_area_encargada = false;
                $(".area_encargada").removeClass("exito");
                $(".area_encargada").addClass("error");
                $(".area_encargada").html('<i class="icon-remove-sign"></i> Seleccione un &aacute;rea encargada.');
            }else{
                val_area_encargada = true;
                $(".area_encargada").removeClass("error");
                $(".area_encargada").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin area encargada
        
        //Tema
        $('#tema').blur(function(){
            if($(this).val() == ''){
                val_tema = false;
                $(".tema").removeClass("exito");
                $(".tema").addClass("error");
                $(".tema").html('<i class="icon-remove-sign"></i> Seleccione un tema.');
            }else{
                val_tema = true;
                $(".tema").removeClass("error");
                $(".tema").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin tema
        
        //Nombres del solicitante
        $('#nombres').blur(function(){
            if($.trim($(this).val()) == ''){
                val_nombres = false;
                $(".nombres").removeClass("exito");
                $(".nombres").addClass("error");
                $(".nombres").html('<i class="icon-remove-sign"></i> Escriba los nombres del solicitante.');
            }else{
                val_nombres = true;
                $(".nombres").removeClass("error");
                $(".nombres").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin nombres del solicitante
        
        //Municipio
        $('#municipio').blur(function(){
            if($(this).val() == ''){
                val_municipio = false;
                $(".municipio").removeClass("exito");
                $(".municipio").addClass("error");
                $(".municipio").html('<i class="icon-remove-sign"></i> Seleccione un municipio.');
            }else{
                val_municipio = true;
                $(".municipio").removeClass("error");
                $(".municipio").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin municipio
        
        //Cuando se seleccione un municipio, se cargaran automaticamente los sectores asociados a ese municipio
        $("#municipio").change(function(){
            //Se declara la variable
            municipio = $("#municipio").val();
            
            //Se envia por post el id del municipio para que lleguen los sectores relacionados a el
            $.post("<?php echo site_url('solicitud/cargar_sectores'); ?>",
            {
                municipio: municipio
            },
            function(msg){
                //Se cargan en el campo sector
                $("#sector").html(msg);
            });//Fin function
        });//Fin municipio
        
        //Descripcion de la solicitud
        $('#descripcion_solicitud').keyup(function(){
            if($.trim($(this).val()) == ''){
                val_descripcion_solicitud = false;
                $(".descripcion_solicitud").removeClass("exito");
                $(".descripcion_solicitud").addClass("error");
                $(".descripcion_solicitud").html('<i class="icon-remove-sign"></i> Describa la solicitud.');
            }else{
                val_descripcion_solicitud = true;
                $(".descripcion_solicitud").removeClass("error");
                $(".descripcion_solicitud").html('<i class="icon-ok-sign"></i>');
            }
        })//Fin descripcion de la solicitud
        
        //Esta funcion mostrara los datos de remision si la accion emprendida
        //es remision
        $("#accion_emprendida").change(function(){
            //Se captura el valor
            accion =  $("#accion_emprendida").val();
            
            //Si el valor es 3(remision), entonces mostrara los datos del div
            if(accion == 3){
                $("#remision").show('slow');
                //Funcionario
                $('#funcionario').blur(function(){
                    if($(this).val() == ''){
                        $(".funcionario").removeClass("exito");
                        $(".funcionario").addClass("error");
                        $(".funcionario").html('<i class="icon-remove-sign"></i> Seleccione un funcionario.');
                    }else{
                        $(".funcionario").removeClass("error");
                        $(".funcionario").html('<i class="icon-ok-sign"></i>');
                    }
                })//Fin funcionario
            }else{
               $("#remision").hide('slow');
            }
        });//Fin accion emprendida.change
        
        //Accion al guardar la solicitud
        $("form").submit(function(){
            //Se valida que todos los campos superen las validaciones
            if(
                val_tipo_solicitud == false ||
                val_forma_recepcion == false ||
                val_lugar_recepcion == false ||
                val_tramo == false ||
                val_area_encargada == false ||
                val_tema == false ||
                val_municipio == false ||
                val_descripcion_solicitud == false
            ){ 
                //Se muestra el mensaje de error
                $(".div_mensaje").html('<div class="alert"><button class="close" data-dismiss="alert">&times;</button>Aun no se puede guardar la solicitud.\n\
                Verifique que los campos obligatorios esten aun llenos.</div>');
            }else{
                //Se obtiene el atributo action del formulario
                var url = $(this).attr("action");
                
                //Se declara el arreglo que almacenara los seguimientos
                var seguimiento = new Array();
                
                //Se recorren los seguimientos
                for (var i = 1; i < count; i++){
                    //Se declara la variable dentro del arreglo
                    seguimiento[i] = $.trim($("#nuevo_seguimiento" + i).val());
                }//Fin for
    
                //Se crea un objeto JSON con todos los datos de la remision
                datos = {
                    radicado_entrada: $.trim($("#radicado_entrada").val()),
                    tipo_solicitud: $("#tipo_solicitud").val(),
                    forma_recepcion: $("#forma_recepcion").val(),
                    lugar_recepcion: $("#lugar_recepcion").val(),
                    tramo: $("#tramo").val(),
                    area_encargada: $("#area_encargada").val(),
                    tema: $("#tema").val(),
                    nombres: $.trim($("#nombres").val()),
                    telefono: $("#telefono").val(),
                    direccion: $("#direccion").val(),
                    sector: $("#sector").val(),
                    descripcion_solicitud: $("#descripcion_solicitud").val(),
                    accion_emprendida: $("#accion_emprendida").val(),
                    funcionario: $("#funcionario").val(),
                    fecha_remision: $("#fecha_remision").val(),
                    radicado_remision: $("#radicado_remision").val(),
                    descripcion_acciones: $.trim($("#descripcion_acciones").val()),
                    seguimientos: seguimiento,
                    fecha_respuesta: $("#fecha_respuesta").val(),
                    radicado_salida: $.trim($("#radicado_salida").val()),
                    descripcion_respuesta: $.trim($("#descripcion_respuesta").val()),
                    tipo_documento: $.trim($("#tipo_documento").val()),
                    numero_documento: $.trim($("#numero_documento").val()),
                    email: $.trim($("#email").val())
                };//Fin datos

                //Si el formulario esta listo, envia por post los datos y procesa la informacion
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: datos,
                    success: function(msg){
                        console.log(msg)
                        //Si el mensaje es true
                        if(msg == 'true'){
                            //Se redirecciona al inicio
                            location.href = "<?php echo site_url(''); ?>"
                        }else if(msg == 'false'){
                            //Se redirecciona al inicio
                            location.href = "<?php echo site_url(''); ?>";
                        }//Fin if
                    }//Fin success
                });//Fin ajax
            }//Fin if
            return false;
        })//Fin submit
    })//Fin document.ready
</script>
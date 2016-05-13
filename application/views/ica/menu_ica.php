<?php
//Se listan los periodos desde la base de datos
$periodos = $this->ica_model->cargar_periodos();

//Periodos
$_periodos = array('' => 'Seleccione un período');
foreach($periodos as $periodo):
    $_periodos[$periodo->Pk_Id_Periodo] = $periodo->Nombre;
endforeach;
?>
<!--Opciones barra lateral-->
<div id="info_menu" class="hero-unit">
    <center>
        <!--Select para elegir el periodo-->
        <label for="periodo">Período</label>
        <?php echo form_dropdown('periodo', $_periodos, '', 'id="periodo" class="select_lateral" autofocus'); ?>

        <!--Select para elegir el formato-->
        <label for="tramo">Tramo</label>
        <select id="tramo" class="select_lateral" readonly ></select>

        <!--Select para elegir el formato-->
        <label for="formato">Formato</label>
        <select id="formato" class="select_lateral" readonly ></select>

        <label for="ficha">Ficha PMA</label>
        <!--Select para elegir la ficha-->
        <select id="ficha" class="select_lateral" readonly ></select>
    </center>
</div>
<script type="text/javascript">
    //Cuando el DOM este listo
    $(document).ready(function(){
        //Fechas
         $(".form_datetime").datetimepicker({
            autoclose: true,
            //format: "dd mm yyyy - hh:ii",
            minuteStep: 20,
            pickerPosition: "bottom-left",
            showMeridian: true,
            todayBtn: true,
            todayHighlight: true
        });
                 
        //Cuando algun select sea cambiado en el camino
        $("#periodo, #tramo, #formato").on('change', function(){
            //Se oculta el panel de subida de archivos
            $('#vista').html('');
        });//Fin

        /* 
         * Cuando se seleccione un periodo
         */
        $("#periodo").on('change', function(){
        //Si se selecciona un valor
            if($(this).val() !== ""){
                //Mediante una solicitud ajax se cargan los tramos
                $.ajax({
                    url: '<?php echo site_url("ica/cargar_tramos"); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(respuesta){
                        //Si trae datos
                        if(respuesta.length > 0) {
                            //Se activa el select
                            $("#tramo").removeAttr('readonly');

                            //Se resetea el select y se agrega una option vacia
                            $("#tramo").html('').append("<option value=''>Seleccione un tramo</option>");

                            //Se recorren los tramos
                            $.each(respuesta, function(key, val){
                                //Se agrega cada tramo al select
                                $("#tramo").append("<option value='" + val.Pk_Id_Tramo + "'>" + val.Nombre + "</option>");
                            })//Fin each
                        }//Fin if
                    }//Fin success
                });//Fin ajax
            } else {
                //Se desactiva y se resetean los selects
                $("#tramo, #formato, #ficha, #registro").attr('readonly', 'readonly').html('');
            }//Fin if()
        });//Fin periodo

        /* 
        * Cuando se seleccione un tramo
        */
        $("#tramo").on('change', function(){
            //Si se selecciona un valor
            if($(this).val() !== ""){
                //Mediante ajax se cargan los formatos desde la base de datos
                $.ajax({
                    url: '<?php echo site_url("ica/cargar_formatos"); ?>',
                    dataType: 'JSON',
                    success: function(respuesta){
                        //Si trae datos
                        if(respuesta.length > 0) {
                            //Se activa el select
                            $("#formato").removeAttr('readonly');

                            //Se agrega un option vacio
                            $("#formato").html('').append("<option value=''>Seleccione un formato</option>");

                            //Se recorren los periodos
                            $.each(respuesta, function(key, val){
                                //Se agrega cada periodo al select
                                $("#formato").append("<option value='" + val.Pk_Id_Formato + "'>" + val.Nombre + "</option>");
                            });//Fin each
                        }//Fin if
                    }//Fin success
                });//Fin ajax
            } else {
                //Se desactiva y se resetean los selects
                $("#formato, #ficha, #registro").attr('readonly', 'readonly').html('');
            }//Fin if
        });//Fin tramo

        /* 
        * Cuando se seleccione un formato
        */
        $("#formato").on('change', function(){
            //Si se selecciona un valor
            if($(this).val() !== ""){
                //Mediante ajax se cargan las fichas
                $.ajax({
                    url: '<?php echo site_url("ica/cargar_fichas"); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {id_tramo: $("#tramo").val()},
                    success: function(respuesta){
                        //Si trae datos
                        if(respuesta.length > 0) {
                            //Se activa el select y se resetea
                            $("#ficha").removeAttr('readonly').html('').append("<option value=''>Seleccione una ficha</option>");

                            //Se recorren las fichas
                            $.each(respuesta, function(key, val){
                                //Si hay un numero
                                if(val.Numero){
                                    //Lo escribe
                                    numero = val.Numero + ' - '
                                } else {
                                    //Vacio
                                    numero = '';
                                }

                                //Se agrega cada ficha al select
                                $("#ficha").append("<option value='" + val.Pk_Id_Ficha + "'>" + numero + val.Nombre + "</option>");
                            });//Fin each
                        } else {
                            //Se desactiva el select y se resetean los datos
                            $("#ficha").attr('readonly', 'readonly').html('').append("<option value=''>No Hay fichas</option>");
                        }//Fin if()
                    }//Fin success
                });//Fin ajax
            } else {
                //Se desactiva y se resetean los selects
                $("#ficha, #registro").attr('readonly', 'readonly').html('');
            }//Fin if
        });//Fin formato

        /* 
        * Cuando se seleccione una ficha
        */
        $("#ficha").on('change', function(){
            //Si se selecciona un valor
            if($(this).val() !== ""){
                //Se quita el mensaje inicial de la vista
                $("blockquote").hide('slow');
                
                //Se carga la vista correspondiente
                $('#vista').html('').load("<?php echo site_url('ica/cargar_vista/" + $("#formato").val() + "'); ?>").fadeIn(1000);
            } else {
                //Se muestra el mensaje inicial de la vista
                $("blockquote").show('slow');

                //Se lipia la vista si no se ha seleccionado alguna
                $('#vista').html('');
            };//Fin if
        });//Fin ficha
    });//Fin documen.ready 
</script>
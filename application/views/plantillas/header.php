        <!--Etiquetas meta-->
        <meta charset="utf-8">
        <meta name="description" content="Hatovial S.A.S. Gestión Siso Socio Ambiental">
        <meta name="author" content="John Arley Cano Salinas">
        
        <!--Titulo del formulario-->
        <title><?php echo $titulo; ?> | Gestión Ambiental</title>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <!-- Inicia: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- end: Mobile Specific -->
        
        <!--Favicon-->
        <link type="image/x-icon" rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.jpg" />
        
        <!--Archivos de estilo-->
        <link type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
        <link text="text/css" href="<?php echo base_url(); ?>css/datepicker.css" rel="stylesheet">
        <link text="text/css" href="<?php echo base_url(); ?>css/datetimepicker.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.css" rel="stylesheet">
        <link text="text/css" href="<?php echo base_url(); ?>css/bootstrap-responsive.min.css" rel="stylesheet">
        <link text="text/css" href="<?php echo base_url(); ?>css/jquery-ui.css" rel="stylesheet">
        <link text="text/css" href="<?php echo base_url(); ?>css/estilos.css" rel="stylesheet">
            
        <!--Llamados a scripts-->
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/main.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery.jeditable.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery.timeago.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/highcharts.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/highcharts-exporting.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/highcharts-data.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.2.0.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/numeric.min.js"></script>

        <script type='text/javascript'>
            //Estas acciones se realizarán cuando el DOM esté listo
            $(document).ready(function(){
                /************************Este script establece el efecto para los mensajes de error, de informacion, de alerta y de exito************************/
                setTimeout(function(){
                    $(".alert").hide('show');
                }, 5000);
                
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
            });
        </script>
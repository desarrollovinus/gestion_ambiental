<!DOCTYPE html>
<html lang="es">
        <!-- Se cargan los permisos -->
        <?php $permisos = $this->session->userdata('Permisos'); ?>
    <head>
        <!--Se carga la cabecera-->
        <?php $this->load->view('plantillas/header'); ?>
    </head>
    <body>
        <noscript>
            <div class="alert alert-block span10">
                <h4 class="alert-heading">Alerta!</h4>
                <p>Usted necesita habilitar <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> en este sitio.</p>
            </div>
        </noscript>

        <!--Inicio Menu-->
        <div class="navbar" id="sombras">
            <?php $this->load->view('plantillas/menu'); ?>
        </div>
        <!--Fin Menu-->
        
        <!--Inicio Cuerpo-->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="contenido">
                    <?php $this->load->view($menu); ?>
                </div>
                <div class="span9" id="contenido">
                    <!--Contenedor del mensaje de alerta-->
                    <div class="div_mensaje"></div>
                    
                    <?php
                    /*
                     * Variables que muestran los mensajes de exito y error
                     */
                    $exito = $this->session->flashdata('exito');
                    $error = $this->session->flashdata('error');

                    //Si la variable exito trae algo, se muestra
                    if($exito){
                        ?>
                        <!--Contenedor del mensaje-->
                        <div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button><?php echo $exito ?></div>
                        <?php
                    }elseif($error){
                        ?>
                        <!--Contenedor del mensaje-->
                        <div class="alert alert-error"><button class="close" data-dismiss="alert">&times;</button><?php echo $error ?></div>
                        <?php
                    }

                    /*
                     * Se carga el contenido principal, que corresponde
                     * a cada una de las vistas
                     */
                    $this->load->view($contenido_principal); ?>
                </div>
            </div>
        </div>
            
        <!--Inicio Pie-->
        <footer>
            <center>
                <img src="<?php echo base_url(); ?>img/logo.png" /><br>
                <address>
                    <strong>Sistema de Gesti&oacute;n Socio Ambiental</strong><br/>
                    Calle 59 Nro. 48-35 / Km. 4 Autopista Norte <br>
                    Copacabana, Antioquia<br/>

                    <!-- Sitio web -->
                    <a href="http://www.hatovial.com/" target="_blank">
                        <img width="20" src="<?php echo base_url(); ?>img/iconos/internet.png" />
                    </a>

                    <!-- Email -->
                    <a href="mailto:info@hatovial.com">
                        <img width="24" src="<?php echo base_url(); ?>img/iconos/mail.png" />
                    </a>
                    
                    <!-- Facebook -->
                    <a href="http://www.facebook.com/hatovial" target="_blank" >
                        <img width="20" src="<?php echo base_url(); ?>img/iconos/facebook.png" />
                    </a>

                    <!-- Twitter -->
                    <a href="http://www.twitter.com/hatovial" target="_blank">
                        <img width="25" src="<?php echo base_url(); ?>img/iconos/twitter.png" />
                    </a>


                </address>
                
                    
            </center>
        </footer>
        <!--Fin Pie-->
    </body>
</html>
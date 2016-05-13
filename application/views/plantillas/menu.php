<div class="navbar-inner">
    <div class="container">
        <!--Boton de la barra de menu-->
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <!--Módulo de Inicio-->
        <a class="brand" href="<?php echo site_url(''); ?>">
            <!-- <figure id="logo">
                <img src="<?php //echo base_url(); ?>img/logo.png" alt="Puls3" title="Puls3" />
            </figure> -->
        </a>
        
        <!--Cuando el usuario inicie sesión-->
        <?php if ($this->session->userdata('Pk_Id_Usuario') == true){ ?>
        <!--Menu-->
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <!--Menu 1-->
                    <li class="divider-vertical"></li>

                    <!--Botón Inicio-->
                    <li>
                        <a href="<?php echo site_url('inicio'); ?>">Inicio</a>
                    </li>
                    <li class="divider-vertical"></li>

                    <!--Validar que tenga algún permiso al módulo-->
                    <?php if ($this->permisos_model->verificar_modulo($this->session->userdata('Pk_Id_Usuario'), 1)) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Solicitudes
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (isset($acceso[17])) { ?>
                                    <li><a tabindex="-1" href="<?php echo site_url('solicitud'); ?>"><i class="icon-plus"></i> Nueva Solicitud</a></li>
                                    <li class="divider"></li>
                                <?php } ?>
                                <?php if (isset($acceso[18])) { ?>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#"><i class="icon-eye-open"></i> Ver Solicitudes</a>
                                        <ul class="dropdown-menu">
                                            <li><a tabindex="-1" href="<?php echo site_url('solicitud/listar/'); ?>">Todas</a></li>
                                            <?php
                                            //Se carga el modelo
                                            $estados = $this->solicitud_model->cargar_estados();
                                            
                                            //Recorrido para traer todos los estados de una solicitud de la base de datos y agregarlos en el menu
                                            foreach($estados as $estado):
                                            ?>
                                                <li><a tabindex="-1" href="<?php echo site_url('solicitud/listar/'.$estado->Pk_Id_Solicitud_Estado); ?>"><?php echo $estado->Nombre; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="divider-vertical"></li>
                    <?php } ?>
                    
                    <!--Botón ICA-->
                    <!--Validar que tenga algún permiso al módulo-->
                    <?php if ($this->permisos_model->verificar_modulo($this->session->userdata('Pk_Id_Usuario'), 2)) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                ICA
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php // if (isset($acceso[69])) { ?>
                                    <li><a tabindex="-1" href="<?php echo site_url('ica'); ?>"> Agregar</a></li>
                                <?php // } ?>

                                    <!-- <li class="divider"></li> -->
                                <?php // if (isset($acceso[70])) { ?>
                                    <li><a tabindex="-1" href="<?php echo site_url('ica/listar_anexos'); ?>"> Consultar</a></li>
                                <?php // } ?>

                                <?php // if (isset($acceso[70])) { ?>
                                    <li class="divider"></li>
                                    <li><a tabindex="-1" href="<?php echo site_url('ica/anexos_usuario'); ?>"> Mis anexos subidos</a></li>
                                <?php // } ?>
                            </ul>
                        </li>
                        <!-- <li>
                            <a href="<?php //echo site_url('ica'); ?>">ICA</a>
                        </li> -->
                        <li class="divider-vertical"></li>
                    <?php } ?>

                    <!--Botón Hojas de Vida-->
                    <!--Validar que tenga algún permiso al módulo-->
                    <?php if ($this->permisos_model->verificar_modulo($this->session->userdata('Pk_Id_Usuario'), 5)) { ?>
                        <li>
                            <a href="<?php echo site_url('hoja_vida'); ?>">Hojas de Vida</a>
                        </li>
                        <li class="divider-vertical"></li>
                    <?php } ?>

                    <!--Botón SISO-->
                    <!--Validar que tenga algún permiso al módulo-->
                    <?php if ($this->permisos_model->verificar_modulo($this->session->userdata('Pk_Id_Usuario'), 8)) { ?>
                        <?php if (isset($acceso[69]) || isset($acceso[70])) { ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    SISO
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (isset($acceso[69])) { ?>
                                        <li><a tabindex="-1" href="<?php echo site_url('siso/maquinaria'); ?>">Inspección de maquinaria</a></li>
                                    <?php } ?>

                                    <?php if (isset($acceso[70])) { ?>
                                        <li class="divider"></li>
                                        <li><a tabindex="-1" href="<?php echo site_url('siso/equipos'); ?>">Inspección de equipos</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <!--Botón Administración-->
                    <!--Validar que tenga algún permiso al módulo-->
                    <?php if ($this->permisos_model->verificar_modulo($this->session->userdata('Pk_Id_Usuario'), 6)) { ?>
                        <li>
                            <a href="<?php echo site_url('administracion'); ?>">Administración</a>
                        </li>
                        <li class="divider-vertical"></li>
                    <?php } ?>

                    <!--Botón Reportes-->
                    <!--Validar que tenga algún permiso al módulo-->
                    <?php if ($this->permisos_model->verificar_modulo($this->session->userdata('Pk_Id_Usuario'), 7)) { ?>
                        <li>
                            <a href="<?php echo site_url('reporte'); ?>">Reportes</a>
                        </li>
                        <li class="divider-vertical"></li>
                    <?php } ?>
                </ul>

                <!--TextBox Buscar-->
                <?php
                $modulo = $this->uri->segment(1);
                if($modulo && isset($acceso[3])){
                ?>
                    <form action="<?php echo site_url($modulo.'/buscar'); ?>" method="post" class="navbar-search pull-right">
                        <input type="text" id="buscar" name="item" class="search-query" placeholder="Buscar <?php echo $modulo; ?>" />
                    </form>
                <?php } ?>

                <!--Botón Usuario-->
                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="">
                        <i class="icon-user"></i> <?php echo $this->session->userdata('Nombres'); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="<?php echo site_url('usuario/actualizar'); ?>"><i class="icon-list-alt"></i> Mis datos</a></li>
                        <!--Validar permiso-->
                        <?php if (isset($acceso[7])) { ?>
                            <li><a tabindex="-1" href="<?php echo site_url('usuario'); ?>"><i class="icon-user"></i> Crear Usuario</a></li>
                        <?php } ?>
                        <li><a tabindex="-1" href="<?php echo site_url('sesion/cerrar'); ?>"><i class="icon-off"></i> Salir</a></li>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
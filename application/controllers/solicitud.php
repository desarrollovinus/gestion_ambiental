<?php
if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

//Eliminar errores
error_reporting(0);

/**
 * Solicitud
 *
 * @author              John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Solicitud extends CI_Controller{
    /**
    * Funci&oacute;n constructora de la clase. Esta funci&oacute;n se encarga de verificar que se haya
    * iniciado sesi&oacute;n, si no se ha iniciado sesi&oacute;n inmediatamente redirecciona
    *
    * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera
    * conservar el funcionamiento de controlador.
    *
    * @access	public
    */
    function __construct(){
        parent::__construct();

        //se cargan los permisos
        $this->data['acceso'] = $this->session->userdata('Acceso');

        //Si no ha iniciado sesion o no tiene permisos
        if(!$this->session->userdata('Pk_Id_Usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('sesion/cerrar');
        }//Fin if

        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('solicitud_model'));
    }

    /**
     *
     * Pantalla de inicio del modulo
     *
     * Modulo que realiza todas las operaciones relacionadas con las solicitudes
     *
     * @param
     * @return
     * @throws
     */
    function index(){
        // Almacena en caché el formulario
        // $this->output->cache(60);

        /*
         * Se cargan todos y cada uno de los selects que traen los datos
         * de las tablas maestras
         */
        //Se cargan los tramos
        $this->data['tramos'] = $this->solicitud_model->cargar_tramos();
        //Se cargan las areas encargadas
        $this->data['areas'] = $this->solicitud_model->cargar_areas_encargadas();
        //Se cargan los temas
        $this->data['temas'] = $this->solicitud_model->cargar_temas();
        //Se cargan los municipios
        $this->data['municipios'] = $this->solicitud_model->cargar_municipios();
        //Se cargan las formas de recepcion
        $this->data['formas'] = $this->solicitud_model->cargar_formas_recepcion();
        //Se cargan los tipos de solicitud
        $this->data['tipos'] = $this->solicitud_model->cargar_tipos_solicitud();
        //Se cargan las acciones emprendidas
        $this->data['acciones'] = $this->solicitud_model->cargar_acciones_emprendidas();
        //Se cargan los funcionarios
        $this->data['funcionarios'] = $this->solicitud_model->cargar_funcionarios();
        //Se cargan los lugares de recepción
        $this->data['lugares'] = $this->solicitud_model->cargar_lugares_recepcion();
        //Se cargan los tipos de documentos
        $this->data['tipos_documentos'] = $this->solicitud_model->cargar_tipos_documentos();

        /*
         * Se cargan los datos dinamicos para la interfaz
         */
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Nueva Solicitud';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'solicitud/menu_solicitud';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'solicitud/solicitud_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()

    /**
     *
     * Funcion encargada de guardar la solicitud en la base de datos
     *
     *
     * @param
     * @return
     * @throws
     */
    function crear(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            /*
             * Se reciben los datos del formulario. Estos datos vienen por post
             * pero mediante ajax desde la vista
             *
             */
            $radicado_entrada = $this->input->post('radicado_entrada');
            $tipo_solicitud = $this->input->post('tipo_solicitud');
            $forma_recepcion = $this->input->post('forma_recepcion');
            $lugar_recepcion = $this->input->post('lugar_recepcion');
            $tramo = $this->input->post('tramo');
            $area_encargada = $this->input->post('area_encargada');
            $tema = $this->input->post('tema');
            $nombres = $this->input->post('nombres');
            $telefono = $this->input->post('telefono');
            $direccion = $this->input->post('direccion');
            $sector = $this->input->post('sector');
            $descripcion_solicitud = $this->input->post('descripcion_solicitud');
            $accion_emprendida = $this->input->post('accion_emprendida');
            $funcionario = $this->input->post('funcionario');
            $fecha_remision = date('Y-m-d H:i:s', strtotime($this->input->post('fecha_remision')));
            $radicado_remision = $this->input->post('radicado_remision');
            $descripcion_acciones = $this->input->post('descripcion_acciones');
            $seguimientos = $this->input->post('seguimientos');
            $fecha_cierre = date('Y-m-d H:i:s', strtotime($this->input->post('fecha_respuesta')));
            $radicado_salida = $this->input->post('radicado_salida');
            $descripcion_respuesta = $this->input->post('descripcion_respuesta');
            $id_tipo_documento = $this->input->post("tipo_documento");
            $documento = $this->input->post("numero_documento");
            $email = $this->input->post("email");



            //Formateo de las fechas
            if($fecha_cierre == '1969-12-31 19:00:00'){ $fecha_cierre = null; }
            if($fecha_remision == '1969-12-31 19:00:00'){ $fecha_remision = null; }
            if($fecha_cierre == '1969-12-31 19:00:00'){ $fecha_cierre = null; }

			// Si no riene fecha de cierre
            if(!$fecha_cierre){
                $estado_solicitud = 1;
            }else{
                $estado_solicitud = 2;
            }

            //Si es una remision
            if($accion_emprendida == 3){
                //Se prepara el arreglo
                $remision = array(
                    'Fk_Id_Funcionario' => $funcionario,
                    'Fecha' => $fecha_remision,
                    'Radicado_Remision' => $radicado_remision
                );

                //Se inserta la remision en base de datos
                $this->solicitud_model->guardar_remision($remision);

                //Se recupera el id de la remision
                $id_remision = mysql_insert_id();
            }//Fin if

            //Si no hay una acción seleccionada, guardara null
            if($accion_emprendida == ''){$accion_emprendida = null;}

            //Se prepara el arreglo de la solicitud
            $solicitud = array(
                'Fecha_Creacion' => date('Y-m-d H:i:s', time()),
                'Radicado_Entrada' => $radicado_entrada,
                'Nombres' => $nombres,
                'Telefono' => $telefono,
                'Direccion' => $direccion,
                'Solicitud_Descripcion' => $descripcion_solicitud,
                'Accion_Descripcion' => $descripcion_acciones,
                'Respuesta_Descripcion' => $descripcion_respuesta,
                'Radicado_Salida' => $radicado_salida,
                'Fecha_Cierre' => $fecha_cierre,
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario'),
                'Fk_Id_Solicitud_Tipo' => $tipo_solicitud,
                'Fk_Id_Recepcion_Forma' => $forma_recepcion,
                'Fk_Id_Lugar_Recepcion' => $lugar_recepcion,
                'Fk_Id_Tramo' => $tramo,
                'Fk_Id_Area_Encargada' => $area_encargada,
                'Fk_Id_Tema' => $tema,
                'Fk_Id_Sector' => $sector,
                'Fk_Id_Solicitud_Accion' => $accion_emprendida,
                'Fk_Id_Solicitud_Estado' => $estado_solicitud,
                'Fk_Id_Remision' => $id_remision,
                'Documento' => $documento,
                'Email' => $email
            );

			// Si tiene tipo de documento
			if($id_tipo_documento > 0){
				// Se agrega el campo
				$solicitud['Fk_Id_Documento_Tipo'] = $id_tipo_documento;
			} // if

            //Se inserta el registro en base de datos que guarda la solicitud
            $guardar_solicitud = $this->solicitud_model->guardar($solicitud);

            //Se recupera el id de la solicitud obtenido
            $id_solicitud = mysql_insert_id();

            //Si hay seguimientos por agregar, aqui se agregan por medio del recorrido
            for ($i = 1; $i < count($seguimientos); $i++){
                //Se prepara el arreglo
                $seguimiento = array(
                    'Descripcion' => $seguimientos[$i],
                    'Fk_Id_Solicitud' => $id_solicitud
                );

                //Se inserta el seguimiento, uno a uno
                $this->solicitud_model->guardar_seguimiento($seguimiento);
            }//Fin for

            //Si la solicitud se ha guardado correctamente
            if($guardar_solicitud){
            //if(true){
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(1, 4, $id_solicitud);

                //Se envia el mensaje de exito
                $this->session->set_flashdata("exito", 'La solicitud se ha guardado correctamente con el consecutivo '.$this->auditoria_model->numero_solicitud($id_solicitud));

                //Se envia la respuesta true
                echo 'true';
            }else{
                //Se envia el mensaje de error
                $this->session->set_flashdata("error", "No se ha podido guardar la solicitud.");

                //Se envia la respuesta false
                echo 'false';
            }
        }else{
            //Si se solicita por navegador, se redirecciona
            redirect('');
        }
    }//Fin crear()

    function cargar_municipios(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            print json_encode($this->solicitud_model->cargar_municipios());

        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     *
     * Funcion encargada de cargar los sectores asociados a un id
     * de municipio especifico.
     *
     *
     * @param
     * @return $respuesta
     * @throws
     */
    function cargar_sectores(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id del municipio
            $id_municipio = $this->input->post('municipio');

            //Se ejecuta el modelo que carga los sectores relacionados al id del municipio
            $sectores = $this->solicitud_model->cargar_sectores($id_municipio);

            //Se abre el select
            $respuesta .= '<select name="sector">';

            //Se imprime cada sector imprimiendo el resultado de la consulta al modelo
            foreach($sectores as $sector):
                $respuesta .= '<option value="'.$sector->Pk_Id_Sector.'">'.$sector->Nombre.'</option>';
            endforeach;

            //Se cierra el select
            $respuesta .= '</select>';

            //Se imprime el select completo
            echo $respuesta;
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_sectores()

    function cargar_sectores2(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id del municipio
            $id_municipio = $this->input->post('municipio');

            //Se ejecuta el modelo que carga los sectores relacionados al id del municipio
            $sectores = $this->solicitud_model->cargar_sectores($id_municipio);

            //Se devuelve array JSON con los datos
            print json_encode($sectores);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_sectores()

    /**
     *
     *  Funcion que visualiza las solicitudes por estado
     *
     *
     * @param
     * @return
     * @throws
     */
    function listar($id_estado){
        //Se obtiene el id de la solicitud
        $this->data['id_estado'] = $id_estado;

        //
        $this->data['solicitudes'] = $this->solicitud_model->listar($id_estado);

        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Solicitudes';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'solicitud/listar/menu_listar';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'solicitud/listar/listar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin listar()

    /**
     *
     *  Funcion que visualiza las solicitudes segun la busqueda realizada
     *
     *
     * @param
     * @return
     * @throws
     */
    function buscar(){
        //Se recibe el item a buscar por post
        $item =  $this->data['item'] = $this->input->post('item');

        //Se ejecuta el modelo que lista las solicitudes que coinciden con el item de busqueda
        $this->data['solicitudes'] = $this->solicitud_model->listar_busqueda($item);

        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Buscar '.$item;
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'solicitud/buscar/menu_buscar';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'solicitud/listar/listar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 13, null);
    }//Fin buscar

    /**
     *
     * Funcion que muestra los detalles de la solicitud
     *
     *
     * @param
     * @return
     * @throws
     */
    function ver(){
        //Se toma el id de la solicitud
        $id_solicitud = $this->data['id_solicitud'] = $this->uri->segment(3);

        //Si no se consulta ninguna solicitud, se redirecciona al inicio
        if($id_solicitud == null){
            redirect('');
        }

        //Se cargan los tramos
        $this->data['tramos'] = $this->solicitud_model->cargar_tramos();
        //Se cargan las areas encargadas
        $this->data['areas'] = $this->solicitud_model->cargar_areas_encargadas();
        //Se cargan los temas
        $this->data['temas'] = $this->solicitud_model->cargar_temas();

        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Solicitud '.$this->auditoria_model->numero_solicitud($id_solicitud);
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'solicitud/ver/menu_ver';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'solicitud/ver/ver_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 7, $id_solicitud);
    }//Fin ver()

    /**
     *
     *  Funcion que modifica los datos generales de la solicitud, los cuales llegan mediante ajax
     *  con el uso de la libreria jeditable (Edit in Place o Edicion in situ)
     *
     *
     * @param
     * @return
     * @throws
     */
    function modificar($id_solicitud, $campo){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se toma el valor del campo
            $valor = $this->input->post('nuevo_valor');

            //Se ejecuta el modelo en la base de datos
            $this->solicitud_model->modificar($campo, $id_solicitud, $valor);

            //Se imprime el valor para que se muestre en la vista
            echo $valor;

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(1, 6, $id_solicitud);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin modificar()

    /**
     *
     *  Funcion que carga los selects y modifica su valor en base de datos
     *  y en la vista
     *
     *
     * @param
     * @return
     * @throws
     */
    function modificar_selects($id_solicitud, $campo, $tabla, $id){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se toma el nombre del campo
            $valor = $this->input->post('nuevo_valor');

            //Se ejecuta el modelo en la base de datos
            $this->solicitud_model->modificar($campo, $id_solicitud, $valor);

            //Se retorna el valor que trae el select
            echo $this->solicitud_model->cargar_nombre_select($tabla, $id, $valor);

            //Se prepara el arreglo con los datos para la el registro de auditoria
            $auditoria = array(
                'Fk_Id_Auditoria_Tipo' => 6,
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario'),
                'Descripcion' => 'Solicitud '.$this->auditoria_model->numero_solicitud($id_solicitud)
            );

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(1, 6, $id_solicitud);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin modificar_selects()

    /**
     *
     *  Funcion que modifica los datos de la remision de la solicitud
     *
     *
     * @param
     * @return
     * @throws
     */
    function modificar_accion_emprendida(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos enviados por ajax
            $accion_emprendida = $this->input->post('accion_emprendida');
            $id_remision = $this->input->post('id_remision');
            $funcionario = $this->input->post('funcionario');
            $fecha_remision = date('Y-m-d H:i:s', strtotime($this->input->post('fecha_remision')));
            $radicado_remision = $this->input->post('radicado_remision');
            $id_solicitud = $this->input->post('solicitud');

            //Se ejecuta el modelo en la base de datos que actualiza el id de la accion emprendida
            $this->solicitud_model->modificar('Fk_Id_Solicitud_accion', $id_solicitud, $accion_emprendida);

            //Si la accion emprendida es una remision
            if($accion_emprendida == 3){
                //Se consulta si existe la remision
                if($this->solicitud_model->existe_remision($id_solicitud)){
                    //Se prepara el arreglo
                    $datos = array(
                        'Fk_Id_Funcionario' => $funcionario,
                        'Fecha' => $fecha_remision,
                        'Radicado_Remision' => $radicado_remision
                    );

                    //Se ejecuta el modelo que actualiza la remision en la base de datos
                    $this->solicitud_model->modificar_remision($id_remision, $datos);
                }else{
                    //Se prepara el arreglo
                    $remision = array(
                        'Fk_Id_Funcionario' => $funcionario,
                        'Fecha' => $fecha_remision,
                        'Radicado_Remision' => $radicado_remision
                    );

                    //Se inserta la remision en base de datos
                    $this->solicitud_model->guardar_remision($remision);

                    //Se recupera el id de la remision
                    $id_remision = mysql_insert_id();

                    //Se ejecuta el modelo en la base de datos que actualiza el id de la remision
                    $this->solicitud_model->modificar('Fk_Id_Remision', $id_solicitud, $id_remision);
                }
            }else{
                //Se ejecuta el modelo en la base de datos que limpia el id de la remision
                $this->solicitud_model->modificar('Fk_Id_Remision', $id_solicitud, null);

                //Se elimina la remision, si existe
                $this->solicitud_model->eliminar_remision($id_remision);
            }

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(1, 6, $id_solicitud);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin modificar_remision()

    /**
     *
     *  Funcion que inserta un seguimiento. Esta funcion solo es utilizada
     *  Cuando se crea un seguimiento desde la vista de la solicitud creada
     *
     *
     * @param
     * @return
     * @throws
     */
    function guardar_seguimiento($id_solicitud){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe la descripcion
            $descripcion = $this->input->post('descripcion');

            //Se ejecuta el modelo que inserta el seguimiento en la base de datos
            $this->solicitud_model->guardar_seguimiento_vista($id_solicitud, $descripcion);

            echo $descripcion;

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(1, 10, $id_solicitud);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin guardar_seguimiento

    /**
     *
     *  Funcion que modifica el radicado de salida y le cambia el estado a la solicitud para asi
     *  finalizarlo
     *
     *
     * @param
     * @return
     * @throws
     */
    function guardar_radicado_salida($id_solicitud){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se toma el valor del radicado
            $radicado = trim($this->input->post('nuevo_valor'));

            //Si el radicado esta vacio
            if($radicado == ""){
                //El estado de la solicitud sera abierta
                $estado = 1;

                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(1, 8, $id_solicitud);
            }else{
                //El estado de la solicitud sera cerrada
                $estado = 2;

                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(1, 9, $id_solicitud);
            }

            //Se ejecuta el modelo que actualiza el campo en la solicitud
            $this->solicitud_model->modificar('Radicado_Salida', $id_solicitud, $radicado);

            //Se ejecuta el modelo que cambia el estado de la solicitud
            $this->solicitud_model->modificar('Fk_Id_Solicitud_Estado', $id_solicitud, $estado);

            //Se envia el dato para que se muestre en la vista
            echo $radicado;
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin guardar_radicado_salida()

    /**
     *
     *  Funcion que modifica la fecha de respuesta
     *
     *
     * @param
     * @return
     * @throws
     */
    function modificar_fecha_respuesta($id_solicitud){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe la fecha que viene por post
            $fecha = $this->input->post('fecha_cierre');

            //Formateo de las fechas
            if($fecha === '0000-00-00 00:00:00' || $fecha == ''){
                $fecha_cierre = null;
            }else{
                $fecha_cierre = $fecha;
            }

            //Se ejecuta el modelo que actualiza el campo en la solicitud
            $this->solicitud_model->modificar('Fecha_Cierre', $id_solicitud, $fecha_cierre);

            //Se envia el dato de regreso
            echo $fecha;

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(1, 6, $id_solicitud);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin modificar_fecha_respuesta
}
/* Fin del archivo solicitud.php */
/* Ubicación: ./application/controllers/solicitud.php */

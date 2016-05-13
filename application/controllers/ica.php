<?php
//error_reporting(0);

//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * ICA
 * 
 * @author 				John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Ica extends CI_Controller{
	/**
    * Funci&oacute;n constructora de la clase. Esta funci&oacute;n se encarga de verificar que se haya
    * iniciado sesi&oacute;n, si no se ha iniciado sesi&oacute;n inmediatamente redirecciona
    * 
    * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access	public
    */
    function __construct() {
        parent::__construct();
        
        //se cargan los permisos
        $this->data['acceso'] = $this->session->userdata('Acceso');

        //Si no ha iniciado sesion o no tiene permisos
        if(!$this->session->userdata('Pk_Id_Usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('sesion/cerrar');
        }//Fin if

        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('ica_model', 'solicitud_model'));
    }//Fin construct()

    //Se declara la variable que contiene la ruta predeterminada para la subida de archivos
    var $ruta = './archivos/';

    /**
     * 
     * Interfaz de inicio del modulo ICA
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Anexo ICA';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'ica/menu_ica';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'ica/ica_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()

    /**
     * [listar_anexos description]
     * @return [type] [description]
     */
    function listar_anexos(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Visualización';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'ica/menu_ica';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'ica/listar/listar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin listar_anexos()

    /**
     * [anexos_usuario description]
     * @return [type] [description]
     */
    function anexos_usuario(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Mis anexos';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'ica/listar/menu_listar';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'ica/listar/anexos_usuario';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin anexos_usuario()

    /**
     * 
     * Carga los tramos de la aplicacion
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function cargar_tramos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que carga los tramos desde la base de datos
            print json_encode($this->ica_model->cargar_tramos());
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_tramos

    /**
     * 
     * Funcion que permite cargar las fichas asociadas a un formato
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function cargar_fichas(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id del tramo que viene por post
            $id_tramo = $this->input->post('id_tramo');

            //Se ejecuta el modelo que carga las fichas asociadas al tramo que llega
            $fichas = $this->ica_model->cargar_fichas($id_tramo);

            //Los datos se envian mediante un objeto JSON
            print json_encode($fichas);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_fichas()

    /**
     * 
     * Carga todos los formatos que hay en la base de datos
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function cargar_formatos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que carga los formatos
            $formatos = $this->ica_model->cargar_formatos();

            //Los datos se envian mediante un objeto JSON
            print json_encode($formatos);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_periodos()

    /**
     * 
     * Carga los registros asociados a la ficha seleccionada
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function cargar_registros(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe por post el id de la ficha
            $id_ficha = $this->input->post('id_ficha');

            //Se ejecuta el modelo que carga los registros
            $registros = $this->ica_model->cargar_registros($id_ficha);

            //Los datos se envian mediante un objeto JSON
            print json_encode($registros);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_registros()

    function cargar_3a_requerimientos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $id_periodo = $this->input->post('id_periodo');
            $id_tramo = $this->input->post('id_tramo');
            $id_ficha = $this->input->post('id_ficha');

            //Se ejecuta la consulta al modelo
            $requerimientos = $this->ica_model->listar_3a_requerimientos($id_periodo, $id_tramo, $id_ficha);

            //Se retornan los requerimientos
            print json_encode($requerimientos);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_registros()

    /**
     * 
     * Obtiene el id de la relacion entre el registro y la ficha
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function cargar_relacion_registros(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe por post los datos necesarios para la consulta
            $id_ficha = $this->input->post('id_ficha');
            $id_registro = $this->input->post('id_registro');

            //Se ejecuta el modelo que trae el id y se envia
            echo $this->ica_model->cargar_relacion_registros($id_ficha, $id_registro);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin cargar_relacion_registros()

    function cargar_subcontratistas(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            print json_encode($this->ica_model->cargar_subcontratistas());
            //print json_encode("ok");
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Carga la vista dependiendo del formato seleccionado
     * 
     * @param  [int] $id_formato [Id del formato]
     * @return [html]             [Vista asociada]
     */
    function cargar_vista($id_formato){
        //Dependiendo del id del formato, se carga una vista
        switch ($id_formato) {
            case 1:
            $this->load->view('ica/formatos/ICA_0');
            break;

            case 2:
            $this->load->view('ica/formatos/ICA_1a');
            break;

            case 4:
            $this->load->view('ica/formatos/ICA_2a');
            break;

            case 5:
            $this->load->view('ica/formatos/ICA_2b');
            break;

            case 6:
            $this->load->view('ica/formatos/ICA_2c');
            break;

            case 7:
            $this->load->view('ica/formatos/ICA_2d');
            break;

            case 8:
            $this->load->view('ica/formatos/ICA_2e');
            break;

            case 9:
            $this->load->view('ica/formatos/ICA_2f');
            break;

            case 10:
            $this->load->view('ica/formatos/ICA_2g');
            break;

            case 11:
            $this->load->view('ica/formatos/ICA_2h');
            break;

            case 13:
            $this->load->view('ica/formatos/ICA_3a');
            break;

            case 17:
            $this->load->view('ica/formatos/ICA_5');
            break;
        }//Fin switch
    }//Fin cargar_vista()

    function eliminar_anexo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Si se elimina el registro en base de datos
            if ($this->ica_model->eliminar_anexo($this->input->post('id_anexo')) == 'true') {
                // Se borra el archivo del servidor
                unlink($this->input->post('archivo'));

                //Se borra la carpeta
                rmdir($this->ruta.$this->input->post('id_anexo'));

                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 52, null);
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Funcion que sube los anexos al servidor y crea el registro en base de datos
     * 
     * @return [boolean] [Mensaje de exito o de rechazo de la subida. true o false]
     */
    function subir(){
        //Almacenamos el id que usaremos
        $id_anexo = $this->ica_model->obtener_id_anexo() + 1;
        
        //Se almacena la fecha
        $fecha = date("Ymd-His");

        //Variable que marca el exito de la transferencia
        $exito = null;

        //Se asigna el nombre del archivo
        $nombre = $fecha.'.'.$extension = end(explode(".", $_FILES['userfile']['name']));

        //Sse establece el directorio
        $directorio = $this->ruta.$id_anexo.'/';

        //Valida que el directorio exista. Si no existe,lo crea con el id obtenido
        if( ! is_dir($directorio)){
            //Asigna los permisos correspondientes
            @mkdir($directorio, 0777);
        }//Fin if

        //Según el tipo de archivo, se realiza la subida
        switch ($this->input->post('tipo_archivo')) {
            //PDF
            case 1:
                //Si se sube el archivo exitosamente
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio.$nombre)) {
                    //La subida es ok
                    $exito = true;
                } else {
                    //La subida falló
                    $exito = false;
                }
            break;

            //Foto
            case 2:
                //Procesa la foto y la sube
                if($this->ica_model->procesar_foto($_FILES['userfile']['tmp_name'], $directorio, $nombre)){
                    //La subida es ok
                    $exito = true;
                } else {
                    //La subida falló
                    $exito = false;
                }
            break;
        }//Fin switch

        //Si se subio correctamente
        if($exito) {
            //Se almacena un arreglo con la información
            $datos = array(
                'Pk_Id_Anexo' => $id_anexo,
                'Fk_Id_Periodo' => $this->input->post('id_periodo'),
                'Fk_Id_Formato' => $this->input->post('id_formato'),
                'Fk_Id_Ficha_Registro' => $this->input->post('id_ficha_registro'),
                'Fecha_Inicio' => $this->input->post('fecha_inicio'),
                'Fecha_Fin' => $this->input->post('fecha_fin'),
                'Lugar' => $this->input->post('lugar'),
                'Observacion' => $this->input->post('observacion'),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario'),
                'Fk_Id_Anexo_Tipo' => $this->input->post('tipo_archivo')
            );

            //Si no se guarda el anexo en base de datos correctamente:
            if( ! $this->ica_model->guardar_anexo($datos) ){
                //Error
                $exito = false;
            } else {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 17, mysql_insert_id());
            }//Fin if
        }//Fin if

        //Se envía el mensaje de exito, sea true o false
        echo $exito;
    }//Fin subir()

    /**
     * 
     * Lista los archivos pertenecientes a un registro
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function listar_archivos(){
        //
        $id_ficha_registro = $this->input->post('id_ficha_registro');

        //Abre el directorio
        //if($directorio = opendir($this->ruta.$this->input->post('id_ficha_registro'))){
        if($directorio = opendir($this->ruta.$id_ficha_registro)){
            //Se construye un arreglo con los nombres de archivo
            $nombres = array();
            $cont = 1;

            //Recorre los archivos que tiene
            while(($archivo = readdir($directorio)) !== FALSE){
                if($archivo != '.' && $archivo != '..'){
                    //se guardan los nombres en el array
                    array_push($nombres, $archivo);
                    //$nombres[$cont] = $archivo;
                    //$data[utf8_decode($estado->Estado)] = $estado->Total;
                    $cont++;
                }
            }//Fin while

            //se cierra la carpeta
            closedir();

            //
            //print json_encode($nombres);
        }//Fin if()
    }//Fin listar_archivos

    /**
     * [guardar_version_ficha description]
     * @return [type] [description]
     */
    function guardar_version_ficha(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se almacenan los datos en un arreglo
            $datos = array(
                'Version' => $this->input->post('version'),
                'Fk_Id_Ficha' => $this->input->post('ficha'),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se completó el guardado correctamente
           if($this->ica_model->guardar_version_ficha($datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(5, 23, null);

                //Retorna true
                echo 'true';
            } else {
                echo 'false';
            }//Fi if
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * [listar_archivos_subidos description]
     * @return [type] [description]
     */
    function listar_archivos_subidos($id_periodo, $id_ficha){
       $this->data['registros'] = $this->ica_model->listar_registros($id_periodo, $id_ficha);
       $this->load->view('ica/listar/listar_archivos_subidos', $this->data);
    }//Fin listar_archivos_subidos()

    /**
     * Obtiene del modelo la lista de versiones de una dficha
     * 
     * @return [json] [versiones pertenecientes a dicha ficha]
     */
    function listar_versiones(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id de la ficha que viene por post
            $id_ficha = $this->input->post('id_ficha');

            //Se envia un array JSON con las versiones
            print json_encode($this->ica_model->listar_versiones($id_ficha));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin listar_versiones

    function obtener_numero_ficha(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id de la ficha que viene por post
            $id_ficha = $this->input->post('id_ficha');

            //Se envia un array JSON con las versiones
            print json_encode($this->ica_model->obtener_numero_ficha($id_ficha));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * [guardar_meta description]
     * @return [type] [description]
     */
    function guardar_meta(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            $datos = array(
                'Fk_Id_Periodo' => $this->input->post('id_periodo'),
                'Fk_Id_Tramo' => $this->input->post('id_tramo'),
                'Fk_Id_Ficha' => $this->input->post('id_ficha'),
                'Descripcion' => $this->input->post('descripcion'),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );
            
            if ($this->ica_model->guardar_meta($datos)) {
                $id_meta = mysql_insert_id();
                
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 21, $id_meta);
                
                echo $id_meta;
            }else{
                echo 'Error';
            }

        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin guardar_meta

    /**
     * [cargar_metas description]
     * @return [type] [description]
     */
    function cargar_metas(){
        print json_encode($this->ica_model->cargar_metas($this->input->post('id_ficha')));
        //echo $this->input->post('id_ficha');
    }

    function guardar_accion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            $datos = array(
                'Fk_Id_Meta' => $this->input->post('id_meta'),
                'Descripcion' => $this->input->post('descripcion'),
                'Periodicidad' => $this->input->post('periodicidad'),
                'Porcentaje_Cumplimiento' => $this->input->post('porcentaje_cumplimiento'),
                'Porcentaje_Avance_Programado' => $this->input->post('porcentaje_avance_programado'),
                'Porcentaje_Avance_Actual' => $this->input->post('porcentaje_avance_actual'),
                'Observacion' => $this->input->post('observacion'),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar_accion($datos)) {
                echo true;
            }else{
                echo 'Error';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }//Fin guardar_accion


    function guardar_parametro(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            $datos = array(
                'Fk_Id_Meta' => $this->input->post('id_meta'),
                'Parametro_Descripcion' => $this->input->post('parametro_descripcion'),
                'Parametro_Valor' => $this->input->post('parametro_valor'),
                'Calidad_Descripcion' => $this->input->post('calidad_descripcion'),
                'Calidad_Valor' => $this->input->post('calidad_valor'),
                'Cumple' => $this->input->post('cumple'),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar_parametro($datos)) {
                echo true;
            }else{
                echo 'Error';
            }
         }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_estado_permiso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"),
                "Fecha_Acto" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar_estado_permiso($datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 31, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_uso_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero_vertimiento"),
                "Tipo_Vertimiento" => $this->input->post("tipo_vertimiento"),
                "Autorizado" => $this->input->post("autorizado"),
                "Utilizado" => $this->input->post("utilizado"),
                "Duracion" => $this->input->post("duracion"),
                "Disposicion_Final" => $this->input->post("dispocision_final"),
                "Nombre_Fuente" => $this->input->post("nombre_fuente"),
                "Coordenadas" => $this->input->post("coordenadas"),
                "Descripcion_Tratamiento" => $this->input->post("descripcion_tratamiento"),
                "PMA_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar_uso_recurso($datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 31, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2a_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 31, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_estado_concesion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"),
                "Fecha_Acto" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar("estado_concesion", $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 32, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_uso_concesion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Fuente_Agua" => $this->input->post("fuente_agua"),
                "Autorizado" => $this->input->post("autorizado"),
                "Utilizado" => $this->input->post("utilizado"),
                "Tipo_Captacion" => $this->input->post("tipo_captacion"),
                "Nombre_Fuente" => $this->input->post("nombre_fuente"),
                "Aforo_Fuente" => $this->input->post("aforo_fuente"),
                "Coordenadas" => $this->input->post("coordenadas_origen"),
                "Valor_Inversion" => $this->input->post("valor_inversion"),
                "Valor_1" => $this->input->post("valor_1"),
                "Tasa_Uso" => $this->input->post("tasa_uso"),
                "PMA_Relacionado" => $this->input->post("pma_captacion"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar("uso_concesion", $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 32, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_monitoreo_aguas(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2b_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 32, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2c(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"),
                "Fecha_Acto" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2c', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 33, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2c_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Area_Autorizado" => $this->input->post("area_autorizado"),
                "Volumen_Autorizado" => $this->input->post("volumen_autorizado"),
                "Area_Aprovechada" => $this->input->post("area_aprovechada"),
                "Volumen_Aprovechada" => $this->input->post("volumen_aprovechada"),
                "Coordenadas" => $this->input->post("coordenadas"),
                "Area_Total" => $this->input->post("area_total"),
                "Especies_Aprovechadas" => $this->input->post("especies_aprovechadas"),
                "Especies_Reforestadas" => $this->input->post("especies_reforestacion"),
                "PMA_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2c_recurso', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 33, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2c_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Compromiso" => $this->input->post("compromiso"),
                "Pma_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2c_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 33, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2d(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"),
                "Fecha_Acto" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2d', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 34, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2d_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Tipo" => $this->input->post("tipo"),
                "Duracion_Ocupacion" => $this->input->post("duracion"),
                "Fecha_Ocupacion" => date('Y-m-d H:i:s', strtotime($this->input->post('fecha_ocupacion'))),
                "Actividades" => $this->input->post("actividad"),
                "Nombre_Fuente" => $this->input->post("nombre_fuente"),
                "Coordenadas" => $this->input->post("coordenadas"),
                "PMA_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2d_recurso', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 34, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2d_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2d_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 34, mysql_insert_id());
                
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2e(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"),
                "Fecha_Acto" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2e', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 35, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2e_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Tipo_Emision" => $this->input->post("tipo_emision"),
                "Fuente_Generadora" => $this->input->post("fuente_generadora"),
                "Tipo_Combustible" => $this->input->post("tipo_combustible"),
                "Material_Procesado" => $this->input->post("material_procesado"),
                "Altura_Chimenea" => $this->input->post("altura"),
                "Diametro_Chimenea" => $this->input->post("diametro_chimenea"),
                "Coordenadas" => $this->input->post("coordenadas"),
                "Emisiones_Autorizadas" => $this->input->post("emisiones_autorizadas"),
                "Tipo_Contaminante" => $this->input->post("tipo_contaminante"),
                "Altura_Nivel_Mar" => $this->input->post("altura_nivel_mar"),
                "Presion_Barometrica" => $this->input->post("presion_barometrica"),
                "PMA_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2e_recurso', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 35, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2e_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2e_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 35, mysql_insert_id());
                
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2f(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto_Tercero" => $this->input->post("numero_acto_tercero"),
                "Fecha_Acto_Tercero" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto_tercero'))),
                "Concesion_Si" => $this->input->post("concesion_si"),
                "Concesion_No" => $this->input->post("concesion_no"),
                "Fecha_Acto_Concesion" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto_concesion'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2f', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 37, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2f_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Terceros" => $this->input->post("terceros"),
                "Extraccion_Directa" => $this->input->post("extraccion_directa"),
                "Volumen_Autorizado" => $this->input->post("volumen_autorizado"),
                "Volumen_Utilizado" => $this->input->post("volumen_utilizado"),
                "Tipo_Material" => $this->input->post("tipo_material"),
                "Area_Autorizada" => $this->input->post("area_autorizada"),
                "Area_Utilizada" => $this->input->post("area_utilizada"),
                "Coordenadas" => $this->input->post("coordenadas"),
                "Nombre_Fuente" => $this->input->post("nombre_fuente"),
                "PMA_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2f_recurso', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 37, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2f_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2f_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 37, mysql_insert_id());
                
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2g(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"),
                "Fecha_Acto" =>  date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto'))),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Vigencia" => $this->input->post("vigencia"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => $this->input->post("fecha_radicacion"),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2g', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 39, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2g_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" =>  $this->input->post("numero"),
                "Tipo_Residuo" =>  $this->input->post("tipo_residuo"),
                "Otro_Tipo_Residuo" =>  $this->input->post("otro_tipo"),
                "Fuente_Generacion" =>  $this->input->post("fuente_generacion"),
                "Cantidad_Autorizada" =>  $this->input->post("cantidad_autorizadaa"),
                "Cantidad_Dispuesta" =>  $this->input->post("cantidad_dispuesta"),
                "Sistema_Lixiviados" =>  $this->input->post("sistema_lixiviados"),
                "Sistema_Relleno" =>  $this->input->post("sistema_relleno"),
                "Sistema_Botadero" =>  $this->input->post("sistema_botadero"),
                "Sistema_Incineracion" =>  $this->input->post("sistema_incineracion"),
                "Sistema_Otro" =>  $this->input->post("sistema_otro"),
                "Nombre_Sitio" =>  $this->input->post("nombre_sitio"),
                "Vida_Util" =>  $this->input->post("vida_util"),
                "Coordenadas" =>  $this->input->post("coordenadas"),
                "PMA_Relacionado" =>  $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2g_recurso', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 39, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2g_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2g_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 39, mysql_insert_id());
                
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2h(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Acto" => $this->input->post("numero_acto"), 
                "Fecha_Acto1" => date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto1'))), 
                "Fecha_Acto2" => date('Y-m-d H:i:s', strtotime($this->input->post('fecha_acto2'))), 
                "Lleno" => $this->input->post('lleno'), 
                "Vigencia1" => $this->input->post("vigencia1"),
                "Vigencia2" => $this->input->post("vigencia2"),
                "Autoridad1" => $this->input->post("autoridad1"),
                "Tipo" => $this->input->post("tipo"),
                "Fecha_Radicacion" => date('Y-m-d H:i:s', strtotime($this->input->post('fecha_radicacion'))),
                "Autoridad2" => $this->input->post("autoridad2"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2h', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 41, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2h_recurso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero_Permiso" => $this->input->post("numero_permiso"),
                "Permiso" => $this->input->post("permiso"),
                "Permiso_Autorizado" => $this->input->post("permiso_autorizado"),
                "Permiso_Utilizado" => $this->input->post("permiso_utilizado"),
                "Observaciones" => $this->input->post("observaciones"),
                "Coordenadas" => $this->input->post("coordenadas"),
                "Nombre_Fuente" => $this->input->post("nombre_fuente"),
                "PMA_Relacionado" => $this->input->post("pma"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2h_recurso', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 41, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_2h_monitoreo(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post y se almacenan directamente en un arreglo
            $datos = array(
                "Fk_Id_Periodo" => $this->input->post("id_periodo"),
                "Fk_Id_Tramo" => $this->input->post("id_tramo"),
                "Fk_Id_Ficha" => $this->input->post("id_ficha"),
                "Numero" => $this->input->post("numero"),
                "Parametros" => $this->input->post("parametros"),
                "Unidad_Medicion" => $this->input->post("unidad_medicion"),
                "Valor_Medicion" => $this->input->post("valor_medicion"),
                "Metodo_Muestra" => $this->input->post("metodo_muestra"),
                "Metodo_Analisis" => $this->input->post("metodo_analisis"),
                "Fecha_Muestreo" => $this->input->post("fecha_muestreo"),
                "Localizacion_Muestreo" => $this->input->post("localizacion_muestreo"),
                "Numero_Norma" => $this->input->post("numero_norma"),
                "Valor_Norma" => $this->input->post("valor_norma"),
                "Valor_Compromiso" => $this->input->post("valor_compromiso"),
                "Pma_Relacionado" => $this->input->post("pma_compromiso"),
                'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
            );

            //Si se guarda
            if ($this->ica_model->guardar('2h_monitoreo', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 41, mysql_insert_id());
                
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_3a(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Esta es una manera diferente de recibir los datos. Sólo se recibe el json desde la vista y se evía directamente a la base de datos
            $datos = $this->input->post('datos');

            //Si se guarda
            if ($this->ica_model->guardar('3a', $datos)) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(2, 43, mysql_insert_id());

                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo ica.php */
/* Ubicación: ./application/controllers/ica.php */
?>
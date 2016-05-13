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
Class Siso extends CI_Controller{
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
        $this->load->model(array('ica_model', 'siso_model'));
    }//Fin construct()

    function index(){
        /* 
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'SISO';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'siso/menu_siso';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'siso/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data); 
        */
    }//Fin index()

    function firma(){
        //Se carga la vista
        $this->load->view('siso/firma_view'); 
    }//Fin firma()

    function hallazgos_inspeccion_maquinaria(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Hallazgos';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'siso/maquinaria/menu_maquinaria';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'siso/maquinaria/hallazgos';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function inpeccion_maquinaria(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Inspección de maquinaria';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'siso/maquinaria/menu_maquinaria';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'siso/maquinaria/inspeccion_maquinaria';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function maquinaria(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Inspección de maquinaria';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'siso/maquinaria/menu_maquinaria';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'siso/maquinaria/listar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function equipos(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Inspeccón de equipos';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'siso/equipos/menu_maquinaria';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'siso/equipos/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function actualizar_estado_maquinaria(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            echo $this->siso_model->actualizar_estado_maquinaria($this->input->post('id'), $this->input->post('datos'));

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            // $this->auditoria_model->insertar(8, 50, mysql_insert_id());
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos que vienen por post
            $datos = $this->input->post("datos");

            // Suiche
            switch ($this->input->post('tipo')) {
                case 'inspeccion_maquinaria':
                    //Si se guarda
                    if ($this->siso_model->guardar('inspeccion_maquinaria', $datos)) {
                        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                        $this->auditoria_model->insertar(8, 50, mysql_insert_id());

                        //Se retorna el id
                        echo mysql_insert_id();
                    }else{
                        // Se retorna falso
                        echo 'false';
                    }
                    break;

                case 'estado':
                    //Si se guarda
                    if ($this->siso_model->guardar('inspeccion_maquinaria_estado', $datos)) {
                        //Se retorna el id
                        echo mysql_insert_id();
                    }else{
                        // Se retorna falso
                        echo 'false';
                    }
                    break;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_firma(){
        // Inclusión de la librería
        require_once 'system/libraries/Signature-to-image.php';

        // Contenido de la imagen
        echo $json = $_POST['output'];
        $img = sigJsonToImage($json);

        // Se guarda con el id
        imagepng($img, 'archivos/firmas/'.$_POST['id'].'.png');

        //Se destruye la imagen
        imagedestroy($img);
    }
}
/* Fin del archivo siso.php */
/* Ubicación: ./application/controllers/siso.php */
?>
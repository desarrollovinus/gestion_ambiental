<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Empleabilidad
 * 
 * @author 		       John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Empleabilidad extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('hoja_vida_model', 'solicitud_model', 'ica_model'));
    }//Fin construct()

    function index(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Trabaje con nosotros';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'empleabilidad/menu';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'empleabilidad/datos_generales';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()

    function cargar_sectores(){
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

    function validar_documento(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            $documento = $this->hoja_vida_model->validar_documento($this->input->post("documento"));
            
            echo "$documento";
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo empleabilidad.php */
/* Ubicación: ./application/controllers/empleabilidad.php */
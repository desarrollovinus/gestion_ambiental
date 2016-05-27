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
        $this->load->model(array('empleabilidad_model', 'solicitud_model', 'hoja_vida_model'));
    }//Fin construct()

    //Se declara la variable que contiene la ruta predeterminada para la subida de las hojas de vida
    var $ruta = './archivos/hojas_vida/';

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

    function archivo(){
        // Se envía el id de la hoja de vida
        $this->data["id_hoja_vida"] = $this->uri->segment(3);

    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Suba su hoja de vida';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'empleabilidad/menu';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'empleabilidad/archivo';
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

    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Si se guarda
            if ($this->empleabilidad_model->guardar($this->input->post('datos'))) {
                $id = mysql_insert_id();

                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(5, 22, $id);

                echo $id;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function subir_archivo(){
        //Almacenamos el id que usaremos
        $id_archivo = $this->hoja_vida_model->obtener_id_archivo() + 1;

        //Variable que marca el exito de la transferencia
        $exito = null;

        //Se almacena la fecha
        $fecha = date("Ymd-His");

        //Se asigna el nombre del archivo
        $nombre = $fecha.'.'.$extension = end(explode(".", $_FILES['userfile']['name']));

        //Sse establece el directorio
        $directorio = $this->ruta.$id_archivo.'/';

        //Valida que el directorio exista. Si no existe,lo crea con el id obtenido
        if( ! is_dir($directorio)){
            //Asigna los permisos correspondientes
            @mkdir($directorio, 0777);
        }//Fin if

        //Almacenamos los datos a guardar en un arreglo
        $datos = array(
            'Pk_Id_Hoja_Vida_Archivo' => $id_archivo,
            'Fk_Id_Hoja_Vida' => $this->input->post('id_hoja_vida'),
            'Fk_Id_Hoja_Vida_Subcategoria' => $this->input->post('id_subcategoria'),
            'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario')
        );


        //Si se sube el archivo exitosamente
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio.$nombre)) {
            //Se agrega a la base de datos
            $this->hoja_vida_model->guardar_archivo($datos);

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(2, 46, mysql_insert_id());

            //La subida es ok
            $exito = "true";
        } else {
            // $exito = "false";
        print json_encode($datos);

        }

        //Si se subio correctamente
        if($exito == "true") {
            //Se reciben los datos por post
            echo "true";
        }
    }
}
/* Fin del archivo empleabilidad.php */
/* Ubicación: ./application/controllers/empleabilidad.php */
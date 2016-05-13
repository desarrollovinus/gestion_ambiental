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
Class Hoja_vida extends CI_Controller{
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
        $this->load->model(array('hoja_vida_model', 'solicitud_model', 'ica_model'));

        //Se cargan los selects necesarios
        $this->data['frentes'] = $this->solicitud_model->cargar_frentes();
        $this->data['municipios'] = $this->solicitud_model->cargar_municipios();
        $this->data['oficios'] = $this->hoja_vida_model->cargar_oficios();
        $this->data['niveles_estudio'] = $this->hoja_vida_model->cargar_niveles_estudio();
        $this->data['profesiones'] = $this->hoja_vida_model->cargar_profesiones();
        $this->data['tramos'] = $this->solicitud_model->cargar_tramos();
    }//Fin construct()

    //Se declara la variable que contiene la ruta predeterminada para la subida de las hojas de vida
    var $ruta = './archivos/hojas_vida/';

    function index(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Hojas de vida';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'hojas_vida/menu_hojas_vida';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'hojas_vida/listar/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function crear(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Listar Hojas de vida';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'hojas_vida/menu_hojas_vida';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'hojas_vida/hojas_vida_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function agregar_capacitacion(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Agregar capacitación';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'hojas_vida/menu_hojas_vida';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'hojas_vida/capacitacion/agregar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function crear_capacitacion(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Crear capacitación';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'hojas_vida/menu_hojas_vida';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'hojas_vida/capacitacion/crear_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function subir(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Subir archivos';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'hojas_vida/menu_hojas_vida';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'hojas_vida/subir/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function ver(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Ver Hojas de vida';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'hojas_vida/menu_hojas_vida';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'hojas_vida/ver/ver_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function tabla(){
        // Se consulta el modelo
        $this->data["curriculos"] = $this->hoja_vida_model->listado($this->input->post("datos"));

        // Interfaz
        $this->load->view('hojas_vida/listar/tabla_view', $this->data);
    }



    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Si se actualiza
            if ($this->hoja_vida_model->actualizar($this->input->post('datos'), $this->input->post('id_hoja_vida'))) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(5, 30, $this->input->post('id_hoja_vida'));

                //Se retorna verdadero
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_oficios(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que carga los oficios
            $oficios = $this->hoja_vida_model->cargar_oficios();

            //Se devuelve array JSON con los datos
            print json_encode($oficios);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_subcategorias(){
       //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que carga los subcontratistas
            $subcategorias = $this->hoja_vida_model->listar_subcategorias($this->input->post('id_categoria'));

            //Se devuelve array JSON con los datos
            print json_encode($subcategorias);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } 
    }

    function calcular_edad(){
        //Se toma la fecha
        $fecha = $this->input->post("fecha");

        //Se ejecuta el modelo
        echo $this->hoja_vida_model->calcular_edad($fecha);
    }

    function eliminar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Si se elimina el registro en base de datos
            if ($this->hoja_vida_model->eliminar_archivo($this->input->post('id_hoja_vida_archivo')) == 'true') {
                // Se borra el archivo del servidor
                unlink($this->input->post('archivo'));

                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(7, 47, null);
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Si se guarda
            if ($this->hoja_vida_model->guardar($this->input->post('datos'))) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(5, 22, mysql_insert_id());

                //Se retorna verdadero
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_capacitacion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Si se guarda
            if ($this->hoja_vida_model->guardar_capacitacion($this->input->post('datos'))) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(5, 48, mysql_insert_id());

                //Se retorna verdadero
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_capacitacion_asistencia(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Si se guarda
            if ($this->hoja_vida_model->guardar_capacitacion_asistencia($this->input->post('datos'))) {
                //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                $this->auditoria_model->insertar(5, 49, null);

                //Se retorna verdadero
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_reporte(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Si se guarda
            if ($this->hoja_vida_model->guardar_reporte($this->input->post('datos'))) {
                //Se retorna verdadero
                echo true;
            }else{
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function listar_vinculados(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            print json_encode($this->hoja_vida_model->listar_vinculados());
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function listar_archivos(){
        //Se carga la plantilla con las demas variables
        $this->load->view('hojas_vida/subir/archivos_view');
    }

    function listar_capacitaciones(){
        //Se carga la plantilla con las demas variables
        $this->load->view('hojas_vida/capacitacion/tabla_view');
    }

    function listar_capacitaciones_agregadas(){
        //
        $this->data['id_hoja_vida'] = $this->input->post('id_hoja_vida');

        //Se carga la plantilla con las demas variables
        $this->load->view('hojas_vida/capacitacion/tabla_agregadas_view', $this->data);
    }

    function modificar($id_hoja_vida, $campo){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se toma el valor del campo
            $valor = $this->input->post('nuevo_valor');
            
            //Se ejecuta el modelo en la base de datos
            $this->hoja_vida_model->modificar($campo, $id_hoja_vida, $valor);

            //Se imprime el valor para que se muestre en la vista
            echo $valor;

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(5, 30, $id_hoja_vida);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin modificar()

    function modificar_select($id_hoja_vida, $campo_principal, $campo_foraneo, $tabla){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se toma el nombre del campo
            $valor = $this->input->post('nuevo_valor');

            //Se ejecuta el modelo en la base de datos
            $this->hoja_vida_model->modificar($campo_foraneo, $id_hoja_vida, $valor);
            
            //Si no tiene nada en campo principal
            if($campo_principal == 'null'){
                //Se devuele el mismo valor
                if($valor == "1"){
                    echo "Si";
                }elseif($valor == "2"){
                    echo "No";
                }else{
                    echo "";
                }
            }else{
                //Se retorna el valor que trae el select
                echo $this->solicitud_model->cargar_nombre_select($tabla, $campo_principal, $valor);    
            }

            //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
            $this->auditoria_model->insertar(5, 30, $id_hoja_vida);
        }else{
            //Se redirecciona en caso que no venga por ajax
            redirect('');
        }
    }//Fin modificar_selects()

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
/* Fin del archivo curriculo.php */
/* Ubicación: ./application/controllers/curriculo.php */
?>
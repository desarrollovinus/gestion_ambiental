<?php
if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Usuario
 * 
 * @author 		John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Usuario extends CI_Controller{
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
        //Si no ha iniciado sesion, se redirecciona
        if($this->session->userdata('Pk_Id_Usuario') != true){
            redirect('sesion');
        }//Fin if
        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('usuario_model'));
    }//Fin construct()
    
    /**
     * 
     * Interfaz de inicio del modulo de usuario
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Crear Usuario';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'usuario/menu_usuario';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'usuario/usuario_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()
    
    /**
     * 
     * Interfaz de inicio del modulo de usuario
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function actualizar(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Actualizar datos';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'usuario/menu_usuario';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'usuario/actualizar';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin actualizar()

    /**
     * 
     * Interfaz de creacion de usuario
     *
     *
     * @param datos del usuario
     * @return 'true'
     * @throws 
     */
    function crear(){
        /*
         * Se reciben los datos del formulario. Estos datos vienen por post
         * pero mediante ajax desde la vista
         * 
         */
        $documento = $this->input->post('documento');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $nombre_usuario = $this->input->post('usuario');
        $password = md5($this->input->post('password'));
        $email = $this->input->post('email');
        $telefono = $this->input->post('telefono');
        
        //Se almacenan los datos en un arreglo para enviar a la base de datos
        $usuario = array(
            'Documento' => $documento,
            'Nombres' => $nombres,
            'Apellidos' => $apellidos,
            'Usuario' => $nombre_usuario,
            'Password' => $password,
            'Email' => $email,
            'Telefono' => $telefono
        );
        
        //Se ejecuta el modelo que realiza la insercion en la base de datos del usuario
        $guardar = $this->usuario_model->guardar($usuario);
        
        //Se toma el id del usuario que acaba de crearse
        $id_usuario = mysql_insert_id();
        
        //Se ejecuta la insercion del permiso en la base de datos 
        $this->usuario_model->agregar_permiso($id_usuario);
        
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se valida que la respuesta del guardado en base de datos sea verdadera
            if($guardar){
                //Se prepara el arreglo con los datos para la el registro de auditoria
                $auditoria = array(
                    'Fk_Id_Auditoria_Tipo' => 3,
                    'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario'),
                    'Descripcion' => 'Crea el usuario '.$id_usuario
                );

                //Se inserta el registro en auditoria
                $this->auditoria_model->insertar($auditoria);
        
                //Se envia el mensaje de exito
                $this->session->set_flashdata("exito", "Se ha registrado correctamente a $nombres $apellidos.");
                
                //Se envia la respuesta true
                echo 'true';
            }else{
                $this->session->set_flashdata("error", "No se ha podido llevar a cabo el registro del usuario $nombres $apellidos.");
                //Se envia la respuesta false
                echo 'false';
            }
        }else{
            //Si se solicita por navegador, se redirecciona
            redirect('');
        }
    }//Fin crear()
    
    /**
     * Esta funcion valida que el usuario no exista
     * en base de datos mediante ajax
     * 
     * @return string true o false
     */
    function validar_ajax(){
        //Se recibe el nombre de usuario del formulario
        $nombre_usuario = trim($this->input->post('nombre_usuario'));
        
        //Se ejecuta la validaciones
        $validar = $this->usuario_model->validar_usuario($nombre_usuario);
        
        
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se valida si la respuesta del usuario existente es true o false
            if($validar){
                //Se manda como respuesta true
                echo 'true';
            }else{
                //Se manda como respuesta false
                echo 'false';
            }
        }
    }//Fin validar_ajax()
}
/* Fin del archivo usuario.php */
/* Ubicación: ./application/controllers/usuario.php */
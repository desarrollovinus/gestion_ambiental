<?php
if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Sesion
 * 
 * @author              John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Sesion extends CI_Controller{
    /**
    * Funci&oacute;n constructora de la clase.
    * 
    * @access	public
    */
    function __construct() {
        parent::__construct();
        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('sesion_model', 'permisos_model'));
    }//Fin construct()
    
    /**
     * 
     * Interfaz de inicio del modulo
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Identificarse';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'sesion/menu_sesion';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'sesion/sesion_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()
    
    /**
     * 
     * Interfaz de validacion de los datos del usuario
     * que trata de loguearse
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function validar(){
        /*
         * Se reciben los datos del formulario. Estos datos vienen por post
         * pero mediante ajax desde la vista
         * 
         */
        $usuario = $this->input->post('usuario');
        $password = md5($this->input->post('password'));
        
        //Se ejecuta la validacion mediante el modelo en la base de datos
        $datos_usuario = $this->sesion_model->validar($usuario, $password);
        
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se valida que la respuesta de consulta del usuario en base de datos sea verdadera
            if($datos_usuario){
                //Se cargan los permisos
                $accesos = $this->permisos_model->obtener_permisos($datos_usuario->Pk_Id_Usuario);

                //Se arma un arreglo con los datos de sesion que va a mantener
                $datos_sesion = array(
                    'Pk_Id_Usuario' => $datos_usuario->Pk_Id_Usuario,
                    'Nombres' => $datos_usuario->Nombres,
                    'Apellidos' => $datos_usuario->Apellidos,
                    'Documento' => $datos_usuario->Documento,
                    'Usuario' => $datos_usuario->Usuario,
                    'Email' => $datos_usuario->Email,
                    'Telefono' => $datos_usuario->Telefono,
                    'Tipo' => $datos_usuario->Tipo,
                    'Fk_Id_Area' => $datos_usuario->Fk_Id_Area,
                    'Acceso' => $accesos
                );
                
                //Despues de cargada la sesion, se ejecuta la validacion de permiso del usuario en la aplicacion
                $permiso_aplicacion = $this->sesion_model->validar_permiso_aplicacion($datos_usuario->Pk_Id_Usuario);
                
                //Se valida que si tenga permisos la aplicación
                if($permiso_aplicacion){
                    //Se cargan los datos a la sesion
                    $this->session->set_userdata($datos_sesion);
                    
                    //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
                    $this->auditoria_model->insertar(3, 1, null);
                
                    //Se envia el mensaje de exito
                    $this->session->set_flashdata("exito", "Se ha validado correctamente.");

                    //Se envia la respuesta true
                    echo 'true';
                }else{
                    //Se envia el mensaje de error
                    $this->session->set_flashdata("error", "El usuario $datos_usuario->Nombres $datos_usuario->Apellidos no tiene permisos para ingresar a la aplicaci&oacute;n.");

                    //Se envia la respuesta false
                    echo 'false';
                }
            }else{
                //Se envia el mensaje de error
                $this->session->set_flashdata("error", "El usuario y/o la contrase&ntilde;a son incorrectos.");
                
                //Se envia la respuesta false
                echo 'false';
            }
        }else{
            //Si se solicita por navegador, se redirecciona
            redirect('');
        }
    }//Fin validar()
    
    /**
     * 
     * Funcion que cierra la sesion
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function cerrar(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(3, 2, null);
        
        //Se destruye la sesion actual
        $this->session->sess_destroy();
        
        //Se redirige hacia el controlador principal
        redirect('');
    }//Fin cerrar()
}
/* Fin del archivo sesion.php */
/* Ubicación: ./application/controllers/sesion.php */
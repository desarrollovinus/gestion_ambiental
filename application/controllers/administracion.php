<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Administracion
 * 
 * @author 		       John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Administracion extends CI_Controller{
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
        $this->load->model(array('auditoria_model', 'usuario_model', 'permisos_model', 'ica_model'));
    }//Fin construct()

    /**
     * 
     * Interfaz de inicio del modulo de administracion
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function index(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Administraci&oacute;n';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'administracion/menu_administracion';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'administracion/administracion_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()

    /**
     * 
     * Interfaz de auditoria
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function auditoria(){
        //Se carga la vista
        $this->load->view('administracion/auditoria_view');
    }//Fin auditoria

    /**
     * 
     * Interfaz de usuario
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function usuarios(){
        //Se carga la vista
        $this->load->view('administracion/usuarios_view');
    }//Fin auditoria

    /**
     * 
     * Interfaz de permisos
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function permisos(){
        //Se toma el id del usuario
        $this->data['id_usuario'] = $this->input->post('id_usuario');

        //Se carga la vista
        $this->load->view('administracion/permisos_view', $this->data);
    }//Fin auditoria

    function actualizar_permisos(){
        // Recibimos datos por POST
        $permisos = $this->input->post('datos');
        $contratistas = $this->input->post('contratistas');
        $id_usuario = $this->input->post('id_usuario');

        // Primero borramos los permisos
        $borrar_permisos = $this->permisos_model->borrar_permisos($id_usuario);
        // echo "Se borraron ".$this->db->affected_rows()."\n";

        // Luego borraremos los contratistas
        $borrar_contratistas = $this->permisos_model->borrar_contratistas($id_usuario);
        // echo "Se borraron ".$this->db->affected_rows()."\n";

        // Si se borraron los permisos y hay checks seleccionados
        if ($borrar_permisos && $permisos) {
            //Se procede recorrer los permisos
            foreach ($permisos as $permiso) {
                //Se inserta el permiso
                $this->permisos_model->agregar_permisos(array('Fk_Id_Accion' => $permiso, 'Fk_Id_Usuario' => $id_usuario));
                echo $permiso." - ";
            } // foreach
        } // if

        // Si se borraron los contratistas y hay checks seleccionados
        if ($borrar_contratistas && $contratistas) {
            //Se procede recorrer los contratistas
            foreach ($contratistas as $contratista) {
                //Se inserta el contratista
                $this->permisos_model->agregar_contratista(array('Fk_Id_Valor_Contratista' => $contratista, 'Fk_Id_Usuario' => $id_usuario));
            } // foreach
        } // if
    } // actualizar_permisos
}
/* Fin del archivo admninistracion.php */
/* Ubicación: ./application/controllers/admninistracion.php */
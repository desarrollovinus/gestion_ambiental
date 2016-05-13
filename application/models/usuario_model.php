<?php
/**
 * Modelo encargado de gestionar toda la informacion de usuarios
 * 
 * @author 		John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Usuario_model extends CI_Model{
    /*
     * db_hatoapps es la conexion a la base de datos de usuarios de hatoapps. Esta se llama
     * porque en el archivo database.php la variable ['hatoapps']['pconnect] esta marcada como false,
     * lo que quiere decir que no se conecta persistentemente sino cuando se le invoca, como en esta ocasion
     */
    function __construct() {
        parent::__construct();
        //Se carga la base de datos hatoapps
        $this->db_hatoapps = $this->load->database('apps', TRUE);
    }
    
    /**
     * 
     * Esta funcion valida que el usuario que se digita exista
     * en la base de datos
     *
     *
     * @param $nombre_usuario
     * @return boolean
     * @throws 
     */
    function validar_usuario($nombre_usuario){
        //Se realiza la consulta
        $this->db_hatoapps->where('Usuario', $nombre_usuario);
        $query = $this->db_hatoapps->get('usuarios');
        
        //Si devuelve una celda
        if($query->num_rows() == 1){
            //El usuario existe. Retorna verdadero
            return true;
        }else{
            //El usuario no existe. Retorna falso
            return false;
        }
    }//Fin validar_usuario()
    
    /**
     * 
     * Esta funcion guarda el usuario en base de datos
     *
     *
     * @param array usuarios
     * @return boolean
     * @throws 
     */
    function guardar($usuario){
        //Se ejecuta la insercion con los datos que vienen desde un arreglo
        $guardar = $this->db_hatoapps->insert('usuarios', $usuario);
        
        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }//Fin guardar()
    
    /**
     * 
     * Esta funcion guarda el usuario en base de datos
     *
     *
     * @param array usuarios
     * @return boolean
     * @throws 
     */
    function agregar_permiso($id_usuario){
        //Arreglo con los datos a agregar
        $datos = array(
            'Fk_Id_Usuario' => $id_usuario,
            'Fk_Id_Aplicacion' => $this->config->item('id_aplicacion')
        );
        
        //Se ejecuta la insercion con los datos que vienen desde un arreglo
        $this->db_hatoapps->insert('permisos', $datos);
    }//Fin agregar_permiso()

    /**
     * 
     * Lista los usuarios de la aplicacion
     *
     *
     * @param array usuarios
     * @return boolean
     * @throws 
     */
    function listar($id_aplicacion){
        //Consulta
        $sql =
        "SELECT
            *
        FROM
            usuarios
            INNER JOIN permisos ON permisos.Fk_Id_Usuario = usuarios.Pk_Id_Usuario
            INNER JOIN tbl_aplicaciones ON permisos.Fk_Id_Aplicacion = tbl_aplicaciones.Pk_Id_Aplicacion
        WHERE
            tbl_aplicaciones.Pk_Id_Aplicacion = {$id_aplicacion}";

        //Se ejecuta y retorna la consulta
        return $this->db_hatoapps->query($sql)->result();
        /*

        //Columnas a retornar
        $this->db_hatoapps->select('*');
        $this->db_hatoapps->order_by('Nombres');

        //Se ejecuta y retorna la consulta
        return $this->db_hatoapps->get('usuarios')->result();
        */
    }//Fin listar()

    /**
     * 
     * Actualiza los datos de usuario
     *
     *
     * @param array usuarios
     * @return boolean
     * @throws 
     */
    function actualizar(){

    }//actualizar
}
/* Fin del archivo usuario_model.php */
/* Ubicación: ./application/models/usuario_model.php */
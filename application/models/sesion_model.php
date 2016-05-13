<?php
/**
 * Modelo encargado de gestionar toda la informacion de sesiones
 * 
 * @author              John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Sesion_model extends CI_Model{
    /*
     * db_hatoapps es la conexion a la base de datos unificada de usuarios de hatoapps. Esta se llama
     * porque en el archivo database.php la variable ['hatoapps']['pconnect] esta marcada como false,
     * lo que quiere decir que no se conecta persistentemente sino cuando se le invoca, como en esta ocasion.
     */
    function __construct() {
        parent::__construct();
        //Se carga la conexion a la base de datos hatoapps
        $this->db_hatoapps = $this->load->database('apps', TRUE);
    }
    
    /**
     * 
     * Esta funcion valida que el usuario que esta intentando validarse
     * exista en la base de datos
     *
     *
     * @param $nombre_usuario, $password
     * @return boolean
     * @throws 
     */
    function validar($usuario, $password){
        //Consulta
        $sql =
        "SELECT
            usuarios.Pk_Id_Usuario,
            usuarios.Nombres,
            usuarios.Apellidos,
            usuarios.Documento,
            usuarios.Usuario,
            usuarios.Email,
            usuarios.Telefono,
            usuarios.Fk_Id_Area,
            permisos.Tipo_Permiso AS Tipo
        FROM
            usuarios
            INNER JOIN permisos ON permisos.Fk_Id_Usuario = usuarios.Pk_Id_Usuario
        WHERE
            usuarios.Usuario = '{$usuario}' AND
            usuarios.Password = '{$password}'";

        //Se retorna
        return $this->db_hatoapps->query($sql)->row();
    }//Fin validar()
    
    /**
     * 
     * Esta funcion valida que el usuario tenga permisos para la aplicacion,
     * verificando que la variable de configuracion llamada id_aplicacion
     * y el id del usuario esten en la tabla de permisos
     *
     *
     * @param $nombre_usuario, $password
     * @return boolean
     * @throws 
     */
    function validar_permiso_aplicacion($usuario){
        //Se validan el id del usuario y el id de la aplicacion
        $this->db_hatoapps->where('Fk_Id_Usuario', $usuario);
        $this->db_hatoapps->where('Fk_Id_Aplicacion', $this->config->item('id_aplicacion'));
        
        //Se ejecuta la consulta en la base de datos que consulta si hay permisos
        $permiso = $this->db_hatoapps->get('permisos')->row();
        
        //Se verifica que la consulta devuelva algo
        if($permiso){
            //Si trajo algo, se retorna verdadero
            return true;
        }else{
            //Si no ha traido nada, se retorna falso
            return "false";
        }
    }//Fin validar_permiso_aplicacion()
}
/* Fin del archivo sesion_model.php */
/* Ubicación: ./application/models/sesion_model.php */
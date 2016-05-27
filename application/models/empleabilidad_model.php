<?php
Class Empleabilidad_model extends CI_Model{
	function __construct() {
        //Con esta linea se hereda el constructor de la clase Controller
        parent::__construct();
    }//Fin construct()

    function guardar($datos){
        $this->db->insert('hojas_vida', $datos);
        
        return $this->db->insert_id();
    }//Fin guardar()


}
/* End of file empleabilidad_model.php */
/* Location: ./application/models/empleabilidad_model.php */
?>
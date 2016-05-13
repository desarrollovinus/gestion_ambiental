<?php
/**
 * Modelo encargado de gestionar toda la informacion de inicio, el cual
 * muestra datos informativos y resumenes de toda la aplicacion
 * 
 * @author              John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Inicio_model extends CI_Model{
    /*
     * 
     * 
     * 
     */
    function __construct() {
        parent::__construct();
        //Se carga la base de datos solicitudes_ica
        $this->db_ica = $this->load->database('ica', TRUE);
    }
    
    /**
     * 
     * Esta funcion totaliza las solicitudes y las muestra en la
     * pantalla inicial
     *
     *
     * @param
     * @return array
     * @throws 
     */
    function total_solicitudes(){
        //Consulta
        $sql =
        'SELECT
            tbl_solicitud_estados.Pk_Id_Solicitud_Estado,
            Count(solicitudes.Fk_Id_Solicitud_Estado) AS Count,
            tbl_solicitud_estados.Nombre,
            (Count(solicitudes.Fk_Id_Solicitud_Estado)*100)/(SELECT count(solicitudes.Pk_Id_Solicitud) FROM solicitudes) AS Porcentaje
        FROM
            solicitudes
            INNER JOIN tbl_solicitud_estados ON solicitudes.Fk_Id_Solicitud_Estado = tbl_solicitud_estados.Pk_Id_Solicitud_Estado
        GROUP BY
            solicitudes.Fk_Id_Solicitud_Estado';
        
        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin total_solicitudes

    /**
     * Totaliza los datos del ICA necesarios
     * 
     * @return [array] [datos]
     */
    function total_ica(){
        //Retorna la cantidad de datos encontrados de la tabla
        return $this->db_ica->count_all('anexos');
    }//Fin total_ica()
}
/* Fin del archivo inicio_model.php */
/* Ubicación: ./application/models/inicio_model.php */
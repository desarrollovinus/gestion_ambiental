<?php
/**
 * Modelo encargado de gestionar toda la informacion de los registros
 * de auditoria
 * 
 * @author 		       John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Auditoria_model extends CI_Model{
    /**
     * 
     * Esta funcion inserta el registro de auditoria en la base de datos
     *
     *
     * @param array 
     * @return boolean
     * @throws 
     */
    function insertar($modulo, $tipo, $id){
        //Se prepara el arreglo con los datos a insertar

        $datos = array(
            'Fk_Id_Auditoria_Tipo' => $tipo,
            'Fk_Id_Modulo' => $modulo,
            'Fk_Id_Usuario' => $this->session->userdata('Pk_Id_Usuario'),
            'Id' => $id
        );

        $this->db->insert('auditoria', $datos);
    }//Fin insertar()

    /**
     * 
     * Esta funcion Lista todos los tipos de auditoria y cuenta
     * la cantidad de registros para cada uno de esos tipos
     *
     *
     * @param 
     * @return array
     * @throws 
     */
    function totalizar(){
        //Consulta
        $sql = 
        "SELECT
            count(auditoria.Pk_Id_Auditoria) AS Total,
            'Total' AS Tipo,
            NULL AS Fk_Id_Auditoria_Tipo
        FROM
            auditoria
        UNION SELECT
            Count(auditoria.Pk_Id_Auditoria),
            tbl_auditoria_tipo.Nombre,
            auditoria.Fk_Id_Auditoria_Tipo
        FROM
            auditoria
            INNER JOIN tbl_auditoria_tipo ON auditoria.Fk_Id_Auditoria_Tipo = tbl_auditoria_tipo.Pk_Id_Auditoria_Tipo
        GROUP BY
            tbl_auditoria_tipo.Pk_Id_Auditoria_Tipo";
        
        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin totalizar()
    
    /**
     * 
     * Esta funcion Lista las auditorias segun el tipo de auditoria
     *
     *
     * @param array 
     * @return 
     * @throws 
     */
    function listar($id_auditoria_tipo){
        //Consulta
        if($id_auditoria_tipo != null){
            $tipo = "WHERE tbl_auditoria_tipo.Pk_Id_Auditoria_Tipo = ".$id_auditoria_tipo;
        }else{
            $tipo = null;
        }

        $sql =
        "SELECT
            solicitudes.auditoria.Pk_Id_Auditoria,
            solicitudes.auditoria.Fecha_Hora,
            solicitudes.auditoria.Fk_Id_Auditoria_Tipo,
            solicitudes.auditoria.Fk_Id_Usuario,
            apps.usuarios.Nombres,
            apps.usuarios.Apellidos,
            solicitudes.auditoria.Fk_Id_Modulo,
            solicitudes.auditoria.Id,
            solicitudes.tbl_modulos.Nombre AS Modulo,
            solicitudes.tbl_auditoria_tipo.Detalle
        FROM
            solicitudes.auditoria
            INNER JOIN solicitudes.tbl_modulos ON solicitudes.auditoria.Fk_Id_Modulo = solicitudes.tbl_modulos.Pk_Id_Modulo
            INNER JOIN solicitudes.tbl_auditoria_tipo ON solicitudes.auditoria.Fk_Id_Auditoria_Tipo = solicitudes.tbl_auditoria_tipo.Pk_Id_Auditoria_Tipo
            INNER JOIN apps.usuarios ON solicitudes.auditoria.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
            {$tipo}
        ORDER BY
            auditoria.Fecha_Hora DESC";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin listar()

    /**
     * 
     * Esta funcion Lista las usuarios que tienen permiso a la aplicacion
     *
     *
     * @param array 
     * @return 
     * @throws 
     */
    function listar_usuarios(){
        //Consulta
        $sql =
        "SELECT
            apps.usuarios.Nombres,
            apps.usuarios.Apellidos
        FROM
            apps.usuarios
            INNER JOIN apps.permisos ON apps.permisos.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
            WHERE
            apps.permisos.Fk_Id_Aplicacion = 5
        ORDER BY
            apps.usuarios.Nombres ASC";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin listar_usuarios

    /**
    * Formatea las fechas de manera que salgan los meses y d&iacute;s alfab&eacute;ticos
    *
    * @access   public
    */
    function formato_fecha($fecha){
        //Si No hay fecha, devuelva vac&iacute;o en vez de 0000-00-00
        if($fecha == '0000-00-00' || $fecha == '1969-12-31 19:00:00' || !$fecha){
            return false;
        }
        
        $dia_num = date("j", strtotime($fecha));
        $dia = date("N", strtotime($fecha));
        $mes = date("m", strtotime($fecha));
        $anio_es = date("Y", strtotime($fecha));

        //Nombres de los d&iacute;as
        if($dia == "1"){ $dia_es = "Lunes"; }
        if($dia == "2"){ $dia_es = "Martes"; }
        if($dia == "3"){ $dia_es = "Miercoles"; }
        if($dia == "4"){ $dia_es = "Jueves"; }
        if($dia == "5"){ $dia_es = "Viernes"; }
        if($dia == "6"){ $dia_es = "Sabado"; }
        if($dia == "7"){ $dia_es = "Domingo"; }

        //Nombres de los meses
        if($mes == "1"){ $mes_es = "enero"; }
        if($mes == "2"){ $mes_es = "febrero"; }
        if($mes == "3"){ $mes_es = "marzo"; }
        if($mes == "4"){ $mes_es = "abril"; }
        if($mes == "5"){ $mes_es = "mayo"; }
        if($mes == "6"){ $mes_es = "junio"; }
        if($mes == "7"){ $mes_es = "julio"; }
        if($mes == "8"){ $mes_es = "agosto"; }
        if($mes == "9"){ $mes_es = "septiembre"; }
        if($mes == "10"){ $mes_es = "octubre"; }
        if($mes == "11"){ $mes_es = "noviembre"; }
        if($mes == "12"){ $mes_es = "diciembre"; } 

        //a&ntilde;o
        //$anio_es = $anio_es;

        //Se foramtea la fecha
        $fecha = /*$dia_es." ".*/$dia_num." de ".$mes_es." de ".$anio_es;
        
        return $fecha;
    }//Fin formato_fecha()

    
    /**
     * 
     * Esta funcion formatea el numero de la solicitud
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function numero_solicitud($id_solicitud){
        return 'VINUS-'.str_pad($id_solicitud, 3, 0, STR_PAD_LEFT);
    }//Fin numero_solicitud

    function ultimas_actualizaciones($id_usuario){
        $sql = 
        "SELECT
        tbl_auditoria_tipo.Detalle,
        auditoria.Fecha_Hora
        FROM
        auditoria
        INNER JOIN tbl_auditoria_tipo ON auditoria.Fk_Id_Auditoria_Tipo = tbl_auditoria_tipo.Pk_Id_Auditoria_Tipo
        WHERE
        auditoria.Fk_Id_Usuario = {$id_usuario}
        ORDER BY
        auditoria.Fecha_Hora DESC
        LIMIT 0, 20";

        return $this->db->query($sql)->result();
    }
}
/* Fin del archivo auditoria_model.php */
/* Ubicación: ./application/models/auditoria_model.php */
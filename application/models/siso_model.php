<?php
Class Siso_model extends CI_Model{
	function __construct() {
        parent::__construct();
        //Se carga la base de datos solicitudes_ica
        $this->db_ica = $this->load->database('ica', TRUE);
    }

    function actualizar_estado_maquinaria($id, $datos){
        //Se ejecuta la actualizacion con la condicion
        $this->db_ica->where('Pk_Id_Siso_Maquinaria_Estado', $id);
        return $this->db_ica->update('siso_maquinaria_estado', $datos);

        // return "Conectado con el modelo";
    }

	function cargar_estados_maquinas(){
		//Columnas a retornar
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', '18');
        $this->db_ica->order_by('Pk_Id_Valor');
        
        //Se ejecuta y retorna la consulta
        return $this->db_ica->get('tbl_valores')->result();
	}

    function cargar_hallazgos(){
        $sql =
        "SELECT
        ica.siso_maquinaria_estado.Pk_Id_Siso_Maquinaria_Estado,
        ica.tbl_valores.Nombre AS Maquina,
        ica.siso_maquinaria.Fecha_Creacion,
        ica.siso_maquinaria_estado.Observacion AS Descripcion,
        ica.siso_maquinaria_estado.Corregido,
        ica.siso_maquinaria_estado.Accion_Mejora,
        ica.siso_maquinaria_estado.Fecha_Mejora,
        apps.usuarios.Nombres,
        apps.usuarios.Apellidos
        FROM
        ica.siso_maquinaria_estado
        LEFT JOIN ica.siso_maquinaria ON ica.siso_maquinaria_estado.Fk_Id_Siso_Maquinaria = ica.siso_maquinaria.Pk_Id_Siso_Maquinaria
        LEFT JOIN ica.tbl_valores ON ica.siso_maquinaria.Fk_Id_Valor_Maquina = ica.tbl_valores.Pk_Id_Valor
        LEFT JOIN apps.usuarios ON ica.siso_maquinaria_estado.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
        WHERE
        siso_maquinaria_estado.Valor = '0'
        ORDER BY
        siso_maquinaria.Fecha_Creacion DESC";
        
        return $this->db_ica->query($sql)->result();
    }

    function consultar_marcado($id_maquinaria, $id_estado){
        $sql =
        "SELECT
        siso_maquinaria_estado.Valor,
        siso_maquinaria_estado.Observacion
        FROM
        siso_maquinaria_estado
        WHERE
        siso_maquinaria_estado.Fk_Id_Siso_Maquinaria = {$id_maquinaria} AND
        siso_maquinaria_estado.Fk_Id_Valor_Estado = {$id_estado}";

        return $this->db_ica->query($sql)->row();
    }

    function guardar($tipo, $datos){
        // suiche 
        switch ($tipo) {
            case 'inspeccion_maquinaria':
                //Se ejecuta la insercion con los datos que vienen desde un arreglo
                $guardar = $this->db_ica->insert('siso_maquinaria', $datos);
                break;

            case 'inspeccion_maquinaria_estado':
                //Se ejecuta la insercion con los datos que vienen desde un arreglo
                $guardar = $this->db_ica->insert('siso_maquinaria_estado', $datos);
                break;
        }
        
        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }//Fin guardar()

    function listar_inspeccion_maquinaria($id_maquinaria){
        // Si trae id maquinaria
        if($id_maquinaria){
            $condicion = "WHERE ica.siso_maquinaria.Pk_Id_Siso_Maquinaria = {$id_maquinaria}";
        }else{
            $condicion = "";
        }// if


        $sql =
        "SELECT
            ica.siso_maquinaria.Pk_Id_Siso_Maquinaria,
            ica.Valores1.Nombre,
            Valores1.Observacion AS Tipo,
            solicitudes.hojas_vida.Nombres AS Operador,
            (SELECT
            COUNT(siso_maquinaria_estado.Pk_Id_Siso_Maquinaria_Estado)
            FROM
            siso_maquinaria_estado
            WHERE
            siso_maquinaria_estado.Fk_Id_Siso_Maquinaria = Pk_Id_Siso_Maquinaria AND
            siso_maquinaria_estado.Valor = '0') AS Hallazgos,
            ica.siso_maquinaria.Fecha_Creacion,
            Valores2.Nombre AS Categoria,
            solicitudes.hojas_vida.Documento,
            Valores2.Observacion AS Categoria_Observacion,
            ica.siso_maquinaria.Fecha_Vigencia,
            CASE ica.siso_maquinaria.Soat_Requerido WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Soat_Requerido,
            ica.siso_maquinaria.Fecha_Vencimiento_Soat,
            CASE ica.siso_maquinaria.Revision_requerida WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Revision_requerida,
            ica.siso_maquinaria.Fecha_Vencimiento_Revision,
            ica.siso_maquinaria.Horometro
        FROM
            ica.siso_maquinaria
            LEFT JOIN ica.tbl_valores AS Valores1 ON ica.siso_maquinaria.Fk_Id_Valor_Maquina = Valores1.Pk_Id_Valor
            LEFT JOIN solicitudes.hojas_vida ON ica.siso_maquinaria.Fk_Id_Hoja_Vida_Operador = solicitudes.hojas_vida.Pk_Id_Hoja_Vida
            LEFT JOIN ica.tbl_valores AS Valores2 ON ica.siso_maquinaria.Fk_Id_Valor_Categoria = Valores2.Pk_Id_Valor
            {$condicion}
        ORDER BY
            ica.siso_maquinaria.Fecha_Creacion DESC";

        // Si tiene id
        if($id_maquinaria){
            //Se retorna
            return $this->db_ica->query($sql)->row();
        }else{
            //Se retorna
            return $this->db_ica->query($sql)->result();
        }
    }
}
/* End of file siso_model.php */
/* Location: ./application/models/siso_model.php */
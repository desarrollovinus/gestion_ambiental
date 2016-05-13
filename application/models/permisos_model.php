<?php
/**
 * Modelo encargado de gestionar los permisos de la aplicacion
 * 
 * @author 		       John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Permisos_model extends CI_Model{
	function cargar_usuarios(){
		$sql = 
		"SELECT
			apps.usuarios.Pk_Id_Usuario,
			apps.usuarios.Nombres,
			apps.usuarios.Apellidos
		FROM
			apps.permisos
			INNER JOIN apps.usuarios ON apps.permisos.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
		WHERE
			apps.permisos.Fk_Id_Aplicacion = 5
		ORDER BY apps.usuarios.Nombres";

		return $this->db->query($sql)->result();
	}

	function cargar_contratistas_usuario($usuario){
		$this->db->select("*");
		$this->db->where("Fk_Id_Usuario", $usuario);

		return $this->db->get("permisos_contratista")->result();
	} // cargar_contratistas_usuario

	function cargar_permisos($usuario){
		$sql = 
		"SELECT
		tbl_permisos.Fk_Id_Accion
		FROM
		tbl_permisos
		WHERE
		tbl_permisos.Fk_Id_Usuario = {$usuario}";

		return $this->db->query($sql)->result();
	} // cargar_permisos

	function obtener_permisos($id_usuario){
		$sql = 
		"SELECT
			tbl_permisos.Fk_Id_Accion AS Permiso
		FROM
			tbl_modulos
			INNER JOIN tbl_acciones ON tbl_acciones.Fk_Id_Modulo = tbl_modulos.Pk_Id_Modulo
			INNER JOIN tbl_permisos ON tbl_permisos.Fk_Id_Accion = tbl_acciones.Pk_Id_Accion
		WHERE
			tbl_permisos.Fk_Id_Usuario = {$id_usuario}";

		$permisos = array();

		foreach ($this->db->query($sql)->result() as $resultado) {
			$permisos[$resultado->Permiso] = true;
		}

		return $permisos;
	}

	function borrar_permisos($id_usuario){
		//Se borran los permisos
		if($this->db->delete('tbl_permisos', array('Fk_Id_Usuario' => $id_usuario))){
			//return $this->db->affected_rows();
			return true;
		}else{
			return false;
		}
	} // borrar_permisos

	function borrar_contratistas($id_usuario){
		//Se borran los permisos
		if($this->db->delete('permisos_contratista', array('Fk_Id_Usuario' => $id_usuario))){
			return true;
		}else{
			return false;
		} // if
	} // borrar_contratistas

	function agregar_contratista($datos){
		//Si el registro es exitoso
        if($this->db->insert('permisos_contratista', $datos)){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        } // if
	} // agregar_contratista
 
	function agregar_permisos($datos){
		//Si el registro es exitoso
        if($this->db->insert('tbl_permisos', $datos)){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}

	function verificar_modulo($id_usuario, $modulo){
		$sql =
		"SELECT
		tbl_acciones.Fk_Id_Modulo AS Modulo
		FROM
		tbl_permisos
		INNER JOIN tbl_acciones ON tbl_permisos.Fk_Id_Accion = tbl_acciones.Pk_Id_Accion
		WHERE
		tbl_permisos.Fk_Id_Usuario = {$id_usuario} AND
		tbl_acciones.Fk_Id_Modulo = {$modulo}
		GROUP BY
		tbl_acciones.Fk_Id_Modulo";

		foreach ($this->db->query($sql)->result() as $resultado) {
			if($resultado->Modulo){
				return true;
			}else{
				return false;
			}
		}
	}
}
/* Fin del archivo permisos_model.php */
/* Ubicación: ./application/models/permisos_model.php */
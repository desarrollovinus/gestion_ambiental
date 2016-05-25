<?php
/**
 * Modelo que se encarga de enviar los correos electr&oacute;nicos
 * @author 					John Arley Cano Salinas
 * @copyright	&copy;  	HATOVIAL S.A.S.
 */
Class Reporte_model extends CI_Model{
    function __construct() {
        parent::__construct();
        //Se carga la base de datos solicitudes_ica
        $this->db_ica = $this->load->database('ica', TRUE);

        //Se carga la base de datos hatoapps
        $this->db_hatoapps = $this->load->database('apps', TRUE);
    }

    function anexos_fotos($anio, $mes, $id_tramo, $id_ficha, $id_area){
        $sql_ =
        "SELECT
            ica.anexos.Pk_Id_Anexo
        FROM
            ica.anexos
            INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
            INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
        WHERE
            YEAR(anexos.Fecha_Inicio) = {$anio} AND
            MONTH(anexos.Fecha_Inicio) = {$mes} AND
            ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
            ica.tbl_fichas.Fk_Id_Tramo = {$id_tramo} AND
            ica.tbl_fichas.Pk_Id_Ficha = {$id_ficha}";
			
		$sql =
		"SELECT
			ica.anexos.Pk_Id_Anexo
		FROM
			ica.anexos
			INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
			INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
			INNER JOIN apps.usuarios ON ica.anexos.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
		WHERE
			ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
			YEAR(anexos.Fecha_Inicio) = {$anio} AND
			MONTH(anexos.Fecha_Inicio) = {$mes} AND
			ica.tbl_fichas.Fk_Id_Tramo = {$id_tramo} AND
			ica.tbl_fichas.Pk_Id_Ficha = {$id_ficha} AND
			apps.usuarios.Fk_Id_Area = {$id_area}";

        return $this->db->query($sql)->result();
    }

    function consolidado_solicitudes_mensual($anio, $mes){
        $sql =
        "SELECT
            dayofmonth(
                `solicitudes`.`Fecha_Creacion`
            ) AS `Dia`,
            MONTH (
                `solicitudes`.`Fecha_Creacion`
            ) AS `Mes`,
            YEAR (
                `solicitudes`.`Fecha_Creacion`
            ) AS `Anio`,
            date_format(
                `solicitudes`.`Fecha_Creacion`,
                '%d/%m/%Y'
            ) AS `Fecha`,
            `solicitudes`.`Nombres` AS `Nombres`,
            `solicitudes`.`Telefono` AS `Telefono`,
            concat(
                (
                    CASE `tbl_sectores_tipos`.`Pk_Id_Sector_Tipo`
                    WHEN 1 THEN
                        'B. '
                    WHEN 2 THEN
                        'V. '
                    ELSE
                        'P. '
                    END
                ),
                '',
                `tbl_sectores`.`Nombre`
            ) AS `Sector`,
            `tbl_municipios`.`Nombre` AS `Municipio`,
            `tbl_tramos`.`Nombre` AS `Tramo`,
            `tbl_solicitud_tipos`.`Nombre` AS `Tipo`,
            `tbl_area_encargada`.`Nombre` AS `Causa`,
            `tbl_temas`.`Nombre` AS `Tema`,
            `solicitudes`.`Solicitud_Descripcion` AS `Asunto`,
            '' AS `Remitido`,
            'Informac según asunto' AS `Respuesta`,
            `tbl_solicitud_estados`.`Nombre` AS `Estado`,
            `solicitudes`.`Respuesta_Descripcion` AS `Observaciones`
        FROM
            (
                (
                    (
                        (
                            (
                                (
                                    (
                                        (
                                            (
                                                (
                                                    (
                                                        `solicitudes`
                                                        LEFT JOIN `tbl_sectores` ON (
                                                            (
                                                                `solicitudes`.`Fk_Id_Sector` = `tbl_sectores`.`Pk_Id_Sector`
                                                            )
                                                        )
                                                    )
                                                    LEFT JOIN `tbl_municipios` ON (
                                                        (
                                                            `tbl_sectores`.`Fk_Id_Municipio` = `tbl_municipios`.`Pk_Id_Municipio`
                                                        )
                                                    )
                                                )
                                                LEFT JOIN `tbl_sectores_tipos` ON (
                                                    (
                                                        `tbl_sectores`.`Fk_Id_Sector_Tipo` = `tbl_sectores_tipos`.`Pk_Id_Sector_Tipo`
                                                    )
                                                )
                                            )
                                            LEFT JOIN `tbl_tramos` ON (
                                                (
                                                    `solicitudes`.`Fk_Id_Tramo` = `tbl_tramos`.`Pk_Id_Tramo`
                                                )
                                            )
                                        )
                                        LEFT JOIN `tbl_solicitud_tipos` ON (
                                            (
                                                `solicitudes`.`Fk_Id_Solicitud_Tipo` = `tbl_solicitud_tipos`.`Pk_Id_Solicitud_Tipo`
                                            )
                                        )
                                    )
                                    LEFT JOIN `tbl_area_encargada` ON (
                                        (
                                            `solicitudes`.`Fk_Id_Area_Encargada` = `tbl_area_encargada`.`Pk_Id_Area_Encargada`
                                        )
                                    )
                                )
                                LEFT JOIN `tbl_temas` ON (
                                    (
                                        `solicitudes`.`Fk_Id_Tema` = `tbl_temas`.`Pk_Id_Tema`
                                    )
                                )
                            )
                            LEFT JOIN `remisiones` ON (
                                (
                                    `solicitudes`.`Fk_Id_Remision` = `remisiones`.`Pk_Id_Remision`
                                )
                            )
                        )
                        LEFT JOIN `funcionarios` ON (
                            (
                                `remisiones`.`Fk_Id_Funcionario` = `funcionarios`.`Pk_Id_Funcionario`
                            )
                        )
                    )
                    LEFT JOIN `tbl_cargos` ON (
                        (
                            `funcionarios`.`Fk_Id_Cargo` = `tbl_cargos`.`Pk_Id_Cargo`
                        )
                    )
                )
                JOIN `tbl_solicitud_estados` ON (
                    (
                        `solicitudes`.`Fk_Id_Solicitud_Estado` = `tbl_solicitud_estados`.`Pk_Id_Solicitud_Estado`
                    )
                )
            )
        WHERE
            (
                (
                    MONTH (
                        `solicitudes`.`Fecha_Creacion`
                    ) = $mes
                )
                AND (
                    YEAR (
                        `solicitudes`.`Fecha_Creacion`
                    ) = $anio
                )
            )

        ORDER BY Dia DESC";

        return $this->db->query($sql)->result();
    } // consolidado_solicitudes_mensual

    function contar_solicitudes_area($area, $estado){
        $sql =
        "SELECT
            count(solicitudes.Fk_Id_Solicitud_Estado) AS Total
        FROM
            solicitudes
        WHERE
            solicitudes.Fk_Id_Area_Encargada = {$area} AND
            solicitudes.Fk_Id_Solicitud_Estado = {$estado}
        GROUP BY
            solicitudes.Fk_Id_Solicitud_Estado";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin contar_solicitudes_area

    function contar_solicitudes($tramo, $anio, $mes){
        $sql =
        "SELECT
            IF(count(solicitudes.Pk_Id_Solicitud) < 1, NULL, count(solicitudes.Pk_Id_Solicitud)) AS Solicitudes
        FROM
            solicitudes
        WHERE
            solicitudes.Fk_Id_Tramo = {$tramo} AND
            YEAR(solicitudes.Fecha_Creacion) = {$anio} AND
            MONTH(solicitudes.Fecha_Creacion) = {$mes}";

        foreach ($this->db->query($sql)->result() as $solicitud){
            $numero =  $solicitud->Solicitudes;
            return $numero;
        }//Fin foreach()
    }//Fin contar_solicitudes()

    function fichas_fotos($anio, $mes, $id_tramo, $id_area){
        $sql_ =
        "SELECT
            ica.tbl_fichas.Pk_Id_Ficha,
            ica.tbl_fichas.Nombre
        FROM
            ica.anexos
            INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
            INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
        WHERE
            YEAR(anexos.Fecha_Inicio) = {$anio} AND
            MONTH(anexos.Fecha_Inicio) = {$mes} AND
            ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
            ica.tbl_fichas.Fk_Id_Tramo = {$id_tramo}
        GROUP BY
            ica.tbl_fichas.Pk_Id_Ficha";
		
		$sql =
		"SELECT
			ica.tbl_fichas.Pk_Id_Ficha,
			ica.tbl_fichas.Nombre
			FROM
			ica.anexos
			INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
			INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
			INNER JOIN apps.usuarios ON ica.anexos.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
		WHERE
			ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
			YEAR(anexos.Fecha_Inicio) = {$anio} AND
			MONTH(anexos.Fecha_Inicio) = {$mes} AND
			ica.tbl_fichas.Fk_Id_Tramo = {$id_tramo} AND
			apps.usuarios.Fk_Id_Area = {$id_area}
		GROUP BY
			ica.tbl_fichas.Pk_Id_Ficha";

        return $this->db->query($sql)->result();
    }

    function ICA_0($id_tramo){
        //Se genera la consulta
        $sql =
        "SELECT
            tbl_fichas.Numero AS Codigo,
            tbl_fichas.Nombre,
            fichas_versiones.Version
        FROM
            ica.fichas_versiones
            INNER JOIN ica.tbl_fichas ON ica.fichas_versiones.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
        WHERE
            tbl_fichas.Fk_Id_Tramo = {$id_tramo}
        ORDER BY
            tbl_fichas.Numero + 0 ASC";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin ICA_0

    function listar_anios(){
    	$sql = 
    	"SELECT
			YEAR(solicitudes.Fecha_Creacion) AS Anio
		FROM
			solicitudes
		GROUP BY
			YEAR(solicitudes.Fecha_Creacion)
		ORDER BY
			solicitudes.Fecha_Creacion ASC";

		//Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin listar_anios()

    function listar_fichas_fotos_1a(){
        $sql =
        "SELECT
        ica.tbl_periodos.Nombre as Nombre0,
        solicitudes.tbl_tramos.Nombre as Nombre1,
        ica.tbl_fichas.Nombre AS Nombre,
        Count(ica.anexos.Pk_Id_Anexo) AS Total,
        ica.tbl_fichas.Pk_Id_Ficha
        FROM
        ica.anexos
        INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
        INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
        INNER JOIN solicitudes.tbl_tramos ON ica.tbl_fichas.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
        INNER JOIN ica.tbl_periodos ON ica.anexos.Fk_Id_Periodo = ica.tbl_periodos.Pk_Id_Periodo
        WHERE
        ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
        solicitudes.tbl_tramos.Pk_Id_Tramo = 5 AND
        (ica.anexos.Fk_Id_Periodo = 1 or
        ica.anexos.Fk_Id_Periodo = 2 or
        ica.anexos.Fk_Id_Periodo = 3)
        GROUP BY
        ica.tbl_fichas.Pk_Id_Ficha
        ORDER BY
        tbl_fichas.Nombre ASC";

        return $this->db_ica->query($sql)->result();
    }

    function listar_fotos_1a($id_ficha){
        $sql =
        "SELECT
        ica.tbl_periodos.Pk_Id_Periodo,
        ica.tbl_periodos.Nombre AS Periodo,
        solicitudes.tbl_tramos.Pk_Id_Tramo,
        solicitudes.tbl_tramos.Nombre AS Tramo,
        ica.tbl_fichas.Pk_Id_Ficha,
        ica.tbl_fichas.Nombre AS Ficha,
        ica.tbl_registros.Pk_Id_Registro,
        ica.tbl_registros.Descripcion AS Registro,
        ica.anexos.Pk_Id_Anexo,
        ica.anexos.Fecha_Inicio,
        ica.anexos.Lugar,
        ica.anexos.Observacion,
        ica.anexos.Fk_Id_Anexo_Tipo
        FROM
        ica.anexos
        INNER JOIN ica.tbl_periodos ON ica.anexos.Fk_Id_Periodo = ica.tbl_periodos.Pk_Id_Periodo
        INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
        INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
        INNER JOIN solicitudes.tbl_tramos ON ica.tbl_fichas.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
        INNER JOIN ica.tbl_registros ON ica.tbl_ficha_registros.Fk_Id_Registro = ica.tbl_registros.Pk_Id_Registro
        WHERE
        ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
        solicitudes.tbl_tramos.Pk_Id_Tramo = 5 AND
        (ica.anexos.Fk_Id_Periodo = 1 or
        ica.anexos.Fk_Id_Periodo = 2 or
        ica.anexos.Fk_Id_Periodo = 3)
        AND ica.tbl_fichas.Pk_Id_Ficha = {$id_ficha}
        ORDER BY
        ica.tbl_periodos.Pk_Id_Periodo ASC
        LIMIT 0, 214";

        /*"SELECT
        tbl_fichas.Nombre,
        tbl_registros.Descripcion,
        anexos.Pk_Id_Anexo,
        anexos.Fecha_Inicio,
        anexos.Lugar,
        anexos.Observacion
        FROM
        anexos
        INNER JOIN tbl_ficha_registros ON anexos.Fk_Id_Ficha_Registro = tbl_ficha_registros.Pk_Id_Ficha_Registro
        INNER JOIN tbl_fichas ON tbl_ficha_registros.Fk_Id_Ficha = tbl_fichas.Pk_Id_Ficha
        INNER JOIN tbl_registros ON tbl_ficha_registros.Fk_Id_Registro = tbl_registros.Pk_Id_Registro
        WHERE
        anexos.Fk_Id_Anexo_Tipo = 2 AND
        tbl_fichas.Fk_Id_Tramo = 2 AND
        (anexos.Fk_Id_Periodo = 1 OR
        anexos.Fk_Id_Periodo = 2 OR
        anexos.Fk_Id_Periodo = 3) AND
        tbl_fichas.Pk_Id_Ficha = {$id_ficha}
        ORDER BY
        tbl_fichas.Nombre ASC"*/;

        return $this->db_ica->query($sql)->result();
    }

    function listar_areas(){
        $this->db_hatoapps->select('*');
        $this->db_hatoapps->order_by('Nombre');
        return $this->db_hatoapps->get('tbl_areas')->result();
    }

    function listar_anios_ica(){
        $sql =
        "SELECT
            YEAR(a.Fecha_Inicio) AS Anio
        FROM
            anexos AS a
        WHERE
            a.Fk_Id_Anexo_Tipo = 1
        GROUP BY YEAR(a.Fecha_Inicio)";
        
        return $this->db_ica->query($sql)->result();
    }

    function listar_anios_reporte(){
        $sql =
        "SELECT
            YEAR(s.Fecha_Creacion) Anio
        FROM
            solicitudes AS s
        GROUP BY
            Anio";
        
        return $this->db->query($sql)->result();
    }

    function tramos_fotos($anio, $mes, $id_area){
        $sql =
        "SELECT
            solicitudes.tbl_tramos.Pk_Id_Tramo,
            solicitudes.tbl_tramos.Nombre
        FROM
            ica.anexos
            INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
            INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
            INNER JOIN solicitudes.tbl_tramos ON ica.tbl_fichas.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
            INNER JOIN apps.usuarios ON ica.anexos.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
        WHERE
            YEAR(ica.anexos.Fecha_Inicio) = {$anio} AND
            MONTH(ica.anexos.Fecha_Inicio) = {$mes} AND
            ica.anexos.Fk_Id_Anexo_Tipo = 2 AND
            apps.usuarios.Fk_Id_Area = {$id_area}
        GROUP BY
            solicitudes.tbl_tramos.Pk_Id_Tramo
        ORDER BY
            solicitudes.tbl_tramos.Nombre ASC"


        /*SELECT
            solicitudes.tbl_tramos.Nombre,
            solicitudes.tbl_tramos.Pk_Id_Tramo
        FROM
            ica.anexos
            INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
            INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
            INNER JOIN solicitudes.tbl_tramos ON ica.tbl_fichas.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
            WHERE
			YEAR(anexos.Fecha_Inicio) = {$anio} AND
            MONTH(anexos.Fecha_Inicio) = {$mes} AND
            ica.anexos.Fk_Id_Anexo_Tipo = 2
        GROUP BY
            solicitudes.tbl_tramos.Pk_Id_Tramo
        ORDER BY
            solicitudes.tbl_tramos.Nombre ASC"*/;

        return $this->db->query($sql)->result();
    }
}
/* End of file reporte_model.php */
/* Location: ./application/models/reporte_model.php */
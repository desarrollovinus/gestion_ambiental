<?php
/**
 * Modelo que se encarga de enviar los correos electr&oacute;nicos
 * @author 					John Arley Cano Salinas
 * @copyright	&copy;  	HATOVIAL S.A.S.
 */
Class Email_model extends CI_Model{
    /**
    * 
    * Se hereda el mismo constructor de la clase Controller para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
    function __construct() {
        //con esta linea se hereda el constructor de la clase Controller
        parent::__construct();
    }//Fin construct()

	/*
     * Variables globales de configuraci&oacute;n del correo
     */
    var $protocolo = 'smtp';
    var $servidor_correo = 'mail.hatovial.com';
    var $usuario_sistema = 'ambiental';
    var $password_sistema = 'hat0v1al';
    var $correo_sistema = 'ambiental@hatovial.com';

    /**
    * Env&iacute;a los correos electr&oacute;nicos
    * 
    * @access	private
    */
    function _enviar_email($usuarios, $titulo, $asunto, $cuerpo){
        //Se definen los parametros de configuracion
        $config['protocol'] = $this->protocolo;
        $config['smtp_host'] = $this->servidor_correo;
        $config['smtp_timeout'] = '10';
        $config['wordwrap'] = true;
        $config['smtp_user'] = $this->usuario_sistema;
        $config['smtp_pass'] = $this->password_sistema;
        $config['mailtype'] = 'html';

        //Se inicializa la configuracion
        $this->email->initialize($config);

        //Preparando el mensaje
        $this->email->from($this->correo_sistema, 'Sistema de Gestión Socio Ambiental - Hatovial S.A.S.');
        $this->email->to($usuarios); 
        //$this->email->cc(''); 
        $this->email->bcc(array('johnarleycano@hotmail.com')); 
        $this->email->subject($asunto);

        $mensaje = file_get_contents('application/views/email/plantilla.php');
        $mensaje = str_replace('{TITULO}', $titulo, $mensaje);
        $mensaje = str_replace('{CUERPO}', $cuerpo, $mensaje);

        $this->email->message($mensaje);
        $this->email->send();
        //echo $this->email->print_debugger();
    }//Fin enviar()

    /**
    * 
    * Funcion que lista los contratistas, totaliza las hojas de vida
    * de cada una y contabiliza las que han sido modificadas
    * 
    * @access   public
    */
    function hojas_vida_modificadas(){
        // Consulta
        $sql =
        "SELECT
            c.Nombre,
            Count(hv.Pk_Id_Hoja_Vida) Vinculados,
            IFNULL(
                (
                    SELECT
                        Count(hvo.Nombres)
                    FROM
                        solicitudes.hojas_vida AS hvo
                    LEFT JOIN ica.tbl_valores AS co ON hvo.Fk_Id_Valor_Contratista = co.Pk_Id_Valor
                    WHERE
                        hvo.Fecha_Actualizacion BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY)
                    AND CURDATE()
                    AND co.Pk_Id_Valor = c.Pk_Id_Valor
                    GROUP BY
                        co.Pk_Id_Valor
                ),
                0
            ) Modificados
        FROM
            solicitudes.hojas_vida AS hv
        LEFT JOIN ica.tbl_valores AS c ON hv.Fk_Id_Valor_Contratista = c.Pk_Id_Valor
        WHERE
            hv.Contratado = 1
        AND c.Nombre IS NOT NULL
        GROUP BY
            hv.Fk_Id_Valor_Contratista
        ORDER BY
            c.Nombre ASC";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    } // hojas_vida_modificadas

    /**
    * 
    * Funcion que lista las solicitudes que aun estan en tramite
    * 
    * @access   public
    */
    function solicitudes_en_tramite($id_area){
        //Consulta
        $sql =
        "SELECT
            solicitudes.solicitudes.Pk_Id_Solicitud,
            solicitudes.solicitudes.Fecha_Creacion,
            solicitudes.solicitudes.Radicado_Entrada,
            solicitudes.solicitudes.Nombres,
            solicitudes.solicitudes.Solicitud_Descripcion AS Descripcion,
            solicitudes.tbl_tramos.Nombre AS Tramo
        FROM
            solicitudes.solicitudes
            INNER JOIN apps.usuarios ON solicitudes.solicitudes.Fk_Id_Usuario = apps.usuarios.Pk_Id_Usuario
            INNER JOIN solicitudes.tbl_tramos ON solicitudes.solicitudes.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
        WHERE
            solicitudes.solicitudes.Fk_Id_Solicitud_Estado = 1 AND
            solicitudes.solicitudes.Fk_Id_Area_Encargada = {$id_area}
        ORDER BY
            solicitudes.solicitudes.Fecha_Creacion ASC";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin solicitudes_en_tramite

    /**
    * 
    * Funcion que lista las areas que tienen destinatarios
    * 
    * @access   public
    */
    function listar_areas(){
        $sql =
        "SELECT
            tbl_area_encargada.Pk_Id_Area_Encargada,
            tbl_area_encargada.Nombre
        FROM
            destinatarios_email
            INNER JOIN tbl_area_encargada ON destinatarios_email.Fk_Id_Area_Encargada = tbl_area_encargada.Pk_Id_Area_Encargada
        GROUP BY
            destinatarios_email.Fk_Id_Area_Encargada
        ORDER BY
            destinatarios_email.Fk_Id_Area_Encargada ASC";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin listar_areas()

    /**
    * 
    * Funcion que lista los destinatarios segun el area
    * 
    * @access   public
    */
    function obtener_destinatarios($id_area){
        //Consulta
        $sql =
        "SELECT
            tbl_area_encargada.Pk_Id_Area_Encargada,
            tbl_area_encargada.Nombre,
            funcionarios.Nombres,
            funcionarios.Apellidos,
            funcionarios.Email
        FROM
            tbl_area_encargada
            INNER JOIN destinatarios_email ON destinatarios_email.Fk_Id_Area_Encargada = tbl_area_encargada.Pk_Id_Area_Encargada
            INNER JOIN funcionarios ON destinatarios_email.Fk_Id_Funcionario = funcionarios.Pk_Id_Funcionario
        WHERE
            tbl_area_encargada.Pk_Id_Area_Encargada = {$id_area}";

        //Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }//Fin obtener_destinatarios
}
/* End of file email_model.php */
/* Location: ./application/models/email_model.php */
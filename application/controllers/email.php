<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Controlador del m&oacute;dulo que env&iacute;a  correos electr&oacute;nicos.
 * @author 				John Arley Cano Salinas
 * @copyright			HATOVIAL S.A.S.
 */
Class Email extends CI_Controller{
	/**
    * Funci&oacute;n constructora de la clase. Esta funci&oacute;n se encarga de verificar que se haya
    * iniciado sesi&oacute;n, si no se ha iniciado sesi&oacute;n inmediatamente redirecciona
    * 
    * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access	public
    */
    function __construct(){
        //con esta linea se hereda el constructor de la clase Controller
    	parent::__construct();

    	//Se cargan los modelos, librerias y helpers
    	$this->load->library(array('email'));
        $this->load->model(array('email_model'));
    }//Fin construct

    /**
     * 
     * Inicio del modulo
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function index(){
        //Se ejecutan las funciones que enviaran los correos
        $this->solicitudes_en_tramite_por_area();
        // echo '<center>----------------</center>';
        $this->solicitudes_en_tramite_total();
        // echo '<center>----------------</center>';
        $this->hojas_vida_modificadas();
    }//Fin index()

    /**
     * 
     * Funcion que verifica los contratistas que tienen personal vinculado
     * y contabiliza la cantidad de modificados de ellos la última semana,
     * teniendo como base la fecha de generación del reporte.
     *
     * @param 
     * @return 
     * @throws 
     */
    function hojas_vida_modificadas(){
        // Se consulta la información
        $registros = $this->email_model->hojas_vida_modificadas();
            
        /*
         * Se construye la tabla que se va a enviar
         */
        /********************************tabla********************************/
        $tabla = '<table border="1" bordercolor="white" cellspacing="0" width="480">';
        /********************************cabecera********************************/
        $tabla .= '<thead>';
        $tabla .= '<thead>';
        $tabla .= '<tr>';
        $tabla .= '<th width="5%">No.</th>';
        $tabla .= '<th>Contratista</th>';
        $tabla .= '<th>Vinculados</th>';
        $tabla .= '<th>Modificados</th>';
        $tabla .= '<th width="5%">Porcentaje</th>';
        $tabla .= '</tr>';
        $tabla .= '</thead>';

        /********************************cuerpo********************************/
        $tabla .= '<tbody style="color: black;">';

        //Se inicia el contador
        $numero = 1;
            
        //Se recorren los registros
        foreach ($registros as $registro){
            // Cálculo del porcentaje
            $porcentaje = ($registro->Modificados*100) / $registro->Vinculados;

            // Si el porcentaje es mayor a cero
            if (number_format($porcentaje) > 0) {
                $estilo = "bold";
            } else {
                $estilo = "";
            }
            
            //Se arma el registro
            $tabla .= '<tr style="font-weight: '.$estilo.';">';
            $tabla .= '<td align="right">'.$numero++.'</td>';
            $tabla .= '<td>'.$registro->Nombre.'</td>';
            $tabla .= '<td align="right">'.$registro->Vinculados.'</td>';
            $tabla .= '<td align="right">'.$registro->Modificados.'</td>';
            $tabla .= '<td align="right">'.number_format($porcentaje, 1, ',', '.').' %</td>';
            $tabla .= '</tr>';  
        } // foreach

        $tabla .= '</tbody>'; 
        $tabla .= '</table><br/>';
        $tabla .= '<h3>Para los porcentajes marcados en cero, se recomienda hacer seguimiento y verificar que los encargados estén actualizando la información.</h3><br><br>';

        //Se describe el asunto
        echo $asunto = 'Hojas de vida modificadas por contratista'; 

        // Ahora definimos el titulo del correo
        echo $titulo = "<p>A continuaci&oacute;n se listan los contratistas y se especifica el porcentaje de las hojas de vida modificadas la última semana. Esto corresponde a las novedades que se han ingresado al sistema.</p>"; 

        // Se establece el cuerpo del mensaje
        echo $cuerpo = $tabla;

        // Si es local
        if ($this->config->item("tipo_repositorio") == "local") {
            // Se ejecuta el modelo que envia el email
            $this->email_model->_enviar_email(array('john.cano@vinus.com.co'), $titulo, $asunto, $cuerpo);    
        } else {
            // Se ejecuta el modelo que envia el email
            $this->email_model->_enviar_email(array('eddy.lotero@hatovial.com', 'sandra.idarraga@vinus.com.co',), $titulo, $asunto, $cuerpo);    
        } // if
    } // hojas_vida_modificadas

    /**
     * 
     * Funcion que verifica las areas que tienen destinatarios, por cada area
     * verifica que haya solicitudes en tramite, selecciona los destinatarios
     * de ese area y les envia la tabla de solicitudes en tramite
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function solicitudes_en_tramite_por_area(){
        //Se ejecuta el modelo que carga las areas que tienen destinatarios definidos en base de datos
        $areas = $this->email_model->listar_areas();

        //Se recorren las areas para buscar los destinatarios
        foreach ($areas as $area){
            //Se declara el id y el nombre del area
            $id_area = $area->Pk_Id_Area_Encargada;
            $area = $area->Nombre;

            //Se ejecuta el modelo que trae las solicitudes en tramite
            $solicitudes = $this->email_model->solicitudes_en_tramite($id_area);

            //Si hay solicitudes en tramite para el area especifica:
            if($solicitudes){
                /*
                 * Se construye la tabla que se va a enviar
                 */
                /********************************tabla********************************/
                $tabla = '<table border="1" bordercolor="white" cellspacing="0" width="100%">';
                /********************************cabecera********************************/
                $tabla .= '<thead>';
                $tabla .= '<tr>';
                $tabla .= '<th width="5%">No.</th>';
                $tabla .= '<th width="10%">Solicitud</th>';
                $tabla .= '<th>Radicado Entrada</th>';
                $tabla .= '<th>Unidad funcional</th>';
                $tabla .= '<th width="15%">Creada</th>';
                $tabla .= '<th>Detalle</th>';
                $tabla .= '<th width="10%">Solicitante</th>';
                $tabla .= '</tr>';
                $tabla .= '</thead>';

                /********************************cuerpo********************************/
                $tabla .= '<tbody>';
                //Se inicia el contador
                $numero = 0;

                //Se hace un recorrido de las solicitudes, teniendo en cuenta que es solo de ese area
                foreach ($solicitudes as $solicitud) {
                    /* 
                     * Aqui se arma la tabla de solicitudes pendientes para un area especifica
                     * y se envia a los destinatarios asignados de esa area en la tabla
                     * destinatarios_email
                     */
                    //Se aumenta el contador
                    $numero++;

                    //Se arma el registro
                    $tabla .= '<tr>';
                    $tabla .= '<td class="numero" align="right">'.$numero.'&nbsp;</td>';
                    $tabla .= '<td>'.$this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud).'</td>';
                    $tabla .= '<td width="10%">'.$solicitud->Radicado_Entrada.'</td>';
                    $tabla .= '<td width="10%">'.$solicitud->Tramo.'</td>';
                    $tabla .= '<td>'.$this->auditoria_model->formato_fecha($solicitud->Fecha_Creacion).'</td>';
                    $tabla .= '<td width="50%">'.$solicitud->Descripcion.'</td>';
                    $tabla .= '<td width="15%">'.$solicitud->Nombres.'</td>';
                    $tabla .= '</tr>';
                }//Fin foreach solicitudes

                $tabla .= '</tbody>';        
                $tabla .= '</table><br/>';

                //Se ejecuta el modelo que obtiene los destinatarios relacionados a ese area
                $destinatarios = $this->email_model->obtener_destinatarios($id_area);

                //Se declaran el arreglo que llevara los destinatarios
                $usuarios = array();

                //Despues de construida la tabla, se toman los destinatarios
                foreach ($destinatarios as $destinatario){
                    //Se almacenan los correos en un arreglo
                    array_push($usuarios, $destinatario->Email);
                }//Fin foreach destinatarios

                //Se describe el asunto
                echo $asunto = $area.' - Solicitudes en trámite'; 

                //Ahora definimos el titulo del correo
                echo $titulo = "<p>A continuaci&oacute;n se listan las solicitudes que aun est&aacute;n en tr&aacute;mite para el &aacute;rea de ".$area.":</p>"; 

                //Se establece el cuerpo del mensaje
                echo $cuerpo = $tabla;

                echo '<br/>---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br/>';

                //Se ejecuta el modelo que envia el email, de acuerdo a lo configurado, sea local o web
                if ($this->config->item("tipo_repositorio") == "local") {
                    $this->email_model->_enviar_email(array(''), $titulo, $asunto, $cuerpo);
                } else {
                    $this->email_model->_enviar_email($usuarios, $titulo, $asunto, $cuerpo);
                } // if
            }// if
        }//Fin foreach areas
    }//Fin solicitudes_en_tramite_por_area()

    /**
     * 
     * Pantalla de inicio del modulo
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function solicitudes_en_tramite_total(){
        //Se ejecuta el modelo que carga las areas que tienen destinatarios definidos en base de datos
        $areas = $this->email_model->listar_areas();

        //Se describe el asunto
        echo $asunto = 'Solicitudes en trámite';

        // Si es local
        if ($this->config->item("tipo_repositorio") == "local") {
            //Se almacenan los usuarios a quien les llegara el correo
            $usuarios = array('john.cano@vinus.com.co');
        } else {
            //Se almacenan los usuarios a quien les llegara el correo
            $usuarios = array('ludis.perez@hatovial.com', 'monica.foronda@hatovial.com', 'eddy.lotero@hatovial.com');    
        } // if

        //Ahora definimos el titulo del correo
        echo $titulo = "<p>A continuaci&oacute;n se listan las solicitudes que aun est&aacute;n en tr&aacute;mite para todas las &aacute;reas: </p>"; 

        //Se declara la variable que construira el cuerpo del mensaje
        $cuerpo = null;

        //Se recorren las areas
        foreach ($areas as $area){
            //Se declara el id y el nombre del area
            $id_area = $area->Pk_Id_Area_Encargada;
            $area = $area->Nombre;

            //Se ejecuta el modelo que trae las solicitudes en tramite
            $solicitudes = $this->email_model->solicitudes_en_tramite($id_area);

            //Si hay solicitudes en tramite para el area especifica:
            if($solicitudes){
                /*
                 * Se construye la tabla que se va a enviar
                 */
                /********************************tabla********************************/
                $tabla = '<table border="1" bordercolor="white" cellspacing="0" width="100%">';
                /***************************Titulo de la tabla***************************/
                $tabla .= '<caption><b>'.$area.'</b></caption>';
                /********************************cabecera********************************/
                $tabla .= '<thead>';
                $tabla .= '<tr>';
                $tabla .= '<th width="5%">No.</th>';
                $tabla .= '<th width="10%">Solicitud</th>';
                $tabla .= '<th>Radicado Entrada</th>';
                $tabla .= '<th>Unidad funcional</th>';
                $tabla .= '<th width="15%">Creada</th>';
                $tabla .= '<th>Detalle</th>';
                $tabla .= '<th width="10%">Solicitante</th>';
                $tabla .= '</tr>';
                $tabla .= '</thead>';

                /********************************cuerpo********************************/
                $tabla .= '<tbody>';

                //Se inicia el contador
                $numero = 0;

                //Se hace un recorrido de las solicitudes, teniendo en cuenta que es solo de ese area
                foreach ($solicitudes as $solicitud){
                    /* 
                     * Aqui se arma la tabla de solicitudes pendientes para un area especifica
                     * y se envia a los destinatarios asignados de esa area en la tabla
                     * destinatarios_email
                     */
                    //Se aumenta el contador
                    $numero++;

                    //Se arma el registro
                    $tabla .= '<tr>';
                    $tabla .= '<td class="numero">'.$numero.'&nbsp;</td>';
                    $tabla .= '<td>'.$this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud).'</td>';
                    $tabla .= '<td width="10%">'.$solicitud->Radicado_Entrada.'</td>';
                    $tabla .= '<td width="10%">'.$solicitud->Tramo.'</td>';
                    $tabla .= '<td>'.$this->auditoria_model->formato_fecha($solicitud->Fecha_Creacion).'</td>';
                    $tabla .= '<td width="50%">'.$solicitud->Descripcion.'</td>';
                    $tabla .= '<td width="15%">'.$solicitud->Nombres.'</td>';
                    $tabla .= '</tr>';
                }//Fin foreach solicitudes

                $tabla .= '</tbody>';        
                $tabla .= '</table><br/>';

                //Se establece el cuerpo del mensaje almacenando cada tabla del recorrido de areas
                $cuerpo .= $tabla;
                echo $tabla;
            }//Fin if solicitudes
        }//Fin foreach areas

        if($numero > 0){
            // echo $cuerpo; print_r($usuarios );

            //Se ejecuta el modelo que envia el email
            $this->email_model->_enviar_email($usuarios, $titulo, $asunto, $cuerpo);

            //Se envia un reporte que dice cuantos ha enviado
            $this->email_model->_enviar_email(array(""), 'Reporte de enviados', 'Reporte de enviados', $cuerpo);  
        }else{
            //Se envia un reporte que dice que no hay ninguno
            $this->email_model->_enviar_email(array(""), 'Reporte de enviados', 'Reporte de enviados', 'No hay ninguna solicitud en trámite');  
        } // if
    }//Fin solicitudes_en_tramite_total
}
/* End of file email.php */
/* Location: ./application/application/controllers/email.php */
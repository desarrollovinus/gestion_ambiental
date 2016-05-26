<?php
/*
I: envía el fichero al navegador de forma que se usa la extensión (plug in) si está disponible. El nombre dado en nombre se usa si el usuario escoge la opción "Guardar como..." en el enlace que genera el PDF.
D: envía el fichero al navegador y fuerza la descarga del fichero con el nombre especificado por nombre.
F: guarda el fichero en un fichero local de nombre nombre.
S: devuelve el documento como una cadena. nombre se ignora.
*/

//Zona horaria
date_default_timezone_set('America/Bogota');

//Se carga la librer&iacute;a de PDF y la libreria de impresion rapida
require('system/libraries/Fpdf.php');

//Definir la ruta de las fuentes
define('FPDF_FONTPATH','system/fonts/');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Modulo que contiene todos los reportes y plantillas de la aplicacion.
 * En este modulo se llama cada vista, la cual corresponde a un archivo php que contiene el informe
 *
 *
 * @author          John Arley Cano Salinas
 * @copyright       &copy; HATOVIAL S.A.S.
 */
Class Reporte extends CI_Controller{
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
    	parent::__construct();

        //se cargan los permisos
        $this->data['acceso'] = $this->session->userdata('Acceso');

        //Si no ha iniciado sesion o no tiene permisos
        if(!$this->session->userdata('Pk_Id_Usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('sesion/cerrar');
        }//Fin if

        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('reporte_model', 'solicitud_model', 'ica_model', 'hoja_vida_model', 'siso_model'));
        $this->load->library(array('PHPExcel', 'PHPWord'));
    }//Fin construct

    /**
     *
     * Pantalla de inicio del modulo
     *
     * Modulo que realiza todas las operaciones relacionadas con las solicitudes
     *
     * @param
     * @return
     * @throws
     */
    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Reportes';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'reportes/menu_reportes';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'reportes/reporte_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()

    /**
     * Acta de inicio en Word
     */
    function acta_inicio(){
        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/word/acta_inicio');

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        // $this->auditoria_model->insertar(1, 12, null);
    } // acta_inicio

    /**
     * Funcion que genera el reporte de solicitudes consolidado
     * por areas encargadas
     */
    function consolidado_areas_estados(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Areas por estado';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'reportes/menu_reportes';
        //Se establece la vista que tiene el contenido principalexcel
        $this->data['contenido_principal'] = 'reportes/graficos/areas_estados';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 14, null);
    }//Fin consolidado_areas_estados

    /**
     * Funcion que genera el reporte de solicitudes consolidado
     * mensualmente
     */
    function consolidado_areas_meses(){
        //Cargar anos
        $this->reporte_model->listar_anios();
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Areas por meses';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'reportes/menu_reportes';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'reportes/areas_meses';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 15, null);
    }//Fin consolidado_areas_meses

    /**
     * Funcion que genera el reporte de solicitudes consolidado por tramo
     * y por meses
     */
    function consolidado_tramos(){
        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/consolidado_tramos');

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 12, null);
    }//Fin consolidado_tramos

    /**
     * Funcion que genera el reporte de solicitudes consolidado
     * por mes y año
     */
    function consolidado_solicitudes_mensual(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        // $this->auditoria_model->insertar(1, 12, null);

        // Recolección de datos
        $this->data['anio'] = $this->uri->segment(3);
        $this->data['mes'] = $this->uri->segment(4);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/consolidado_solicitudes_mensual', $this->data);
    }//Fin consolidado_solicitudes_mensual

    /**
     *
     */
    function hojas_vida(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 24, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/hojas_vida');
    } // hojas_vida

    /**
     * Genera el informe en excel del ica 0, llamado
     * Estructura del plan de manejo ambiental
     */
    function ica_0($ficha){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(2, 18, null);

        $this->data['ficha'] = $ficha;

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_0');
    }// Fin ICA_0

    /**
     * Reporte ICA 1a
     */
    function ica_1a(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 25, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_1a');
    } // Ica 1a

    /**
     * Reporte ICA 2a
     */
    function ica_2a(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 26, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2a');
    } // Ica 2a

    /**
     * Reporte ICA 2b
     */
    function ica_2b(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 27, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2b');
    } // Ica 2b

    /**
     * Reporte ICA 2c
     */
    function ica_2c(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 28, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2c');
    } // Ica 2c

    /**
     * Reporte ICA 2d
     */
    function ica_2d(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 29, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2d');
    } // Ica 2d

    /**
     * Reporte ICA 2e
     */
    function ica_2e(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 36, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2e');
    } // Ica 2e

    /**
     * Reporte ICA 2f
     */
    function ica_2f(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 38, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2f');
    } // ica 2f

    /**
     * Reporte ICA 2g
     */
    function ica_2g(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 40, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2g');
    } // Ica 2g

    /**
     * Reporte ICA 2h
     */
    function ica_2h(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 42, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_2h');
    } // Ica 2h

    /**
     * Reporte ICA 3a
     */
    function ica_3a(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 44, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/ICA_3a');
    } // Ica 3a

    /**
     *
     */
    function inspeccion_maquinaria(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 51, $this->uri->segment(3));

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/inspeccion_maquinaria');
    } // inspeccion_maquinaria

    /**
     *
     */
    function inspeccion_maquinaria_hallazgos(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        // $this->auditoria_model->insertar(1, 51, $this->uri->segment(3));

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/excel/inspeccion_maquinaria_hallazgos');
    } // inspeccion_maquinaria_hallazgos

    /**
     * Obtiene los años en los cuales se ha creado solicitudes
     * @return [json] [Arreglo con los años]
     */
    function obtener_anios(){
        //Se obtienen los anios del modelo, e inmediatamente se envian a la vista
        print json_encode($this->reporte_model->listar_anios());
    } // obtener_anios

    /**
     * Lista las areas de las solicitudes
     * @return [json] [description]
     */
    function obtener_areas(){
        //Se obtienen los anios del modelo, e inmediatamente se envian a la vista
        print json_encode($this->solicitud_model->cargar_areas_encargadas());
    } // obtener_areas

    /**
     * Reporte que genera la plantilla de solicitudes
     */
    function solicitud_recepcion(){
        //Se carga la vista que contiene la plantilla
        $this->load->view('reportes/pdf/solicitud_recepcion');

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 11, null);
    }//Fin plantilla_solicitud

    /**
     * Genera un reporte con las fotos de un anexo
     */
    function registro_fotografico(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(2, 20, null);
        //Se carga la vista que contiene el reporte
        $this->data['id_area'] = $this->uri->segment(3);
        $this->data['anio'] = $this->uri->segment(4);
        $this->data['mes'] = $this->uri->segment(5);
        $this->load->view('reportes/pdf/registro_fotografico', $this->data);
    }//Fin registro_fotografico

    /**
     */
    function registro_fotografico_1a(){
        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        //$this->auditoria_model->insertar(2, 20, null);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/pdf/1a_registro_fotografico');
    } // registro_fotografico_1a

    /**
     * Reporte que genera la plantilla de solicitudes
     */
    function solicitud_seguimiento(){
        //Se recibe el id de la solicitud
        $id_solicitud = $this->data['id_solicitud'] = $this->uri->segment(3);

        //Se carga la vista que contiene el reporte
        $this->load->view('reportes/pdf/solicitud_seguimiento', $this->data);

        //Se inserta el registro en auditoria enviando numero de modulo, tipo de auditoria y id correspondiente
        $this->auditoria_model->insertar(1, 5, $id_solicitud);
    }//Fin solicitud

		/**
     * Funcion que genera la recepcion de solicitudes
     */
    function recepcion_solicitudes(){
        //Se carga la vista que contiene el reporte
				$this->data['mes'] = $this->uri->segment(4);
				$this->data['anio'] = $this->uri->segment(3);
        $this->load->view('reportes/excel/recepcion_solicitudes', $this->data);
    }//Fin recepcion_solicitudes
}
/* End of file reporte.php */
/* Location: ./gestion_ambiental/application/controllers/reporte.php */

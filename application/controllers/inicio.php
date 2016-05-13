<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Inicio
 * 
 * @author              John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Inicio extends CI_Controller{
    /**
    * Funci&oacute;n constructora de la clase. Esta funci&oacute;n se encarga de verificar que se haya
    * iniciado sesi&oacute;n, si no se ha iniciado sesi&oacute;n inmediatamente redirecciona
    * 
    * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access	public
    */
    function __construct() {
        parent::__construct();
        
        //se cargan los permisos
        $this->data['acceso'] = $this->session->userdata('Acceso');

        //Si no ha iniciado sesion, se redirecciona
        if($this->session->userdata('Pk_Id_Usuario') != true){
            redirect('sesion');
        }//Fin if
        //Se cargan los modelos, librerias y helpers
        $this->load->model(array('inicio_model', 'ica_model', 'hoja_vida_model'));
    }//Fin construct()
    
    /**
     * 
     * Pantalla de inicio del modulo
     *
     *
     * @param 
     * @return 
     * @throws 
     */
    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Inicio';
        //Se establece la vista de la barra lateral
        $this->data['menu'] = 'inicio/menu_inicio';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'inicio/inicio_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }//Fin index()

    function prueba(){
        // Escriba un programa que imprima los números del 1 al 100. Pero para los múltiplos de 3 imprima "Fizz" en lugar del número y para los múltiplos de 5 imprima "Buzz". Para los números que son múltiplos de ambos imprima "FizzBuzz"

        for ($i=1; $i <= 100 ; $i++) { 
            if ($i %3 == 0 && $i %5 == 0) {
                echo "$i - FizzBuzz<br>";
            }elseif ($i %3 == 0) {
                echo "$i - Fizz<br>";
            }elseif($i %5 == 0){
                echo "$i - Buzz<br>";
            }else{
                echo "$i<br>";
            }
        }
    }
}
/* Fin del archivo inicio.php */
/* Ubicación: ./application/controllers/inicio.php */
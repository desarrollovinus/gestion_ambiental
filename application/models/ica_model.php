<?php
/**
 * Modelo encargado de gestionar toda la informacion de los registros
 * de auditoria
 * 
 * @author 				John Arley Cano Salinas
 * @copyright           HATOVIAL S.A.S.
 */
Class Ica_model extends CI_Model{
	/**
     * Funci&oacute;n constructora de la clase. Esta funci&oacute;n se encarga de verificar que se haya
     * iniciado sesi&oacute;n, si no se ha iniciado sesi&oacute;n inmediatamente redirecciona
     * 
     * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
	function __construct() {
        parent::__construct();
        //Se carga la base de datos solicitudes_ica
        $this->db_ica = $this->load->database('ica', TRUE);
    }

    function cargar_conductores(){
        $sql =
        "SELECT
        hojas_vida.Pk_Id_Hoja_Vida AS Pk_Id_Hoja_Vida_Conductor,
        hojas_vida.Nombres
        FROM
        hojas_vida
        LEFT JOIN tbl_oficios ON hojas_vida.Fk_Id_Oficio = tbl_oficios.Pk_Id_Oficio
        WHERE
        tbl_oficios.Nombre LIKE '%Conductor%' AND
        hojas_vida.Contratado = 1
        ORDER BY
        hojas_vida.Nombres";

        //Se ejecuta y retorna la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_categorias_vehiculos(){
        //Columnas a retornar
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', '17');
        $this->db_ica->order_by('Nombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db_ica->get('tbl_valores')->result();
    }

    /**
     * Carga los formatos ICA
     * 
     * @return [array] [Formatos]
     */
    function cargar_formatos(){
        //Columnas a retornar
        $this->db_ica->select('*');
        $this->db_ica->order_by('Nombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db_ica->get('tbl_formatos')->result();
    }//Fin cargar_formatos()

    /**
     * Lista los tramos que tienen al menos una ficha asociada
     * 
     * @return [array] [Tramos]
     */
    function cargar_tramos(){
        //Columnas a retornar
        $sql = 
        "SELECT
            solicitudes.tbl_tramos.Pk_Id_Tramo,
            solicitudes.tbl_tramos.Nombre
        FROM
            ica.tbl_fichas
            INNER JOIN solicitudes.tbl_tramos ON ica.tbl_fichas.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo

        GROUP BY
            solicitudes.tbl_tramos.Pk_Id_Tramo

        ORDER BY
            solicitudes.tbl_tramos.Nombre";

        //Se ejecuta y retorna la consulta
        return $this->db->query($sql)->result();
    }//Fin cargar_tramos()

    /**
     * Esta funcion carga las fichas relacionadas a un formato
     * 
     * @param  [int] $id_tramo [id del tramo]
     * @return [array]           [Fichas]
     */
	function cargar_fichas($id_tramo){
		//Columnas a retornar
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Tramo', $id_tramo);
        
        //Se ejecuta y retorna la consulta
        return $this->db_ica->get('tbl_fichas')->result();
	}//Fin cargar_fichas()

    function cargar_maquinas(){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', '16');
        $this->db_ica->order_by('Nombre');

        return $this->db_ica->get('tbl_valores')->result();
    }//Fin cargar_maquinas

    /**
     * Carga los periodos
     * 
     * @return [array] [Períodos]
     */
    function cargar_periodos(){
        //Columnas a retornar
        $this->db_ica->select('*');
        
        //Se ejecuta y retorna la consulta
        return $this->db_ica->get('tbl_periodos')->result();
    }//Fin cargar_periodos()

    function listar_3a_requerimientos($id_periodo, $id_tramo, $id_ficha){
        //Columnas a retornar
        $this->db_ica->select('*');

        //Condiciones
        $this->db_ica->where(array("Fk_Id_Periodo" => $id_periodo, "Fk_Id_Tramo" => $id_tramo, "Fk_Id_Ficha" => $id_ficha));
        
        //Se ejecuta y retorna la consulta
        return $this->db_ica->get('3a')->result();
    }

    /**
     * Consulta y envia de base de datos los registros asociados a un id de ficha
     * desde la tabla tbl_ficha_registro
     * 
     * @param  [int] $id_ficha [Id de la ficha]
     * @return [array]           [fichas]
     */
    function cargar_registros($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->from('tbl_registros');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);
        $this->db_ica->order_by('Descripcion');
        $this->db_ica->join('tbl_ficha_registros', 'tbl_ficha_registros.Fk_Id_Registro = tbl_registros.Pk_Id_Registro');
        return $this->db_ica->get()->result();
    }//Fin cargar_periodos()

    /**
     * Consulta el id de la relacion entre el id de la ficha y el id del registro
     * 
     * @param  [int] $id_ficha    [Id de la ficha]
     * @param  [int] $id_registro [Id del registro]
     * @return [array]              [Datos de los registros asociados]
     */
    function cargar_relacion_registros($id_ficha, $id_registro){
        $this->db_ica->select('Pk_Id_Ficha_Registro');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);
        $this->db_ica->where('Fk_Id_Registro', $id_registro);

        //Se hace un recorrido para tomar el id
        foreach ($this->db_ica->get('tbl_ficha_registros')->result() as $res) {
            //Se retorna el id
            return $res->Pk_Id_Ficha_Registro;
        }//Fin foreach
    }//Fin cargar_relacion_registros()

    /**
     * Caga los subcontratistas que se encuentran en la tabla tbl_valores 
     * y que se identifican por un id de valor especifico
     * 
     * @return [array] [Subcontratistas]
     */
    function cargar_subcontratistas(){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', 1);
        $this->db_ica->order_by('Nombre');

        return $this->db_ica->get('tbl_valores')->result();
    }//Fin cargar_subcontratistas

    /**
     * Caga los subcontratistas a los que un usuario tenga
     * acceso.
     * 
     * @return [array] [Subcontratistas]
     */
    function cargar_subcontratistas_usuario(){
        $sql =
        "SELECT
            pc.Fk_Id_Valor_Contratista Pk_Id_Valor,
            IFNULL(v.Nombre, 'Todos') Nombre
        FROM
            solicitudes.permisos_contratista AS pc
        LEFT JOIN ica.tbl_valores AS v ON pc.Fk_Id_Valor_Contratista = v.Pk_Id_Valor
        WHERE
            pc.Fk_Id_Usuario = {$this->session->userdata('Pk_Id_Usuario')}
        ORDER BY
            v.Nombre ASC";

        return $this->db_ica->query($sql)->result();
    }//Fin cargar_subcontratistas

    /**
     * cargar_material_dispuesto
     *      
     * @return [type] [description]
     */
    function cargar_material_dispuesto(){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', 2);
        $this->db_ica->order_by('Nombre');

        return $this->db_ica->get('tbl_valores')->result();
    }//Fin cargar_material_dispuesto

    function cargar_escombreras(){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', 3);
        $this->db_ica->order_by('Nombre');

        return $this->db_ica->get('tbl_valores')->result();        
    }

    function cargar_usos(){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', 4);
        $this->db_ica->order_by('Nombre');

        return $this->db_ica->get('tbl_valores')->result();        
    }

    function eliminar_anexo($id_anexo){
        //Si se elimina
        if ($this->db_ica->delete('anexos', array('Pk_Id_Anexo' => $id_anexo))) {
            //Se retorna true
            return 'true';
        }
    }

    /**
     * 
     * Guarda la informacion del anexo
     *
     * @param array 
     * @return int
     * @throws 
     */
    function guardar_anexo($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('anexos', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
        
       return true;
    }//Fin guardar_anexo

    /**
     * Guarda en base de datos una nueva version de una ficha
     * determinada
     * 
     * @param  [array] $datos [Datos de la version]
     * @return [bool]        [True o False dependiendo del exito o no de la transacción]
     */
    function guardar_version_ficha($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('fichas_versiones', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
    }//Fin guardar_version_ficha

    function listar_archivos_eliminar($id_anexo){
        // Se abre la carpeta
        $directorio = opendir('./archivos/'.$id_anexo.'/');

        //Se leen las fotos en el directorio
        while ($elemento = readdir($directorio)){
            //Tratamos los elementos . y .. que tienen todas las carpetas
            if( $elemento != "." && $elemento != ".."){
                // Si es una carpeta
                if( is_dir($directorio.$elemento) ){
                    // Muestro la carpeta
                    echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                } else {
                //Guardo el fichero en un arreglo
                //array_push($archivos, $elemento);
                $archivo = './archivos/'.$id_anexo.'/'.$elemento;
                }//Fin if
            }//Fin if
        }//fin while

        //Se devuelve el arreglo
        return $archivo;
    }

    
   function listar_registros($id_periodo, $id_ficha){
    $sql = 
    "SELECT
        tbl_registros.Pk_Id_Registro,
        tbl_registros.Descripcion AS Nombre,
        anexos.Fk_Id_Periodo,
        tbl_ficha_registros.Fk_Id_Ficha
    FROM
        anexos
        INNER JOIN tbl_ficha_registros ON anexos.Fk_Id_Ficha_Registro = tbl_ficha_registros.Pk_Id_Ficha_Registro
        INNER JOIN tbl_registros ON tbl_ficha_registros.Fk_Id_Registro = tbl_registros.Pk_Id_Registro
    WHERE
        anexos.Fk_Id_Periodo = {$id_periodo} AND
        tbl_ficha_registros.Fk_Id_Ficha = {$id_ficha}
    GROUP BY
        tbl_registros.Pk_Id_Registro";

    return $this->db_ica->query($sql)->result();
   }


    function listar_anexos($id_periodo, $id_ficha, $id_ficha_registro){
        $sql = 
        "SELECT
            anexos.Pk_Id_Anexo,
            tbl_fichas.Nombre,
            tbl_registros.Descripcion AS Registro,
            tbl_fichas.Pk_Id_Ficha,
            tbl_ficha_registros.Fk_Id_Registro,
            anexos.Fk_Id_Anexo_Tipo,
            anexos.Observacion
        FROM
            anexos
            INNER JOIN tbl_ficha_registros ON anexos.Fk_Id_Ficha_Registro = tbl_ficha_registros.Pk_Id_Ficha_Registro
            INNER JOIN tbl_fichas ON tbl_ficha_registros.Fk_Id_Ficha = tbl_fichas.Pk_Id_Ficha
            INNER JOIN tbl_registros ON tbl_ficha_registros.Fk_Id_Registro = tbl_registros.Pk_Id_Registro
        WHERE
            anexos.Fk_Id_Periodo = {$id_periodo} AND
            tbl_ficha_registros.Fk_Id_Ficha = {$id_ficha} AND
            tbl_registros.Pk_Id_Registro = {$id_ficha_registro}";

        return $this->db_ica->query($sql)->result();
    }

    function listar_anexos_usuario(){
        $sql =
        "SELECT
        ica.anexos.Pk_Id_Anexo,
        ica.anexos.Fk_Id_Anexo_Tipo,
        ica.tbl_periodos.Nombre AS Periodo,
        solicitudes.tbl_tramos.Nombre AS Tramo,
        ica.tbl_formatos.Nombre AS Formato,
        CONCAT(ica.tbl_fichas.Numero, ' ', ica.tbl_fichas.Nombre) AS Ficha,
        CONCAT(ica.tbl_registros.Codigo, ' ',ica.tbl_registros.Descripcion) AS Registro,
        ica.anexos.Fecha_Hora,
        ica.anexos.Fecha_Inicio,
        ica.anexos.Observacion
        FROM
        ica.anexos
        INNER JOIN ica.tbl_periodos ON ica.anexos.Fk_Id_Periodo = ica.tbl_periodos.Pk_Id_Periodo
        INNER JOIN ica.tbl_ficha_registros ON ica.anexos.Fk_Id_Ficha_Registro = ica.tbl_ficha_registros.Pk_Id_Ficha_Registro
        INNER JOIN ica.tbl_fichas ON ica.tbl_ficha_registros.Fk_Id_Ficha = ica.tbl_fichas.Pk_Id_Ficha
        INNER JOIN solicitudes.tbl_tramos ON ica.tbl_fichas.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
        INNER JOIN ica.tbl_formatos ON ica.anexos.Fk_Id_Formato = ica.tbl_formatos.Pk_Id_Formato
        INNER JOIN ica.tbl_registros ON ica.tbl_ficha_registros.Fk_Id_Registro = ica.tbl_registros.Pk_Id_Registro
        WHERE
        ica.anexos.Fk_Id_Usuario = {$this->session->userdata('Pk_Id_Usuario')}
        ORDER BY
        ica.anexos.Fecha_Hora DESC";

        return $this->db_ica->query($sql)->result();
    }



    /**
     * Lista las versiones que hay creadas para una ficha especifica
     * 
     * @param  [int] $id_ficha [Id de la ficha]
     * @return [array]           [Arreglo con las versiones de la ficha]
     */
    function listar_versiones($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('fichas_versiones')->result();
    }//Fin listar_versiones

    function obtener_id_anexo(){
        $this->db_ica->select_max('Pk_Id_Anexo');
        foreach ($this->db_ica->get('anexos')->result() as $anexo) {
            return $anexo->Pk_Id_Anexo;
        }
    }

    /**
     * Script que procesa la foto y la redimensiona, logrando reducir su tamaño 
     * hasta en un 98%
     * 
     * @param  [string] $ruta [Ruta del archivo temporal que se va a subir]
     */
    function procesar_foto($ruta, $directorio, $nombre){
        //Ruta de la imagen original
        $ruta_imagen = $ruta;

        //Creamos una variable imagen a partir de la imagen original
        $img_original = imagecreatefromjpeg($ruta_imagen);

        //Se define el maximo ancho y alto que tendra la imagen final
        $ancho_maximo = 640;
        $alto_maximo = 480;

        //Ancho y alto de la imagen original
        list($ancho, $alto) = getimagesize($ruta_imagen);

        //Se calcula ancho y alto de la imagen final
        $x_ratio = $ancho_maximo / $ancho;
        $y_ratio = $alto_maximo / $alto;

        /**
         * Si el ancho y el alto de la imagen no superan los maximos,
         * ancho final y alto final son los que tiene actualmente 
         */
        if( ($ancho <= $ancho_maximo) && ($alto <= $alto_maximo) ){
            //Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        } elseif (($x_ratio * $alto) < $alto_maximo){
            /*
            * si proporcion horizontal*alto mayor que el alto maximo,
            * alto final es alto por la proporcion horizontal
            * es decir, le quitamos al ancho, la misma proporcion que
            * le quitamos al alto
            *
            */
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $ancho_maximo;
        }else{
            /*
            * Igual que antes pero a la inversa
            */
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $alto_maximo;
        }//Fin if  
        
        /**
         * Si el ancho y el alto de la imagen no superan los maximos,
         * ancho final y alto final son los que tiene actualmente
         */
        if( ($ancho <= $ancho_maximo) && ($alto <= $alto_maximo) ){
            //Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        }//Fin if

        /*
        * si proporcion horizontal*alto mayor que el alto maximo,
        * alto final es alto por la proporcion horizontal
        * es decir, le quitamos al ancho, la misma proporcion que
        * le quitamos al alto
        *
        */
        elseif (($x_ratio * $alto) < $alto_maximo){
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $ancho_maximo;
        }else{
            /*
            * Igual que antes pero a la inversa
            */
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $alto_maximo;
        }  

        //Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
        $imagen_temporal = imagecreatetruecolor($ancho_final,$alto_final);

        //Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($imagen_temporal)
        imagecopyresampled($imagen_temporal, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

        //Se destruye variable $img_original para liberar memoria
        imagedestroy($img_original);

        //Definimos la calidad de la imagen final
        $calidad = 95;

        //Se crea la imagen final en el directorio indicado
        if(imagejpeg($imagen_temporal, $directorio.$nombre, $calidad)){
            return true;
        } else {
            return false;
        }
    }//Fin procesar_foto

    /**
     * Lista los anexos subidos
     * 
     * @param  [int] $id_ficha_registro [Id de la relacion entre la ficha y el registro]
     * @return [array]                    [nombres de las fotos]
     */
    function listar_anexos_subidos($id_anexo){
        // Se abre la carpeta
        $directorio = opendir('./archivos/'.$id_anexo.'/');

        //Se leen las fotos en el directorio
        while ($elemento = readdir($directorio)){
            //Tratamos los elementos . y .. que tienen todas las carpetas
            if( $elemento != "." && $elemento != ".."){
                // Si es una carpeta
                if( is_dir($directorio.$elemento) ){
                    // Muestro la carpeta
                    echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                } else {
                //Guardo el fichero en un arreglo
                //array_push($archivos, $elemento);
                $archivo = base_url().'archivos/'.$id_anexo.'/'.$elemento;
                }//Fin if
            }//Fin if
        }//fin while

        //Se devuelve el arreglo
        return $archivo;
    }//Fin listar_anexos_subidos()

    /**
     * [obtener_numero_ficha description]
     * @param  [type] $id_ficha [description]
     * @return [type]           [description]
     */
    function obtener_numero_ficha($id_ficha){
        $this->db_ica->select('Numero');
        $this->db_ica->where('Pk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('tbl_fichas')->result();
    }

    /**
     * Guarda las metas de los formatos ICA 1a
     * 
     * @param  [array] $datos [datos de la meta]
     * @return [boolean]        true: exito, false: error
     */
    function guardar_meta($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('1a', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
    }//Fin guardar_meta

    function cargar_nombre_select($tabla, $id, $valor){
        //Columnas a retornar
        $this->db_ica->select('Nombre');
        $this->db_ica->where($id, $valor);
        
        //Se ejecuta y retorna la consulta
        $campos = $this->db_ica->get($tabla)->result();
        
        //Se recorre el resultado
        foreach($campos as $row):
             //Se retorna el nombre
            return $row->Nombre;
        endforeach;
    }//Fin cargar_nombre_select()

    function cargar_metas($id_ficha){
        $this->db_ica->select('Pk_Id_Meta');
        $this->db_ica->select('Descripcion');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('1a')->result();
    }//Fin cargar_metas

    function guardar_parametro($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('1a_parametros', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
    }//Fin guardar_parametro

    function guardar_accion($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('1a_acciones', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
    }//Fin guardar_accion

    function cargar_acciones($id_meta){
        $this->db_ica->select('*');
        
        $this->db_ica->where('Fk_Id_Meta', $id_meta);

        //Se retorna el resultado
        return $this->db_ica->get('1a_acciones')->result();
    }//Fin cargar_metas

    function cargar_parametros($id_meta){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Meta', $id_meta);

        //Se retorna el resultado
        return $this->db_ica->get('1a_parametros')->result();
    }//Fin cargar_parametros

    function informacion_ficha($id_ficha){
        $sql = 
        "SELECT
            Max(fichas_versiones.Pk_Id_Relacion),
            fichas_versiones.Version,
            tbl_fichas.Numero,
            tbl_fichas.Nombre
        FROM
            fichas_versiones
            INNER JOIN tbl_fichas ON fichas_versiones.Fk_Id_Ficha = tbl_fichas.Pk_Id_Ficha
        WHERE
            tbl_fichas.Pk_Id_Ficha = {$id_ficha}";

        return $this->db_ica->query($sql)->row();
    }

    function guardar_estado_permiso($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('2a', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
    }

    function guardar_uso_recurso($datos){
        //Si se guarda el registro en base de datos
        if($this->db_ica->insert('2a_recurso', $datos)) {
            //Retorna true
            return true;
        } else {
            //Retorna false
            return false;
        }//Fin if
    }

    function guardar($tipo, $datos){
        //Variable que guardará el exito de la transacción
        $exito = false;

        //Switch
        switch ($tipo) {
            case '2a_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2a_monitoreo', $datos)) {
                    $exito = true;
                }
                break;
            
            case 'estado_concesion':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2b', $datos)) {
                    $exito = true;
                }
                break;

            case 'uso_concesion':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2b_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2b_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2b_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '2c':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2c', $datos)) {
                    $exito = true;
                }
                break;

            case '2c_recurso':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2c_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2c_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2c_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '2d':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2d', $datos)) {
                    $exito = true;
                }
                break;

            case '2d_recurso':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2d_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2d_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2d_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '2e':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2e', $datos)) {
                    $exito = true;
                }
                break;

            case '2e_recurso':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2e_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2e_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2e_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '2f':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2f', $datos)) {
                    $exito = true;
                }
                break;

            case '2f_recurso':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2f_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2f_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2f_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '2g':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2g', $datos)) {
                    $exito = true;
                }
                break;

            case '2g_recurso':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2g_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2g_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2g_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '2h':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2h', $datos)) {
                    $exito = true;
                }
                break;

            case '2h_recurso':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2h_recurso', $datos)) {
                    $exito = true;
                }
                break;

            case '2h_monitoreo':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('2h_monitoreo', $datos)) {
                    $exito = true;
                }
                break;

            case '3a':
                //Si se guarda el registro en base de datos
                if($this->db_ica->insert('3a', $datos)) {
                    $exito = true;
                }
                break;
        }

        return $exito;
    }

    function cargar_estado_permiso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2a')->result();
    }

    function cargar_uso_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2a_recurso')->result();
    }

    function cargar_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2a_monitoreo')->result();
    }

    function cargar_estado_concesion($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2b')->result();
    }

    function cargar_uso_concesion($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2b_recurso')->result();
    }

    function cargar_monitoreos_concesion($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2b_monitoreo')->result();
    }

    function cargar_2c($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2c')->result();
    }

    function cargar_2c_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2c_recurso')->result();
    }

    function cargar_2c_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2c_monitoreo')->result();
    }

    function cargar_2d($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2d')->result();
    }

    function cargar_2d_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2d_recurso')->result();
    }

    function cargar_2d_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2d_monitoreo')->result();
    }

    function cargar_2e($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2e')->result();
    }

    function cargar_2e_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2e_recurso')->result();
    }

    function cargar_2e_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2e_monitoreo')->result();
    }

    function cargar_2f($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2f')->result();
    }

    function cargar_2f_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2f_recurso')->result();
    }

    function cargar_2f_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2f_monitoreo')->result();
    }

    function cargar_2g($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2g')->result();
    }

    function cargar_2g_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2g_recurso')->result();
    }

    function cargar_2g_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2g_monitoreo')->result();
    }

    function cargar_2h($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2h')->result();
    }

    function cargar_2h_recurso($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2h_recurso')->result();
    }

    function cargar_2h_monitoreos($id_ficha){
        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Ficha', $id_ficha);

        //Se retorna el resultado
        return $this->db_ica->get('2h_monitoreo')->result();
    }
}
/* Fin del archivo ica_model.php */
/* Ubicación: ./application/models/ica_model.php */
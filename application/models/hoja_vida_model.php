<?php
Class Hoja_vida_model extends CI_Model{
	function __construct() {
        //Con esta linea se hereda el constructor de la clase Controller
        parent::__construct();
    }//Fin construct()

    function calcular_edad($fecha){
        //
        $dias = explode("-", $fecha, 3);
        $dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
        $edad = (int)((time()-$dias)/31556926 );

        //Se devuelve la edad
        return  $edad;
    }

    function cargar_niveles_estudio(){
        $this->db_ica = $this->load->database('ica', TRUE);

        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', 19);
        $this->db_ica->order_by('Observacion');

        return $this->db_ica->get('tbl_valores')->result();
    }//Fin cargar_niveles_estudio()

    function cargar_profesiones(){
        $this->db_ica = $this->load->database('ica', TRUE);

        $this->db_ica->select('*');
        $this->db_ica->where('Fk_Id_Lista', 20);
        $this->db_ica->order_by('Nombre');

        return $this->db_ica->get('tbl_valores')->result();
    }//Fin cargar_profesiones()

    function cargar_oficios(){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('Nombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('tbl_oficios')->result();
    }//Fin cargar_estados()

    function cargar_capacitaciones(){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('Nombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('capacitaciones')->result();
    }

    function cargar_capacitaciones_agregadas($id_hoja_vida){
        $sql =
        "SELECT
        capacitaciones.Nombre,
        hojas_vida_capacitaciones.Fecha,
        hojas_vida_capacitaciones.Horas,
        hojas_vida_capacitaciones.Pk_Id_Hoja_Vida_Capacitacion
        FROM
        hojas_vida_capacitaciones
        INNER JOIN capacitaciones ON hojas_vida_capacitaciones.Fk_Id_Capacitacion = capacitaciones.Pk_Id_Capacitacion
        WHERE Fk_Id_Hoja_Vida = {$id_hoja_vida}";
        
        //Se ejecuta y retorna la consulta
        return $this->db->query($sql)->result();
    }

    function contar($estado){
        //Columnas a retornar
        $this->db->where('Contratado', $estado);
        
        $resultado = $this->db->get('hojas_vida')->result();

        return count($resultado);
    }

    function contar_verificados($estado){
        //Columnas a retornar
        $this->db->where('Verificada', $estado);
        
        $resultado = $this->db->get('hojas_vida')->result();

        return count($resultado);
    }

    function validar_contratistas_usuario(){
        $this->db->select('*');
        $this->db->where('Fk_Id_Usuario', $this->session->userdata("Pk_Id_Usuario"));
        $this->db->where('Fk_Id_Valor_Contratista', 0);
        
        return $this->db->get('permisos_contratista')->num_rows();        
    }

    function eliminar_archivo($id_hoja_vida){
        //Si se elimina
        if ($this->db->delete('hojas_vida_archivos', array('Pk_Id_Hoja_Vida_Archivo' => $id_hoja_vida))) {
            //Se retorna true
            return 'true';
        }
    }

    function listar_vinculados(){
        $this->db->where('Contratado', '1');
        return $this->db->get('hojas_vida')->result();
    }

    function porcentaje_verificacion($numero){
        $resultado = $this->db->get('hojas_vida')->result();
        $total = count($resultado);

        $porcentaje = ($numero * 100);
        $porcentaje = $porcentaje / $total;

        return $porcentaje;

    }

    function guardar($datos){
        //Se ejecuta la insercion con los datos que vienen desde un arreglo
        $guardar = $this->db->insert('hojas_vida', $datos);
        
        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }//Fin guardar()

    function guardar_archivo($datos){
        //Si el registro es exitoso
        if($this->db->insert('hojas_vida_archivos', $datos)){
            //Retorna verdadero
            return true;
        }
    }

    function guardar_capacitacion($datos){
        //Si el registro es exitoso
        if($this->db->insert('capacitaciones', $datos)){
            //Retorna verdadero
            return true;
        }
    }

    function guardar_capacitacion_asistencia($datos){
        //Si el registro es exitoso
        if($this->db->insert('hojas_vida_capacitaciones', $datos)){
            //Retorna verdadero
            return true;
        }
    }

    function guardar_reporte($datos){
        //Se ejecuta la insercion con los datos que vienen desde un arreglo
        $guardar = $this->db->insert('hojas_vida_reporte', $datos);
        
        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }//Fin guardar()

    function listar_archivos($id_hoja_vida){
        $sql =
        "SELECT
            a.Pk_Id_Hoja_Vida_Archivo,
            s.Nombre AS Categoria,
            c.Nombre AS Subcategoria,
            a.Fecha_Hora Fecha
        FROM
            hojas_vida_archivos AS a
        INNER JOIN tbl_hojas_vida_subcategorias AS c ON a.Fk_Id_Hoja_Vida_Subcategoria = c.Pk_Id_Hoja_Vida_Subcategoria
        INNER JOIN tbl_hojas_vida_categorias AS s ON c.Fk_Id_Hoja_Vida_Categoria = s.Pk_Id_Hoja_Vida_Categoria
        WHERE
            a.Fk_Id_Hoja_Vida = {$id_hoja_vida}
        ORDER BY
            Categoria ASC,
            Subcategoria ASC,
            a.Fecha_Hora DESC";

        return $this->db->query($sql)->result();
    }

    function listar_archivos_subidos($id_archivo){
        // Se abre la carpeta
        $directorio = opendir('./archivos/hojas_vida/'.$id_archivo.'/');

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
                $archivo = base_url().'archivos/hojas_vida/'.$id_archivo.'/'.$elemento;
                }//Fin if
            }//Fin if
        }//fin while

        //Se devuelve el arreglo
        return $archivo;
    }

    function listar_archivos_eliminar($id_archivo){
        // Se abre la carpeta
        $directorio = opendir('./archivos/hojas_vida/'.$id_archivo.'/');

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
                $archivo = './archivos/hojas_vida/'.$id_archivo.'/'.$elemento;
                }//Fin if
            }//Fin if
        }//fin while

        //Se devuelve el arreglo
        return $archivo;
    }

    function listar_categorias(){
        $this->db->select('*');
        $this->db->order_by('Orden');
        return $this->db->get('tbl_hojas_vida_categorias')->result();
    }

    function listar_subcategorias($id_categoria){
        $this->db->where('Fk_Id_Hoja_Vida_Categoria', $id_categoria);
        $this->db->order_by('Orden');
        return $this->db->get('tbl_hojas_vida_subcategorias')->result();
    }

    function obtener_id_archivo(){
        $this->db->select_max('Pk_Id_Hoja_Vida_Archivo');
        foreach ($this->db->get('hojas_vida_archivos')->result() as $archivo) {
            return $archivo->Pk_Id_Hoja_Vida_Archivo;
        }
    }

    function validar_documento($numero_documento){
        //Se valida la cédula
        $this->db->where('Documento', $numero_documento);
        
        //Se ejecuta la consulta en la base de datos que consulta si existe
        $documento = $this->db->get('hojas_vida')->row();
        
        //Se verifica que la consulta devuelva algo
        if($documento){
            //Si trajo algo, se retorna verdadero
            return true;
        }
    }

    function listado($datos){
        // Variables vacías
        $condiciones = "";
        $id_hoja_vida = "";

        // Si es id de hoja de vida
        if(isset($datos["id_hoja_vida"])){
            // Solo condición de hoja de vida
            $id_hoja_vida = "AND hv.Pk_Id_Hoja_Vida = $datos[id_hoja_vida]";
        } else {
            // Si son vinculados
            if ($datos['vinculado'] == "1") {
                // Muestra los vinculados
                // $vinculado = "AND hv.Contratado = 1";
                $condiciones .= "AND hv.Contratado = 1 ";
            } // if

            // Si son no vinculados
            if ($datos['vinculado'] == "0") {
                // Muestra los no vinculados  y sin marcar en el campo Contratado
                // $vinculado = "AND hv.Contratado = 0 OR hv.Contratado IS NULL";
                $condiciones .= "AND (hv.Contratado = 0 OR hv.Contratado IS NULL) ";
            } // if

            // Si el contratista es igual a cero
            if ($datos['contratista'] == "N") {
                // No se mostrará ningún registro
                // $contratista = "AND hv.Pk_Id_Hoja_Vida IS NULL";
                $condiciones .= "AND hv.Pk_Id_Hoja_Vida IS NULL ";
            } // if

            // Si son los vinculados y trae un contratista específico
            if ($datos['vinculado'] == "1" && $datos["contratista"] > 0) {
                // Se muestran, además, las hojas de vida de ese contratista
                // $contratista = "AND hv.Fk_Id_Valor_Contratista = $datos[contratista]";
                $condiciones .= "AND hv.Fk_Id_Valor_Contratista = $datos[contratista] ";
            } // if

            // Si trae un contratista específico
            if ($datos["contratista"] > 0) {
                // Se muestran, además, las hojas de vida de ese contratista
                // $contratista = "AND hv.Fk_Id_Valor_Contratista = $datos[contratista]";
                $condiciones .= "AND hv.Fk_Id_Valor_Contratista = $datos[contratista] ";
            } // if

            // Si es calificado o no calificado
            if ($datos['calificado'] != "") {
                // Muestra los de mano de obra calificada o no
                // $calificado = "AND solicitudes.o.Calificado = $datos[calificado]";
                $condiciones .= "AND solicitudes.o.Calificado = $datos[calificado] ";
            } // if

            // Si trae oficio
            if ($datos['oficio'] > 0) {
                // Se incluye el oficio
                // $oficio = "AND o.Pk_Id_Oficio = $datos[oficio]";
                $condiciones .= "AND o.Pk_Id_Oficio = $datos[oficio] ";
            } // if

            // Si trae municipio
            if ($datos['municipio'] > 0) {
                // Se incluye el municipio
                // $oficio = "AND m.Pk_Id_Municipio = $datos[municipio]";
                $condiciones .= "AND m.Pk_Id_Municipio = $datos[municipio] ";
            } // if

            // Si es verificado o no
            if ($datos['verificado'] != "") {
                // Muestra los verificados o no
                // $verificado = "AND hv.Verificada = $datos[verificado]";
                $condiciones .= "AND hv.Verificada = $datos[verificado] ";
            } // if
        } // if 

        // Consulta
        $sql =
        "SELECT
            hv.Pk_Id_Hoja_Vida,
            NULL AS Fecha_Generacion,
            hv.Documento,
            hv.Nombres,
            hv.Telefono,
            hv.Fecha_Nacimiento,
            hv.Fecha_Vinculacion,
            hv.Id_Genero,
            m.Pk_Id_Municipio,
            m.Nombre AS Municipio,
            hv.Fk_Id_Sector,
            s.Nombre AS Sector,
            t.Nombre AS Tramo,
            hv.Fk_Id_Frente,
            f.Nombre,
            hv.Id_Labores_Ejecutadas,
            hv.Direccion,
            hv.Fecha_Recepcion,
            hv.Fk_Id_Oficio,
            o.Nombre AS Oficio,
            hv.Observaciones,
            hv.Recibida,
            hv.Ubicacion_Fisica,
            hv.Fk_Id_Valor_Contratista,
            hv.Fk_Id_Valor_Nivel_Estudio,
            hv.Fk_Id_Usuario,
            hv.Fk_Id_Valor_Profesion,
            v.Nombre AS Subcontratista,
            solicitudes.hv.Contratado AS Vinculado,
            hv.Verificada AS Verificado,
            hv.Fk_Id_Tramo,
            CASE hv.Id_Genero
            WHEN '1' THEN
                'M'
            WHEN '2' THEN
                'F'
            END AS Genero,
             CASE hv.Id_Labores_Ejecutadas
            WHEN '2' THEN
                'Operaciones'
            WHEN '1' THEN
                'Obra'
            WHEN '3' THEN
                'Administración'
            END AS Labor_Ejecutada,
             CASE solicitudes.o.Calificado
            WHEN '1' THEN
                'Si'
            WHEN '0' THEN
                'No'
            END AS Calificado,
             CASE hv.Contratado
            WHEN '1' THEN
                'Si'
            WHEN '0' THEN
                'No'
            END AS Contratado,
             CASE hv.Verificada
            WHEN '1' THEN
                'Si'
            WHEN '0' THEN
                'No'
            END AS Verificada,
            vpr.Nombre Profesion
        FROM
            solicitudes.hojas_vida AS hv
        LEFT JOIN solicitudes.tbl_sectores AS s ON hv.Fk_Id_Sector = s.Pk_Id_Sector
        LEFT JOIN solicitudes.tbl_municipios AS m ON s.Fk_Id_Municipio = m.Pk_Id_Municipio
        LEFT JOIN solicitudes.tbl_tramos AS t ON hv.Fk_Id_Tramo = t.Pk_Id_Tramo
        LEFT JOIN solicitudes.tbl_frentes AS f ON hv.Fk_Id_Frente = f.Pk_Id_Frente
        LEFT JOIN solicitudes.tbl_oficios AS o ON hv.Fk_Id_Oficio = o.Pk_Id_Oficio
        LEFT JOIN ica.tbl_valores AS v ON hv.Fk_Id_Valor_Contratista = v.Pk_Id_Valor
        LEFT JOIN ica.tbl_valores AS vpr ON hv.Fk_Id_Valor_Profesion = vpr.Pk_Id_Valor
        WHERE
            hv.Pk_Id_Hoja_Vida IS NOT NULL
            {$condiciones}
            {$id_hoja_vida}
        ORDER BY
            hv.Nombres ASC";

        // Si es id de hoja de vida
        if(isset($datos["id_hoja_vida"])){
            // Solo un registro
            return $this->db->query($sql)->row();
        } else {
            // Más de un registro
            return $this->db->query($sql)->result();
        } // if
    }

    /** Borrar */
    function listado_borrar($id_hoja_vida, $contratado, $verificado, $oficio){
        // Se toman los valores
        if($id_hoja_vida == 'no'){
            $es_id_hoja_vida = '';
        }else{
            $es_id_hoja_vida = " AND hv.Pk_Id_Hoja_Vida = {$id_hoja_vida}";
        }

        if($contratado == 'no'){
            $es_contratado = '';
        }else{
            $es_contratado = " AND hojas_vida.Contratado = '{$contratado}'";
        }

        if($verificado == 'no'){
            $es_verificado = '';
        }else{
            $es_verificado = " AND hojas_vida.Verificada = '{$verificado}'";
        }

        if($oficio == 'no'){
            $es_oficio = '';
        }else{
            $es_oficio = " AND hojas_vida.Fk_Id_Oficio = '{$oficio}'";
        }

        $sql =
        "SELECT
            solicitudes.hojas_vida.Pk_Id_Hoja_Vida,
            '' AS Fecha_Generacion,
            solicitudes.hojas_vida.Documento,
            solicitudes.hojas_vida.Nombres,
            solicitudes.hojas_vida.Telefono,
            solicitudes.hojas_vida.Fecha_Nacimiento,
            solicitudes.hojas_vida.Id_Genero,
            CASE hojas_vida.Id_Genero WHEN '1' THEN 'M' WHEN '2' THEN 'F' END AS Genero,
            solicitudes.tbl_municipios.Pk_Id_Municipio,
            tbl_municipios.Nombre AS Municipio,
            solicitudes.hojas_vida.Fk_Id_Sector,
            tbl_sectores.Nombre AS Sector,
            solicitudes.hojas_vida.Fk_Id_Tramo,
            solicitudes.tbl_tramos.Nombre AS Tramo,
            solicitudes.hojas_vida.Fk_Id_Frente,
            solicitudes.tbl_frentes.Nombre AS Frente,
            solicitudes.hojas_vida.Id_Labores_Ejecutadas,
            CASE hojas_vida.Id_Labores_Ejecutadas WHEN '2' THEN 'Operaciones' WHEN '1' THEN 'Obra' WHEN '3' THEN 'Administración END AS Labor_Ejecutada,
            solicitudes.hojas_vida.Direccion,
            solicitudes.hojas_vida.Fecha_Recepcion,
            CASE solicitudes.tbl_oficios.Calificado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Calificado,
            solicitudes.hojas_vida.Fk_Id_Oficio,
            solicitudes.tbl_oficios.Nombre AS Oficio,
            CASE hojas_vida.Contratado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Contratado,
            solicitudes.hojas_vida.Observaciones,
            solicitudes.hojas_vida.Recibida,
            solicitudes.hojas_vida.Ubicacion_Fisica,
            solicitudes.hojas_vida.Fk_Id_Valor_Contratista,
            ica.tbl_valores.Nombre AS Subcontratista,
            solicitudes.hojas_vida.Contratado AS Vinculado,
            CASE hojas_vida.Verificada WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Verificada,
            hojas_vida.Verificada AS Verificado
        FROM
            solicitudes.hojas_vida
            LEFT JOIN solicitudes.tbl_sectores ON solicitudes.hojas_vida.Fk_Id_Sector = solicitudes.tbl_sectores.Pk_Id_Sector
            LEFT JOIN solicitudes.tbl_municipios ON solicitudes.tbl_sectores.Fk_Id_Municipio = solicitudes.tbl_municipios.Pk_Id_Municipio
            LEFT JOIN solicitudes.tbl_oficios ON solicitudes.hojas_vida.Fk_Id_Oficio = solicitudes.tbl_oficios.Pk_Id_Oficio
            LEFT JOIN ica.tbl_valores ON solicitudes.hojas_vida.Fk_Id_Valor_Contratista = ica.tbl_valores.Pk_Id_Valor
            LEFT JOIN solicitudes.tbl_tramos ON solicitudes.hojas_vida.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
            LEFT JOIN solicitudes.tbl_frentes ON solicitudes.hojas_vida.Fk_Id_Frente = solicitudes.tbl_frentes.Pk_Id_Frente
        WHERE
            hojas_vida.Pk_Id_Hoja_Vida IS NOT NULL
            {$es_id_hoja_vida}
            {$es_contratado}
            {$es_verificado}
            {$es_oficio}
        ORDER BY
            solicitudes.hojas_vida.Nombres";

        if ($id_hoja_vida == 'no') {
            // Retorno de resultado
            return $this->db->query($sql)->result();
        }else{
            // Retorno de resultado
            return $this->db->query($sql)->row();
        }
    }

    function listado_reporte_consolidado(){
        $sql =
        "SELECT
        solicitudes.hojas_vida.Pk_Id_Hoja_Vida,
        CASE solicitudes.hojas_vida.Id_Genero WHEN '1' THEN 'M' WHEN '2' THEN 'F' END AS Genero,
        CASE solicitudes.hojas_vida.Id_Labores_Ejecutadas WHEN '2' THEN 'Operaciones' WHEN '1' THEN 'Obra' WHEN '3' THEN 'Administración' END AS Labor_Ejecutada,
        CASE solicitudes.tbl_oficios.Calificado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Calificado,
        CASE solicitudes.hojas_vida.Contratado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Contratado,
        CASE solicitudes.hojas_vida.Verificada WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Verificada,
        null AS Fecha_Generacion,
        solicitudes.hojas_vida.Documento,
        solicitudes.hojas_vida.Nombres,
        solicitudes.hojas_vida.Telefono,
        solicitudes.hojas_vida.Fecha_Nacimiento,
        solicitudes.tbl_municipios.Nombre AS Municipio,
        solicitudes.tbl_sectores.Nombre AS Sector,
        solicitudes.tbl_tramos.Nombre AS Tramo,
        solicitudes.tbl_frentes.Nombre AS Frente,
        solicitudes.hojas_vida.Direccion,
        solicitudes.hojas_vida.Fecha_Recepcion,
        solicitudes.tbl_oficios.Nombre AS Oficio,
        solicitudes.hojas_vida.Observaciones,
        solicitudes.hojas_vida.Ubicacion_Fisica,
        ica.tbl_valores.Nombre AS Subcontratista
        FROM
        solicitudes.hojas_vida
        LEFT JOIN solicitudes.tbl_sectores ON solicitudes.hojas_vida.Fk_Id_Sector = solicitudes.tbl_sectores.Pk_Id_Sector
        LEFT JOIN solicitudes.tbl_municipios ON solicitudes.tbl_sectores.Fk_Id_Municipio = solicitudes.tbl_municipios.Pk_Id_Municipio
        LEFT JOIN solicitudes.tbl_tramos ON solicitudes.hojas_vida.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
        LEFT JOIN solicitudes.tbl_frentes ON solicitudes.hojas_vida.Fk_Id_Frente = solicitudes.tbl_frentes.Pk_Id_Frente
        LEFT JOIN solicitudes.tbl_oficios ON solicitudes.hojas_vida.Fk_Id_Oficio = solicitudes.tbl_oficios.Pk_Id_Oficio
        LEFT JOIN ica.tbl_valores ON solicitudes.hojas_vida.Fk_Id_Valor_Contratista = ica.tbl_valores.Pk_Id_Valor
        ORDER BY
        solicitudes.hojas_vida.Nombres ASC";

        $sql_ =
        "SELECT
        hv.Pk_Id_Hoja_Vida,
        ( SELECT MAX(hvr.Fecha) FROM hojas_vida_reporte AS hvr WHERE hvr.Fk_Id_Hoja_Vida = hv.Pk_Id_Hoja_Vida ) AS Fecha_Generacion,
        hv.Documento,
        hv.Nombres,
        hv.Telefono,
        hv.Fecha_Nacimiento,
        oo.Nombre AS Labores_Ejecutadas
        FROM
        hojas_vida AS hv
        LEFT JOIN tbl_oficios AS o ON hv.Fk_Id_Oficio = o.Pk_Id_Oficio
        LEFT JOIN tbl_operaciones_obra AS oo ON o.Fk_Id_Operaciones_Obra = oo.Pk_Id_Operaciones_Obra
        ORDER BY
        hv.Nombres ASC";

        return $this->db->query($sql)->result();
    }

    function listado_reporte($fecha){
        //Consulta
        $sql =
        "SELECT
            solicitudes.hojas_vida.Pk_Id_Hoja_Vida,
            solicitudes.hojas_vida_reporte.Fecha AS Fecha_Generacion,
            solicitudes.hojas_vida.Documento,
            solicitudes.hojas_vida.Nombres,
            solicitudes.hojas_vida.Telefono,
            solicitudes.hojas_vida.Fecha_Nacimiento,
            CASE hojas_vida.Id_Genero WHEN '1' THEN 'Hombre' WHEN '2' THEN 'Mujer' END AS Genero,
            tbl_municipios.Nombre AS Municipio,
            tbl_sectores.Nombre AS Sector,
            solicitudes.tbl_tramos.Nombre AS Tramo,
            solicitudes.tbl_frentes.Nombre AS Frente,
            CASE hojas_vida.Id_Labores_Ejecutadas WHEN '2' THEN 'Operaciones' WHEN '1' THEN 'Obra' WHEN '3' THEN 'Administración' END AS Labor_Ejecutada,
            solicitudes.hojas_vida.Direccion,
            solicitudes.hojas_vida.Fecha_Recepcion AS Fecha_Recepcion,
            CASE solicitudes.tbl_oficios.Calificado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Calificado,
            solicitudes.tbl_oficios.Nombre AS Oficio,
            CASE hojas_vida.Contratado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Contratado,
            solicitudes.hojas_vida.Observaciones,
            solicitudes.hojas_vida.Ubicacion_Fisica,
            solicitudes.hojas_vida.Contratado AS Vinculado,
            solicitudes.hojas_vida.Telefono,
            ica.tbl_valores.Nombre AS Subcontratista,
            solicitudes.tbl_oficios.Nombre AS Oficio
        FROM
            solicitudes.hojas_vida_reporte
            INNER JOIN solicitudes.hojas_vida ON solicitudes.hojas_vida_reporte.Fk_Id_Hoja_Vida = solicitudes.hojas_vida.Pk_Id_Hoja_Vida
            LEFT JOIN ica.tbl_valores ON solicitudes.hojas_vida.Fk_Id_Valor_Contratista = ica.tbl_valores.Pk_Id_Valor
            LEFT JOIN solicitudes.tbl_tramos ON solicitudes.hojas_vida.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
            LEFT JOIN solicitudes.tbl_sectores ON solicitudes.hojas_vida.Fk_Id_Sector = solicitudes.tbl_sectores.Pk_Id_Sector
            LEFT JOIN solicitudes.tbl_municipios ON solicitudes.tbl_sectores.Fk_Id_Municipio = solicitudes.tbl_municipios.Pk_Id_Municipio
            LEFT JOIN solicitudes.tbl_frentes ON solicitudes.hojas_vida.Fk_Id_Frente = solicitudes.tbl_frentes.Pk_Id_Frente
            LEFT JOIN solicitudes.tbl_oficios ON solicitudes.hojas_vida.Fk_Id_Oficio = solicitudes.tbl_oficios.Pk_Id_Oficio
        WHERE solicitudes.hojas_vida_reporte.Fecha = '{$fecha}'
        ORDER BY
            Fecha_Generacion DESC";

        // Retorno de resultado
        return $this->db->query($sql)->result();
    }

    function listar_fechas(){
        
        $sql = 
        "SELECT
        hojas_vida_reporte.Fecha
        FROM
        hojas_vida_reporte
        GROUP BY
        hojas_vida_reporte.Fecha
        ORDER BY
        hojas_vida_reporte.Fecha DESC
        LIMIT 0, 10";

        return $this->db->query($sql)->result();
    }

    function listar_hojas_vida(){
        $sql = 
        "SELECT
            hojas_vida.Pk_Id_Hoja_Vida,
            hojas_vida.Nombres,
            hojas_vida.Documento,
            CASE hojas_vida.Contratado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Contratado,
            solicitudes.hojas_vida.Contratado AS Vinculado
        FROM
            hojas_vida";

        return $this->db->query($sql)->result();
    }

    function listar_hojas_vida_reporte($id_hoja_vida){
        $condicion = "";

        //El condicional depende de las variables que lleguen
        if($id_hoja_vida){
            //Si tiene id específico
            $condicion = "WHERE hojas_vida.Pk_Id_Hoja_Vida = {$id_hoja_vida}";
        }

        $sql = 
        "SELECT
            solicitudes.hojas_vida.Pk_Id_Hoja_Vida,
            solicitudes.hojas_vida_reporte.Fecha AS Fecha_Generacion,
            solicitudes.hojas_vida.Documento,
            solicitudes.hojas_vida.Nombres,
            solicitudes.hojas_vida.Telefono,
            solicitudes.hojas_vida.Fecha_Nacimiento,
            CASE hojas_vida.Id_Genero WHEN '1' THEN 'M' WHEN '2' THEN 'F' END AS Genero,
            tbl_municipios.Nombre AS Municipio,
            tbl_sectores.Nombre AS Sector,
            solicitudes.tbl_tramos.Nombre AS Tramo,
            solicitudes.tbl_frentes.Nombre AS Frente,
            CASE hojas_vida.Id_Labores_Ejecutadas WHEN '2' THEN 'Operaciones' WHEN '1' THEN 'Obra' WHEN '3' THEN 'Administración' END AS Labor_Ejecutada,
            solicitudes.hojas_vida.Direccion,
            solicitudes.hojas_vida.Fecha_Recepcion AS Fecha_Recepcion,
            -- CASE hojas_vida.Calificado WHEN '1' THEN 'Si' WHEN '2' THEN 'No' END AS Calificado,
            solicitudes.tbl_oficios.Nombre AS Oficio,
            CASE hojas_vida.Contratado WHEN '1' THEN 'Si' WHEN '0' THEN 'No' END AS Contratado,
            solicitudes.hojas_vida.Observaciones,
            solicitudes.hojas_vida.Contratado AS Vinculado,
            ica.tbl_valores.Nombre AS Subcontratista
        FROM
            solicitudes.hojas_vida
            INNER JOIN solicitudes.hojas_vida ON solicitudes.hojas_vida_reporte.Fk_Id_Hoja_Vida = solicitudes.hojas_vida.Pk_Id_Hoja_Vida
            LEFT JOIN ica.tbl_valores ON solicitudes.hojas_vida.Fk_Id_Valor_Contratista = ica.tbl_valores.Pk_Id_Valor
            LEFT JOIN solicitudes.tbl_tramos ON solicitudes.hojas_vida.Fk_Id_Tramo = solicitudes.tbl_tramos.Pk_Id_Tramo
            LEFT JOIN solicitudes.tbl_sectores ON solicitudes.hojas_vida.Fk_Id_Sector = solicitudes.tbl_sectores.Pk_Id_Sector
            LEFT JOIN solicitudes.tbl_municipios ON solicitudes.tbl_sectores.Fk_Id_Municipio = solicitudes.tbl_municipios.Pk_Id_Municipio
            LEFT JOIN solicitudes.tbl_frentes ON solicitudes.hojas_vida.Fk_Id_Frente = solicitudes.tbl_frentes.Pk_Id_Frente
            INNER JOIN solicitudes.tbl_oficios ON solicitudes.hojas_vida.Fk_Id_Oficio = solicitudes.tbl_oficios.Pk_Id_Oficio
        {$condicion}
        ORDER BY
            solicitudes.hojas_vida_reporte.Fecha DESC";

        return $this->db->query($sql)->result();
    }

    function actualizar($datos, $id_hoja_vida){
        $this->db->where('Pk_Id_Hoja_Vida', $id_hoja_vida);

        //Se ejecuta la actualizacion con la condicion
        if ($this->db->update('hojas_vida', $datos)) {
            return true;
        }
    }//Fin modificar()
}
/* End of file hoja_vida_model.php */
/* Location: ./application/models/hoja_vida_model.php */
?>
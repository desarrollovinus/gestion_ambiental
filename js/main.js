/**
 * Funcion que ejecuta una peticion ajax, ya sea guardar en formulario, consultar, modificar o eliminar
 *
 * @param  {string} url   URL donde irá la petición
 * @param  {JSON} datos arreglo JSON con los datos enviados por POST
 * @return {string}       Retorna un string o la informacíón que sea necesaria
 */
function enviar_ajax(url, datos){
    //Variable de exito
    var exito = false;

    //Petición ajax
    $.ajax({
        url: url,
        type: "POST",
        data: datos,
        async: false,
        success: function(respuesta) {
            //Si la respuesta es ok
            if(respuesta != "false"){
                //Exito
                exito = respuesta;
            } else {
                //Error
                exito = "false";
            }//Fin if
        }//Fin success
    });//Fin ajax
    
    //Se retorna el exito
    return exito;
}

/**
 * Funcion que ejecuta una peticion ajax, ya sea guardar en formulario, consultar, modificar o eliminar
 *
 * @param  {string} url   URL donde irá la petición
 * @param  {JSON} datos arreglo JSON con los datos enviados por POST
 * @return {string}       Retorna un string o la informacíón que sea necesaria
 */
function enviar_ajax_asincrono(url, datos){
    //Variable de exito
    var exito = false;

    //Petición ajax
    $.ajax({
        url: url,
        type: "POST",
        data: datos,
        async: true,
        success: function(respuesta) {
            //Si la respuesta es ok
            if(respuesta != "false"){
                //Exito
                exito = respuesta;
            } else {
                //Error
                exito = "false";
            }//Fin if
        }//Fin success
    });//Fin ajax
    
    //Se retorna el exito
    return exito;
}

function enviar_ajax_json(url, datos){
    //Variable de exito
    var exito = false;

    //Petición ajax
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: datos,
        async: false,
        success: function(respuesta) {
            //Si la respuesta es ok
            if(respuesta != "false"){
                //Exito
                exito = respuesta;
            } else {
                //Error
                exito = "false";
            }//Fin if
        }//Fin success
    });//Fin ajax
    
    //Se retorna el exito
    return exito;
}

//
function tiene_letras(texto){
    var letras = "1234567890";
    for(i=0; i < texto.length; i++){
        if(letras.indexOf(texto.charAt(i),0) == -1){
            return 1;
        }
    }
    return 0;
}

/**
 * Valida que no hayan numeros en la cadena de texto
 * 
 * @param  {[type]} string [description]
 * @return {[type]}        [description]
 */
function validar_texto(string){
	//Si la cadena no tiene
	if($.trim(string).length > 0){
		return true;
	} else {
		return false;
	}
}

/**
 * Limpia formulario
 * 
 * @param  {[type]} formulario [description]
 * @return {[type]}            [description]
 */
function limpiar(formulario){
    //Limpia
    $(formulario)[0].reset();
}


function validar_campos_vacios(campos){
    //Variable
    validacion = 0;

    //Recorrido para validar cada campo
    for (var i = 0; i < campos.length; i++){
        //validacion campo a campo
        if($.trim(campos[i]) != "") {
            validacion++;
        }
    };

    //Si todos los campos superan la validación
    if (validacion == campos.length) {
        //Retorna ok
        return true;
    } else {
        //Retorna falso
        return false;
    }

    //Se resetea la variable
    validacion = 0;
}//validar_campos_vacios

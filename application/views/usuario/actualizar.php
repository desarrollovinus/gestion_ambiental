<div class="row-fluid form-vertical">
	<!---->
	<label for="nombres">Nombres</label>
	<div class="form-inline">
		<input type="text" id="nombres" class="input-large" value="<?php echo $this->session->userdata('Nombres'); ?>" />
		<span class="nombres"></span>	
	</div>
	
	<!---->
	<label for="apellidos">Apellidos</label>
	<div class="form-inline">
		<input type="text" id="apellidos" class="input-large" value="<?php echo $this->session->userdata('Apellidos'); ?>" />
		<span class="apellidos"></span>
	</div>

	<!---->
	<label for="documento">Número de documento</label>
	<div class="form-inline">
		<input type="text" id="documento" class="input-large" value="<?php echo $this->session->userdata('Documento'); ?>" />
		<span class="documento"></span>
	</div>

	<!---->
	<label for="documento">Usuario</label>
	<div class="form-inline">
		<input type="text" id="documento" class="input-large" value="<?php echo $this->session->userdata('Usuario'); ?>" disabled />
		<span class="usuario"></span>	
	</div>

	<!---->
	<label for="pass">Contraseña</label>
	<div class="form-inline">
		<input type="text" id="password" class="input-large" placeholder="Digite sólo si la desea cambiar" />
		<span class="password"></span>	
	</div>
	
	<!---->
	<label for="pass">Correo electrónico</label>
	<div class="form-inline">
		<input type="text" id="email" class="input-large" value="<?php echo $this->session->userdata('Email'); ?>" />
		<span class="email"></span>
	</div>
	
	<!---->
	<label for="pass">Teléfono</label>
	<div class="form-inline">
		<input type="text" id="telefono" class="input-large" value="<?php echo $this->session->userdata('Telefono'); ?>" />
		<span class="telefono"></span>	
	</div>

	<button type="button" id="guardar" class="btn btn-primary">Guardar</button>
</div>
<script type="text/javascript">
	//Cuando el DOM este listo
    $(document).ready(function(){
    	$("#rango").on('change', function(){
    		$("#valor_rango").html($("#rango").val())
    		
    	})
    	
    	//Nombres
    	$('#nombres').on('keyup', function(){
    		//Si no hay texto
    		if(validar_texto( $(this).val() ) && tiene_letras( $(this).val() )){
    			$(".nombres").html('<i class="icon-ok-sign"></i>');
    		} else {
    			$(".nombres").html('<i class="icon-remove-sign"></i>');
    		}
    	});//Fin nombres

    	

    	//Guardar
    	$("#guardar").on('click', function(){
    		datos_usuario = {
	    		nombres: $("#nombres").val(),
	    		apellidos: $("#apellidos").val(),
	    		documento: $("#documento").val(),
	    		pass: $("#password").val(),
	    		email: $("#email").val(),
	    		telefono: $("#telefono").val()
	    	}
	    	
    		console.log(datos_usuario)
    	});//Fin guardar
    });//Fin dcument.ready
</script>
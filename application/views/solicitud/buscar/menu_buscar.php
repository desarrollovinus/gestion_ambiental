<div id="info_menu" class="hero-unit">
	<h4>Resultados de la b&uacute;squeda para "<?php echo $item; ?>"</h4>
	<p>
    	<a class="btn btn-primary btn-large">
      		Volver
    	</a>
	</p>
</div>
<script type="text/javascript">
	//Cuando el DOM este listo 
    $(document).ready(function(){
    	//Al dar clic en el boton volver
    	$('a').click(function(){
    		//Regresa al anterior
    		history.back();
    	})//Fin a
    })//Fin document.ready
</script>
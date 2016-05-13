<!--Se carga el modelo que lista las auditorias-->
<?php
$auditorias = $this->auditoria_model->listar(null);
$usuarios = $this->usuario_model->listar($this->config->item('id_aplicacion'));
?>
<div class="administracion">
	<?php
	$cont = 1;

	//Se recorre las auditorias
	foreach ($auditorias as $auditoria){
	?>
	<div class="box-header cabecera">
		<div class="numero"><?php echo $cont; ?></div>
		<div class="fecha" title="<?php echo $auditoria->Fecha_Hora; ?>"><?php echo $auditoria->Fecha_Hora; ?></div>
		<div class="usuario"><?php echo $auditoria->Nombres.' '.$auditoria->Apellidos; ?></div>
	</div>
	<div class="box-content cuerpo">
		<?php echo $auditoria->Detalle; ?>
	</div>
	<?php
	$cont++;
	}//Fin foreach auditorias
	?>
</div>
<script type="text/javascript">
	//Cuando el DOM este listo 
    $(document).ready(function(){
    	//Marca de fecha
		$(".fecha").timeago();		
    })
</script>
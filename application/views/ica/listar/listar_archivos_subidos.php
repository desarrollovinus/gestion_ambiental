<?php
// Si no hay registros
if(count($registros) == 0){
	echo '<div id="info_menu" class="hero-unit">No hay anexos subidos para esta ficha</div>';
	return false;
} 
	foreach ($registros as $registro) { ?>

	<div class="box-header">
		<a class="enlace_fotos" href="javascript:mostrar_seguimientos('<?php echo $registro->Pk_Id_Registro; ?>')">
			<?php echo $registro->Nombre; ?>
		</a>
	</div>
		<?php $anexos = $this->ica_model->listar_anexos($registro->Fk_Id_Periodo, $registro->Fk_Id_Ficha, $registro->Pk_Id_Registro); ?>
		<div class="box-content ocultar" id="<?php echo $registro->Pk_Id_Registro; ?>">
		<?php
		foreach ($anexos as $anexo) {
			$archivo = $this->ica_model->listar_anexos_subidos($anexo->Pk_Id_Anexo);

			if ($anexo->Fk_Id_Anexo_Tipo == 1) {
				?>
				<!--<div class="anexo_pdf"></div>-->
				<a href="#">
					<div class="anexo_pdf ">
						<!--<i class="icon-file"></i>-->
						<p><?php echo $anexo->Observacion; ?></p>
						<a href="<?php echo $archivo; ?>" target="blank">Abrir</a>
					</div>	
				</a>
				<?php
			}else{
				?>
				<div class="anexo_foto">
					<img title="<?php echo $anexo->Observacion; ?>" src="<?php echo $archivo; ?>" />
				</div>
				<?php
			}
		}
		?>
	</div>
<?php } ?>
<script type="text/javascript">
	function mostrar_seguimientos(id){
		console.log('Resultado: id ' + id)
		$("#" + id).slideToggle();
	}
</script>
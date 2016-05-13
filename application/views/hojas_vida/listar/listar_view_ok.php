<div class="tabbable">
	<ul class="nav nav-tabs">
		<li id="l_todos" ><a href="#todos" data-toggle="tab">Todos (<?php echo number_format($this->hoja_vida_model->contar('1') + $this->hoja_vida_model->contar('0'), 0, '', '.'); ?>)</a></li>
		<li class="active"><a href="#activos" data-toggle="tab">Vinculados (<?php echo number_format($this->hoja_vida_model->contar('1'), 0, '', '.'); ?>)</a></li>
		<li><a href="#inactivos" data-toggle="tab">No vinculados (<?php echo number_format($this->hoja_vida_model->contar('0'), 0, '', '.'); ?>)</a></li>
		<li><a href="#verificados" data-toggle="tab">Verificados (<?php echo number_format($this->hoja_vida_model->contar_verificados('1'), 0, '', '.'); ?>)</a></li>
		<li><a href="#no_verificados" data-toggle="tab">No verificados (<?php echo number_format($this->hoja_vida_model->contar_verificados('0'), 0, '', '.'); ?>)</a></li>
		<li><a href="#cargos" data-toggle="tab">Por cargo</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane" id="todos"></div>
		<div class="tab-pane active" id="activos">
		</div>
		<div class="tab-pane" id="inactivos">
			<div id="cont_desvinculados"></div>
		</div>
		<div class="tab-pane" id="verificados">
			
		</div>
		<div class="tab-pane" id="no_verificados">
			
		</div>
		<div class="tab-pane" id="cargos">
			<select class="span12">
				<option value="">Seleccione un cargo...</option>
				<?php foreach ($oficios as $oficio) { ?>
					<option value="<?php echo $oficio->Pk_Id_Oficio; ?>"><?php echo $oficio->Nombre; ?></option>
				<?php } ?>
			</select>

			<div id="cont_cargo"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    	// Se cargan los desvinculados
	    $("#inactivos").load("<?php echo site_url('hoja_vida/tabla'); ?>", {numero: 1, id_hoja_vida: 'no', contratado: '0', verificado: 'no', oficio: 'no'});

        // Se cargan los vinculados
	    $("#activos").load("<?php echo site_url('hoja_vida/tabla'); ?>", {numero: 2, id_hoja_vida: 'no', contratado: '1', verificado: 'no', oficio: 'no'});

	    // Se cargan todos
	    $("#todos").load("<?php echo site_url('hoja_vida/tabla'); ?>", {numero: 3, id_hoja_vida: 'no', contratado: 'no', verificado: 'no', oficio: 'no'});

	    // Se cargan los verificados
	    $("#verificados").load("<?php echo site_url('hoja_vida/tabla'); ?>", {numero: 4, id_hoja_vida: 'no', contratado: 'no', verificado: '1', oficio: 'no'});

	    // Se cargan los no verificados
	    $("#no_verificados").load("<?php echo site_url('hoja_vida/tabla'); ?>", {numero: 5, id_hoja_vida: 'no', contratado: 'no', verificado: '0', oficio: 'no'});

	    $("#cargos>select").on("change", function(){
	    	if($(this).val()){
	    		// Se cargan los de un oficio específico
		    	$("#cont_cargo").load("<?php echo site_url('hoja_vida/tabla'); ?>", {numero: 6, id_hoja_vida: 'no', contratado: 'no', verificado: 'no', oficio: $(this).val()});
	    	}
	    });
    });//document.ready
</script>
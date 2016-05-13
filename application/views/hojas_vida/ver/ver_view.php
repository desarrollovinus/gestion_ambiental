<?php
//Se obtienen del modelo las hojas de vida
$curriculos = $this->hoja_vida_model->listado($this->uri->segment(3));
$oficios = $this->hoja_vida_model->cargar_oficios();
$contratado = array("1" => "Si", "0" => "No");
//Recorrido para los oficios
foreach($oficios as $oficio):
	$_oficios[$oficio->Pk_Id_Oficio] = $oficio->Nombre;
endforeach;

$contratistas = $this->ica_model->cargar_subcontratistas();
//Recorrido para los contratistas
foreach($contratistas as $contratista):
	$_contratistas[$contratista->Pk_Id_Valor] = $contratista->Nombre;
endforeach;

?>
<div class="row-fluid">
	<!-- Cabecera -->
	<div class="box-header"><h2>Datos generales</h2></div><!-- Cabecera -->
	<!-- Cuerpo -->
	<div class="box-content">
		<div class="row-fluid">
			<!-- Recorrido por los datos de la hoja de vida -->
			<?php foreach ($curriculos as $curriculo) { ?>
				<!-- Columna 1 -->
				<div class="span6">
		            <!-- Identificación -->
		            <div>
		                <b>Número de identificación: </b>
		                <div id="documento" title="Haga clic para modificar el número de documento" data-toggle="tooltip" class="input-large"><?php echo $curriculo->Documento; ?></div>
		            </div><!-- Identificación -->
					
					<!-- Nombres -->
					<div>
		                <b>Nombres: </b>
		                <div id="edit_nombres" title="Haga clic para modificar el nombre" data-toggle="tooltip" class="input-large"><?php echo $curriculo->Nombres; ?></div>
		            </div><!-- Nombres -->
		            
					<!-- Teléfono -->
		            <div>
		                <b>Número de Teléfono: </b>
		                <div id="edit_telefono" title="Haga clic para modificar el número de teléfono" data-toggle="tooltip" class="input-large"><?php echo $curriculo->Telefono; ?></div>
		            </div><!-- Teléfono -->

		            <!-- Lugar -->
		            <div>
		                <b>Lugar: </b>
		                <div id="municipio" name="edit" data-toggle="tooltip">
		                    <?php echo $curriculo->Sector.', '.$curriculo->Municipio; ?>
		                </div>
		            </div><!-- Lugar -->
				</div><!-- Columna 1 -->
				
				<!-- Columna 2 -->
				<div class="span6">
					<!-- Oficio -->
		            <div>
	                    <b>Oficio:</b>
	                    <div id="edit_oficio" title="Haga clic para cambiar el oficio" data-toggle="tooltip">
	                        <?php echo $curriculo->Oficio; ?>
	                    </div>
	                </div><!-- Oficio -->

	                <!-- ¿Contratado? -->
		            <div>
	                    <b>Contratado?:</b>
	                    <div id="edit_laborando" title="Haga clic para cambiar el estado" data-toggle="tooltip">
	                        <?php echo $curriculo->Contratado; ?>
	                    </div>
	                </div><!-- ¿Contratado? -->

	                <!-- Contratista -->
		            <div>
	                    <b>Contratista:</b>
	                    <div id="edit_contratista" title="Haga clic para cambiar el estado" data-toggle="tooltip">
	                        <?php echo $curriculo->Subcontratista; ?>
	                    </div>
	                </div><!-- Contratista -->

					<!-- Dirección -->
		            <div>
		                <b>Dirección: </b>
		                <div id="edit_direccion" title="Haga clic para modificar la dirección" data-toggle="tooltip" class="input-large"><?php echo $curriculo->Direccion; ?></div>
		            </div><!-- Dirección -->
				</div><!-- Columna 2 -->
				<div class="clear"></div>

				<ul class="nav nav-list">
	                <li class="divider"></li>
	                <div id="edit_observacion" name="edit" title="Haga clic para modificar la descripci&oacute;n" data-toggle="tooltip"><?php echo $curriculo->Observaciones; ?></div><br/>
	            </ul>
			<?php } ?><!-- Recorrido por los datos de la hoja de vida -->
		</div><!-- Cuerpo -->
	</div>
</div>

<?php if (isset($acceso[13])) { ?>
	<script type="text/javascript">
		$(document).ready(function(){
			// Muestra los mensajes donde los campos pueden editarse
			$('[id^=edit]').tooltip({
		        placement: 'left'
		    });

			//Nombres
		    $("#edit_nombres").editable("<?php echo site_url('hoja_vida/modificar/'.$curriculo->Pk_Id_Hoja_Vida.'/Nombres'); ?>", {
		        // id   : 'elementid',
		        name : 'nuevo_valor',
		        indicator : 'Guardando...',
		        placeholder: '<label class="vacio">Especifique un nombre para esta hoja de vida</label>',
		        type   : 'text',
		        submit    : 'OK',
		        cancel    : 'Cancelar',
		        indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
		    });//Nombres

		    //Telefono
		    $("#edit_telefono").editable("<?php echo site_url('hoja_vida/modificar/'.$curriculo->Pk_Id_Hoja_Vida.'/Telefono'); ?>", {
		        // id   : 'elementid',
		        name : 'nuevo_valor',
		        indicator : 'Guardando...',
		        placeholder: '<label class="vacio">Especifique un número de teléfono</label>',
		        type   : 'text',
		        submit    : 'OK',
		        cancel    : 'Cancelar',
		        indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
		    });//Telefono

		    //Direccion
		    $("#edit_direccion").editable("<?php echo site_url('hoja_vida/modificar/'.$curriculo->Pk_Id_Hoja_Vida.'/Direccion'); ?>", {
		        name : 'nuevo_valor',
		        indicator : 'Guardando...',
		        placeholder: '<label class="vacio">Especifique una dirección</label>',
		        type   : 'text',
		        submit    : 'OK',
		        cancel    : 'Cancelar',
		        indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
		    });//Direccion

		    //Oficio
		    $('#edit_oficio').editable("<?php echo site_url('hoja_vida/modificar_select/'.$curriculo->Pk_Id_Hoja_Vida.'/Pk_Id_Oficio/Fk_Id_Oficio/tbl_oficios'); ?>", { 
                data : '<?php print json_encode($_oficios); ?>',
                placeholder: '<label class="vacio">Especifique un oficio</label>',
                id   : 'elementid',
                name : 'nuevo_valor',
                type   : 'select'
            });//Oficio
		    
		    //Laborando
		    $('#edit_laborando').editable("<?php echo site_url('hoja_vida/modificar_select/'.$curriculo->Pk_Id_Hoja_Vida.'/null/Contratado/null'); ?>", { 
                data : '<?php print json_encode($contratado); ?>',
                id   : 'elementid',
                placeholder: '<label class="vacio">Especifique si está laborando</label>',
                name : 'nuevo_valor',
                type   : 'select'
            });//Laborando

            //Contratista
		    $('#edit_contratista').editable("<?php echo site_url('hoja_vida/modificar_select/'.$curriculo->Pk_Id_Hoja_Vida.'/Pk_Id_Valor/Fk_Id_Valor_Contratista/tbl_valores'); ?>", { 
                data : '<?php print json_encode($_contratistas); ?>',
                placeholder: '<label class="vacio">Especifique un oficio</label>',
                id   : 'elementid',
                name : 'nuevo_valor',
                type   : 'select'
            });//Contratista

		    //Observación
            $('#edit_observacion').editable("<?php echo site_url('hoja_vida/modificar/'.$curriculo->Pk_Id_Hoja_Vida.'/Observaciones'); ?>", {
                name : 'nuevo_valor',
                indicator : 'Guardando...',
                placeholder: '<label class="vacio">Escriba las observaciones de las hojas de vida.</label>',
                type   : 'textarea',
                submit    : 'OK',
                cancel    : 'Cancelar',
                indicator : '<img src="<?php echo base_url() ?>img/cargando.gif">'
            });//Observación
		});
	</script>
<?php } ?>

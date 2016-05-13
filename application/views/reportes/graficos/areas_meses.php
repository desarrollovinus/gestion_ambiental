<div id="aqui"></div>
<div id="info" class="ocultar">aaa</div>
<!--<div id="container" style="width:100%; height:400px;"></div>-->
<script type="text/javascript">
    //Cuando el DOM este listo
    $(document).ready(function() {
        //Se declaran los arreglos que se van a usar
        anios = [];
        meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        areas_encargadas = [];

        //Mediante ajax traemos los anios que tienen solicitudes
        $.ajax({
            url: '<?php echo site_url('reporte/obtener_anios'); ?>',
            async: false,
            success: function(response){
                //Se toma la informacion que viene por JSON
                var lista = JSON.parse(response);
                
                //Se recorre para mostrar los datos
                for(var i in lista){
                    //Se agrega el anio al arreglo
                    anios.push(lista[i].Anio);
                }//Fin for
            }//Fin success
        });//Fin ajax

        //Mediante ajax traemos las areas
        $.ajax({
            url: '<?php echo site_url('reporte/obtener_areas'); ?>',
            async: false,
            success: function(response){
                //Se toma la informacion que viene por JSON
                var areas = JSON.parse(response);
                
                //Se recorre para mostrar los datos
                for(var i in areas){
                    //Se agrega el anio al arreglo
                    //anios.push(lista[i].Area_Encargada);
                    areas_encargadas = 
                    [
                        {
                            name: areas[i].Nombre,
                            data: [5, 9, 1, 0, 4, 7, 3, 6, 0, 1, 0, 5]
                        },
                    ];
                }//Fin for
            }//Fin success
        });//Fin ajax
        /*
        areas_encargadas = [
            {
                name: 'Area 3',
                data: [5, 9, 1, 0, 4, 7, 3, 6, 0, 1, 0, 5],
            }
        ] 
        */
        console.log(areas_encargadas);

        /*
        //Estas seran las areas
        areas_encargadas = [
            {
                name: 'Area 1',
                data: [5, 9, 1, 0, 4, 7, 3, 6, 0, 1, 0, 5]
            },
            {
                name: 'Area 2',
                data: [1,0,4, 8, 10, 0, 8, 4, 1, 5, 3, 8]
            }
        ];
        */

        //recorrido de anios
        for(var anio = 0; anio < anios.length; anio++){
            $("#aqui").html('<div id="container' + anio + '" class="graficos"></div>')
            
            var options = {
                chart: {
                    renderTo: 'container' + anio,
                    type: 'column'
                },
                title: {
                    text: 'Consolidado de atención de solicitudes por área'
                },
                subtitle: {
                    text: "<?php echo 'Generado el '.$this->auditoria_model->formato_fecha(date('d-m-Y')).' - '.date('h:i A'); ?>"
                },
                xAxis: {
                    categories: meses
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Número de solicitudes'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: areas_encargadas
            };//Fin options

            //Se genera el grafico
            var variable  = new Highcharts.Chart(options);
        }//Fin for anios
    });//Fin document.ready
</script>
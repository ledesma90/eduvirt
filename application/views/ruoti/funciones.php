<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" >

var categoria;
var busquedaactual = 0;
var arraybusqueda = [];
var arraylectura = [];
var resultado_actual;
var dataSet = <?= $array_datos ?>;


$select1=$('#select_categoria').select2({
    placeholder: "Selecciona"
});



rellenarselect();


var <?= $dato[0]['update_table'] ?>;


$( "#<?= $dato[0]['update_table'] ?> tfoot th" ).addClass( "footer_numeros" );

$( "#grabar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
    var id;
    try {
        id=<?= $dato[0]['update_table'] ?>.row('.selected').data().persona;
    }
    catch(err) {
        id="default";
    }
    
    var parametros_grabar = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{  1:id, 
                        2: $( "#<?= $dato[0]['update_table'] ?>primer_nombre" ).val(), 
                        3: $( "#<?= $dato[0]['update_table'] ?>segundo_nombre" ).val() 
                    }};
  $.ajax({
    method: "POST",
    url: '<?= $segmento ?>grabardatos',
//============================================================================================================================================
// DATOS A PASAR LA INSERCION DEL REGISTRO O MODIFICAION DEL MISMO SI EXISTE LA CLAVE PRIMARIA                                               1
//============================================================================================================================================
    data: parametros_grabar
//============================================================================================================================================
// FIN                                                                                                                                       1
//============================================================================================================================================
  })
    .done(function( msg ) {
      //alert( "Data Saved: " + msg );
      <?= $dato[0]['update_table'] ?>.ajax.reload();
  });


});

$( "#borrar_dato_<?= $dato[0]['update_table'] ?>" ).click(function() {
    var id;
    try {
        id=<?= $dato[0]['update_table'] ?>.row('.selected').data().id_pais;
    }
    catch(err) {
        alert('Seleccione una fila para borrar, por favor');
    }
    
    var parametros_borrar = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{  1:id 
                    }};
  $.ajax({
    method: "POST",
    url: '<?= $segmento ?>borrardatos',
//============================================================================================================================================
// SE PASA LA CLAVE PRIMARIA/S PARA EL BORRADO DEL REGISTRO                                                                                  2
//============================================================================================================================================
    data: parametros_borrar
//============================================================================================================================================
// FIN                                                                                                                                       2
//============================================================================================================================================
  })
    .done(function( msg ) {
      //alert( "Data Saved: " + msg );
      <?= $dato[0]['update_table'] ?>.ajax.reload();
  });


});



$(document).ready(function() {
    


    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    $('[data-mask]').inputmask();


    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      language: 'es',
      orientation: 'bottom auto'
    });
    
        //Date picker
    $('#datepicker2').datepicker({
      autoclose: true,
      language: 'es',
      orientation: 'bottom auto'
    });
   

    
    
    //alert(dataSet);
    var parametros_inicial = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{1:numero
                    }};
                
               
<?= $dato[0]['update_table'] ?>=$('#<?= $dato[0]['update_table'] ?>').DataTable({
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No hay resultados",
            "info": "Pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "decimal": ",",
            "thousands": ".",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Busqueda:",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Posterior"
            }
        },
        "footerCallback": function( tfoot, data, start, end, display ) {
    var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            
            var decimal = function ( i ) {
                return i+'';
            };
 
            // Total over all pages
            total3 = api.column( 3 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total4 = api.column( 4 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total5 = api.column( 5 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total6 = api.column( 6 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total7 = api.column( 7 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total8 = api.column( 8 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total9 = api.column( 9 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            total10 = api.column( 10 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(decimal(total3).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 4 ).footer() ).html(decimal(total4).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 5 ).footer() ).html(decimal(total5).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 6 ).footer() ).html(decimal(total6).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 7 ).footer() ).html(decimal(total7).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 8 ).footer() ).html(decimal(total8).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 9 ).footer() ).html(decimal(total9).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $( api.column( 10 ).footer() ).html(decimal(total10).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            
  },
        "paging":   true,
        "ordering": true,
        "info":     true,
        "searching": true,
        /*"ajax": {"url": '<?= $segmento ?>result',
        "type":"POST",
        "data":parametros_inicial,
        "dataSrc": ''
        },*/
//============================================================================================================================================
// CONFIGURACION DE COLUMNAS A VISUALIZARCE Y FORMATEO DE LOS MISMOS                                                                         4
//============================================================================================================================================
        //"data":dataSet,
        "columns": [         
            { /*"data": "persona",*/"visible": true,"searchable": true,"sTitle": "id","sWidth": "5px" },
            { /*"data": "primer_nombre",*/"visible": true,"searchable": true,"sTitle": "Cod","sWidth": "5px" },
            { /*"data": "segundo_nombre",*/"visible": true,"searchable": true,"sTitle": "Descripcion"/*,"sWidth": "30%"*/ },
            { /*"data": "primer_apellido",*/"visible": true,"searchable": true,"sTitle": "Base",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "segundo_apellido",*/"visible": true,"searchable": true,"sTitle": "Plan",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "segundo_apellido",*/"visible": true,"searchable": true,"sTitle": "Comparada",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "segundo_apellido",*/"visible": true,"searchable": true,"sTitle": "Dif Uni",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "segundo_apellido",*/"visible": true,"searchable": true,"sTitle": "Dif Gs",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "segundo_apellido",*/"visible": true,"searchable": true,"sTitle": "GS Base",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "segundo_apellido",*/"visible": true,"searchable": true,"sTitle": "Gs Plan",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ },
            { /*"data": "conexion",*/"visible": true,"searchable": true,"sTitle": "Gs Comparada",render: $.fn.dataTable.render.number( '.', ',', 0, '' ),className: "colmanas_numeros"/*,"sWidth": "30%"*/ }
        ]
//============================================================================================================================================
// FIN                                                                                                                                       4
//============================================================================================================================================
        
    } );

    
    
    $('#<?= $dato[0]['update_table'] ?> tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            <?= $dato[0]['update_table'] ?>.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
//============================================================================================================================================
// CONFIGURACION DEL MODAL Y BOTONES DEL MODAL EN BASE A LOS BOTONES POSICIONADOS ENCIMA DE LA DATATABLE                                     5
//============================================================================================================================================
    $('#insertar<?= $dato[0]['update_table'] ?>').click( function () {
        $( "#<?= $dato[0]['update_table'] ?>primer_nombre" ).val('');
        $( "#<?= $dato[0]['update_table'] ?>segundo_nombre" ).val('');
        $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).show();
        $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
        $("#myModal_<?= $dato[0]['update_table'] ?>").modal();       
    } );
    
    $('#modificar<?= $dato[0]['update_table'] ?>').click( function () {
            try {
                $( "#<?= $dato[0]['update_table'] ?>primer_nombre" ).val(<?= $dato[0]['update_table'] ?>.row('.selected').data().primer_nombre);
                $( "#<?= $dato[0]['update_table'] ?>segundo_nombre" ).val(<?= $dato[0]['update_table'] ?>.row('.selected').data().segundo_nombre);
                $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).show();
                $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
                $("#myModal_<?= $dato[0]['update_table'] ?>").modal();
            }
            catch(err) {
                alert('Seleccione una fila para modificar, por favor');
                //alert(err.message);
            }
         
    } );
    
    $('#borrar<?= $dato[0]['update_table'] ?>').click( function () {
            try {
                $( "#<?= $dato[0]['update_table'] ?>primer_nombre" ).val(<?= $dato[0]['update_table'] ?>.row('.selected').data().primer_nombre);
                $( "#<?= $dato[0]['update_table'] ?>segundo_nombre" ).val(<?= $dato[0]['update_table'] ?>.row('.selected').data().segundo_nombre);
                $( "#grabar_marco_<?= $dato[0]['update_table'] ?>" ).hide();
                $( "#borrar_marco_<?= $dato[0]['update_table'] ?>" ).show();
                $("#myModal_<?= $dato[0]['update_table'] ?>").modal();
            }
            catch(err) {
                alert('Seleccione una fila para borrar, por favor');
                //alert(err.message);
            }
         
    } );
    
    $('#leer<?= $dato[0]['update_table'] ?>').click( function () {
            
        var pi_valor='';

            try {
                pi_valor=<?= $dato[0]['update_table'] ?>.row('.selected').data()[0];
            }
            catch(err) {
                //alert('Seleccione una fila para borrar, por favor');
                //alert(err.message);
            }
            
            pi_valor=armarwhere(pi_valor);
            console.log(pi_valor);
         categoria=$( "#select_categoria" ).val();
         if (categoria>0) {}else{alert('No ha seleccionado una categoria..'); return;};
         if (pi_valor=='error'){return;};
        var parametros_lectura = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{1:categoria,
                      2:'',
                      3:'',
                      4:pi_valor
                    }};
         
        $.ajax({
                data:  parametros_lectura,
                url:   '<?= $segmento ?>leer_result',
                type:  'post',
                dataType: "json",
                beforeSend: function () {
                        <?= $dato[0]['update_table'] ?>.clear().draw();
                        Pace.restart();
                        $('.ajax-content').html('<h3 >Procesando, espere por favor... <p class="fa fa-spin fa-refresh"></p></h3>');
                },
                success:  function (response) {
                        
                        sequencialbusqueda('adelante',response,pi_valor);
                        
                        
                                
                }
        });
         
         
         
    } );
    
    $('#recuperar<?= $dato[0]['update_table'] ?>').click( function () {
            
        var fecha_ini='';
        var fecha_fin='';    
            try {
                fecha_ini=$( "#datepicker" ).val();
                fecha_fin=$( "#datepicker2" ).val();
            }
            catch(err) {
                alert('Seleccione una fila para borrar, por favor');
                //alert(err.message);
            }
         
        if (fecha_ini.length==0){alert('No ha seleccionado una fecha inicial'); return;};
        if (fecha_fin.length==0){alert('No ha seleccionado una fecha final'); return;};
         
        var parametros_lectura = {
        tipo        :'<?= $dato[0]['update_table'] ?>',
        parametros  :{1:'',
                      2:$( "#datepicker" ).val(),
                      3:$( "#datepicker2" ).val()
                    }};
         
        $.ajax({
                data:  parametros_lectura,
                url:   '<?= $segmento ?>result',
                type:  'post',
                dataType: "json",
                beforeSend: function () {
                        <?= $dato[0]['update_table'] ?>.clear().draw();
                        Pace.restart();
                        $('.ajax-content').html('<h3 >Procesando, espere por favor... <p class="fa fa-spin fa-refresh"></p></h3>');
                },
                success:  function (response) {
                        //alert(JSON.parse(response)[0]['persona']);
                        

                        //var limit_json = Object.keys(response).length;
                        $('.ajax-content').html(response[0]['msj']);        
                        //for (i = 0; i < limit_json; i++) { 
                        //    <?= $dato[0]['update_table'] ?>.row.add( [response[i]['persona'],response[i]['primer_nombre'],response[i]['segundo_nombre'],response[i]['primer_apellido'],response[i]['segundo_apellido'],response[i]['conexion']] ).draw( false );
                        //};
                                
                }
        });
         
         
         
    } );
    
    $('#atras<?= $dato[0]['update_table'] ?>').click( function () {
    
        sequencialbusqueda('atras');
    
    } );
    
    $('#salir').click( function () {
    
        $.ajax({
                data:  '',
                url:   '<?= $segmento ?>salir',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                   document.location.href = document.location.href;
                }
        });
    
    } );
//============================================================================================================================================
// FIN                                                                                                                                       5
//============================================================================================================================================
    
    
} );

function rellenarselect() {


                    

                          
                        $("#select_categoria option").remove();

                        $.each(dataSet, function (i, item) {
                            if (item.disabled=='false'){
                                $select1.append($('<option>', { 
                                    value: item.id,
                                    text : item.text,
                                    disabled: false
                                }));
                            }
                            else{
                                $select1.append($('<option>', { 
                                    value: item.id,
                                    text : item.text,
                                    disabled: true
                                }));
                            };
                            
                        
                        });

                        $select1.val(null).trigger('change');

                           

    
};

function insert_resultados(datos) {
   var limit_json = Object.keys(datos).length;
                        $('.ajax-content').html('');
                        for (i = 0; i < limit_json; i++) { 
                            <?= $dato[0]['update_table'] ?>.row.add( [datos[i]['id'],datos[i]['codigo'],datos[i]['descripcion'],datos[i]['uni_base'],datos[i]['uni_plan'],datos[i]['uni_comparada'],datos[i]['diferencia_uni'],datos[i]['diferencia_gs'],datos[i]['gs_base'],datos[i]['gs_plan'],datos[i]['gs_comparada']] ).draw( false );
                        };                        

    
};

function sequencialbusqueda(datos,lectura,pi_valor) {
               
    var direccion='';
        if (datos=='adelante'){
            busquedaactual++;
            
            $.each(dataSet, function (i, item) {
                if(item.id==categoria){
                    item.disabled='true';
                    rellenarselect();
                    arraybusqueda[busquedaactual]=[categoria,lectura,pi_valor];
                    direccion=$('#direccion').html()+'>'+item.text;
                };
                
            });
            $('#direccion').html(direccion);
            $('#atras<?= $dato[0]['update_table'] ?>').removeClass( "disabled" );
            insert_resultados(lectura);
            
        };

        if (datos=='atras'){
            
            <?= $dato[0]['update_table'] ?>.clear().draw();
            $.each(dataSet, function (i, item) {
                if(item.id==arraybusqueda[busquedaactual][0]){
                    item.disabled='false';
                    rellenarselect();
                };
            });
            
            busquedaactual--;
            
            if(busquedaactual==0){
                <?= $dato[0]['update_table'] ?>.clear().draw();
                $('#atras<?= $dato[0]['update_table'] ?>').addClass( "disabled" );
            }
            else{
            
                
                insert_resultados(arraybusqueda[busquedaactual][1]);
            };
            
            
        };
    
};

function armarwhere(datos) {
    var cadenawhere='';
    
    if (datos>0){
        
        if(busquedaactual>1){
            cadenawhere=arraybusqueda[busquedaactual][2]+' and ';
        };
        
        $.each(dataSet, function (i, item) {
                if(item.id==arraybusqueda[busquedaactual][0]){
                    cadenawhere=cadenawhere+ item.col_prin + "=" + datos;
                };
        });
        return cadenawhere.replace(/ /g, "+");
    }
    else{
        if(busquedaactual>0){
            alert('Debe seleccionar una fila leer');
            return 'error'; 
        };
        return '';  
    };
 
    
};


</script>
